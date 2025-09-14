<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\models\Experiment;
use app\models\Shape;

class ExperimentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Experiment index action.
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        // Check if user wants to start a new experiment
        if (Yii::$app->request->get('new') == '1') {
            $experiment = new Experiment();
            $experiment->user_id = Yii::$app->user->id;
            $experiment->correct_sequence = Experiment::generateRandomSequence();
            $experiment->save();
        } else {
            $experiment = Experiment::findOne([
                'user_id' => Yii::$app->user->id,
                'is_completed' => false
            ]);

            if (!$experiment) {
                // Create new experiment if none exists
                $experiment = new Experiment();
                $experiment->user_id = Yii::$app->user->id;
                $experiment->correct_sequence = Experiment::generateRandomSequence();
                $experiment->save();
            }
        }

        if ($experiment->is_completed) {
            return $this->redirect(['results', 'id' => $experiment->id]);
        }

        $shapes = Shape::find()->all();

        return $this->render('index', [
            'experiment' => $experiment,
            'shapes' => $shapes,
        ]);
    }

    /**
     * Make guess action.
     *
     * @return \yii\web\Response
     */
    public function actionGuess()
    {
        $shapeId = Yii::$app->request->post('shape_id');
        
        $experiment = Experiment::findOne([
            'user_id' => Yii::$app->user->id,
            'is_completed' => false
        ]);

        if (!$experiment) {
            throw new NotFoundHttpException('Experiment not found.');
        }

        $experiment->addUserGuess($shapeId);
        $experiment->save();

        if ($experiment->is_completed) {
            return $this->redirect(['results', 'id' => $experiment->id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Results action.
     *
     * @param integer $id
     * @return string
     */
    public function actionResults($id)
    {
        $experiment = Experiment::findOne([
            'id' => $id,
            'user_id' => Yii::$app->user->id
        ]);

        if (!$experiment) {
            throw new NotFoundHttpException('Experiment not found.');
        }

        $shapes = Shape::find()->indexBy('id')->all();
        $results = $experiment->getComparisonResults();

        return $this->render('results', [
            'experiment' => $experiment,
            'results' => $results,
            'shapes' => $shapes,
        ]);
    }
}