<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Json;
use yii\filters\AccessControl;
use app\models\Experiment;
use app\models\User;

class StatisticsController extends Controller
{
    /**
     * Statistics index action.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Export CSV action.
     *
     * @return \yii\web\Response
     */
    public function actionExportCsv()
    {
        $experiments = Experiment::find()
            ->with('user')
            ->where(['is_completed' => true])
            ->all();

        $csvData = [];
        $csvData[] = ['User ID', 'Username', 'Email', 'Correct Count', 'Correct Sequence', 'User Sequence', 'Created At', 'Completed At'];

        foreach ($experiments as $experiment) {
            $csvData[] = [
                $experiment->user_id,
                $experiment->user->username,
                $experiment->user->email,
                $experiment->correct_count,
                $experiment->correct_sequence,
                $experiment->user_sequence,
                $experiment->created_at,
                $experiment->completed_at,
            ];
        }

        $filename = 'shape_experiment_data_' . date('Y-m-d_H-i-s') . '.csv';
        
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/csv; charset=UTF-8');
        Yii::$app->response->headers->add('Content-Disposition', 'attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        foreach ($csvData as $row) {
            fputcsv($output, $row);
        }
        fclose($output);

        return Yii::$app->response;
    }

    /**
     * Generate histogram action.
     *
     * @return string
     */
    public function actionHistogram()
    {
        // Get all completed experiments
        $experiments = Experiment::find()
            ->where(['is_completed' => true])
            ->all();

        $correctCounts = [];
        foreach ($experiments as $experiment) {
            $correctCounts[] = $experiment->correct_count;
        }

        // Prepare data for R script
        $dataFile = Yii::getAlias('@runtime/histogram_data.csv');
        $csvData = "correct_count\n";
        foreach ($correctCounts as $count) {
            $csvData .= $count . "\n";
        }
        file_put_contents($dataFile, $csvData);

        // Generate histogram using R
        $rScript = Yii::getAlias('@runtime/generate_histogram.R');
        $this->createRScript($rScript, $dataFile);
        
        $histogramPath = Yii::getAlias('@webroot/images/histogram.png');
        exec("Rscript $rScript > /dev/null 2>&1");

        // Calculate probability (chi-square test for randomness)
        $probability = $this->calculateRandomnessProbability($correctCounts);

        return $this->render('histogram', [
            'histogramPath' => '/images/histogram.png',
            'totalExperiments' => count($experiments),
            'probability' => $probability,
            'correctCounts' => $correctCounts,
        ]);
    }

    /**
     * Create R script for histogram generation
     *
     * @param string $scriptPath
     * @param string $dataPath
     */
    private function createRScript($scriptPath, $dataPath)
    {
        $histogramPath = Yii::getAlias('@webroot/images/histogram.png');
        
        $rCode = "
# Load data
data <- read.csv('$dataPath')

# Create histogram
png('$histogramPath', width=800, height=600)
hist(data\$correct_count, 
     breaks=0:20, 
     main='Distribution of Correct Guesses', 
     xlab='Number of Correct Guesses (out of 20)', 
     ylab='Number of Users',
     col='lightblue',
     border='black')

# Add expected line for random guessing (binomial distribution)
expected_prob <- dbinom(0:20, 20, 1/3)
total_users <- nrow(data)
if(total_users > 0) {
    expected_counts <- expected_prob * total_users
    lines(0:20, expected_counts, col='red', lwd=2, type='l')
    legend('topright', c('Observed', 'Expected (Random)'), col=c('lightblue', 'red'), lty=c(1,1), lwd=c(1,2))
}

dev.off()
";
        
        file_put_contents($scriptPath, $rCode);
    }

    /**
     * Calculate probability of observing this distribution by chance
     *
     * @param array $correctCounts
     * @return float
     */
    private function calculateRandomnessProbability($correctCounts)
    {
        if (empty($correctCounts)) {
            return 1.0;
        }

        // Count frequencies
        $frequencies = array_count_values($correctCounts);
        $totalUsers = count($correctCounts);
        
        // Expected frequencies for random guessing (binomial distribution with p=1/3)
        $chiSquare = 0;
        for ($i = 0; $i <= 20; $i++) {
            $observed = isset($frequencies[$i]) ? $frequencies[$i] : 0;
            $expected = $totalUsers * $this->binomialProbability(20, $i, 1/3);
            
            if ($expected > 0) {
                $chiSquare += pow($observed - $expected, 2) / $expected;
            }
        }

        // Approximate p-value (simplified calculation)
        // For proper calculation, you'd use chi-square distribution
        $degreesOfFreedom = 20; // 21 categories - 1
        $pValue = 1 - (1 / (1 + exp(-($chiSquare - $degreesOfFreedom) / 2)));
        
        return max(0, min(1, $pValue));
    }

    /**
     * Calculate binomial probability
     *
     * @param int $n
     * @param int $k
     * @param float $p
     * @return float
     */
    private function binomialProbability($n, $k, $p)
    {
        if ($k > $n || $k < 0) return 0;
        
        $coefficient = 1;
        for ($i = 0; $i < $k; $i++) {
            $coefficient *= ($n - $i) / ($i + 1);
        }
        
        return $coefficient * pow($p, $k) * pow(1 - $p, $n - $k);
    }
}