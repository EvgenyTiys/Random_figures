<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'Shape Guessing Experiment';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Shape Guessing Experiment</h1>

        <p class="lead">Test your intuition by guessing which shapes are stored in our database!</p>

        <?php if (Yii::$app->user->isGuest): ?>
            <p>
                <?= Html::a('Register to Start', ['/auth/register'], ['class' => 'btn btn-lg btn-success']) ?>
                <?= Html::a('Login', ['/auth/login'], ['class' => 'btn btn-lg btn-primary']) ?>
            </p>
        <?php else: ?>
            <p>
                <?= Html::a('Start Experiment', ['/experiment/index'], ['class' => 'btn btn-lg btn-success']) ?>
            </p>
        <?php endif; ?>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <h2>How it Works</h2>

                <p>Register and participate in our shape guessing experiment. You'll be shown three shapes (circle, triangle, square) and need to guess which one is stored in the database for each of 20 trials.</p>

                <p><?= Html::a('Learn More &raquo;', ['/auth/register'], ['class' => 'btn btn-outline-secondary']) ?></p>
            </div>
            <div class="col-lg-4 mb-3">
                <h2>Your Results</h2>

                <p>After completing 20 trials, you'll see detailed results showing which shapes you chose, which were correct, and your overall accuracy. Results are color-coded for easy interpretation.</p>

                <p><?= Html::a('View Statistics &raquo;', ['/statistics/index'], ['class' => 'btn btn-outline-secondary']) ?></p>
            </div>
            <div class="col-lg-4 mb-3">
                <h2>Statistical Analysis</h2>

                <p>Explore aggregated data from all participants through CSV downloads and histogram visualizations. See how your performance compares to random chance and other users.</p>

                <p><?= Html::a('View Analysis &raquo;', ['/statistics/histogram'], ['class' => 'btn btn-outline-secondary']) ?></p>
            </div>
        </div>

    </div>
</div>
