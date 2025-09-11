<?php

/** @var yii\web\View $this */
/** @var string $histogramPath */
/** @var int $totalExperiments */
/** @var float $probability */
/** @var array $correctCounts */

use yii\bootstrap5\Html;

$this->title = 'Histogram Analysis';
$this->params['breadcrumbs'][] = ['label' => 'Statistics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="statistics-histogram">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($totalExperiments > 0): ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Distribution of Correct Guesses</h4>
                    </div>
                    <div class="card-body text-center">
                        <?php if (file_exists(Yii::getAlias('@webroot') . $histogramPath)): ?>
                            <img src="<?= $histogramPath ?>?v=<?= time() ?>" alt="Histogram" class="img-fluid">
                        <?php else: ?>
                            <div class="alert alert-warning">
                                Histogram could not be generated. Please make sure R is properly installed.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Statistical Analysis</h4>
                    </div>
                    <div class="card-body">
                        <h5>Summary:</h5>
                        <ul>
                            <li><strong>Total Experiments:</strong> <?= $totalExperiments ?></li>
                            <li><strong>Average Correct:</strong> <?= number_format(array_sum($correctCounts) / count($correctCounts), 2) ?></li>
                            <li><strong>Expected (Random):</strong> 6.67 (20 × 1/3)</li>
                        </ul>
                        
                        <h5>Randomness Test:</h5>
                        <p><strong>P-value:</strong> <?= number_format($probability, 4) ?></p>
                        
                        <?php if ($probability < 0.05): ?>
                            <div class="alert alert-warning">
                                <strong>Significant deviation from random!</strong><br>
                                The results suggest non-random behavior (p < 0.05).
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <strong>Consistent with random guessing.</strong><br>
                                The results do not significantly differ from random chance (p ≥ 0.05).
                            </div>
                        <?php endif; ?>
                        
                        <h5>Distribution:</h5>
                        <small>
                            <?php
                            $distribution = array_count_values($correctCounts);
                            ksort($distribution);
                            foreach ($distribution as $correct => $count) {
                                echo "$correct correct: $count users<br>";
                            }
                            ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <h4>No Data Available</h4>
            <p>No completed experiments found. Users need to complete the shape guessing experiment first.</p>
        </div>
    <?php endif; ?>

    <div class="mt-4">
        <div class="row">
            <div class="col-md-6">
                <?= Html::a('← Back to Statistics', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>
            <div class="col-md-6 text-end">
                <?= Html::a('Download Raw Data', ['export-csv'], [
                    'class' => 'btn btn-success',
                    'data-pjax' => '0'
                ]) ?>
            </div>
        </div>
    </div>
</div>