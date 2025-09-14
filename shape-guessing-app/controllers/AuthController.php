<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\LoginForm;
use app\models\Experiment;

class AuthController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Register action.
     *
     * @return string|\yii\web\Response
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new User(['scenario' => 'register']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Create experiment with random sequence for the new user
            $experiment = new Experiment();
            $experiment->user_id = $model->id;
            $experiment->correct_sequence = Experiment::generateRandomSequence();
            $experiment->save();

            Yii::$app->user->login($model);
            return $this->redirect(['experiment/index']);
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['experiment/index']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}