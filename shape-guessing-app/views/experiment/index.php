<?php

/** @var yii\web\View $this */
/** @var app\models\Experiment $experiment */
/** @var app\models\Shape[] $shapes */

use yii\bootstrap5\Html;

$this->title = 'Shape Guessing Experiment';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
.shape-button {
    border: 2px solid #333;
    background: white;
    padding: 20px;
    margin: 10px;
    cursor: pointer;
    transition: all 0.3s;
    border-radius: 10px;
}

.shape-button:hover {
    background: #f0f0f0;
    transform: scale(1.05);
}

.shape-button img {
    width: 100px;
    height: 100px;
}

.experiment-info {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
}

.trial-counter {
    font-size: 24px;
    font-weight: bold;
    color: #007bff;
}
");
?>

<div class="experiment-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="experiment-info">
        <div class="row">
            <div class="col-md-6">
                <h4>Welcome, <?= Html::encode(Yii::$app->user->identity->username) ?>!</h4>
                <p>You need to guess which shape is stored in the database.</p>
                <p>Click on the shape you think is correct.</p>
            </div>
            <div class="col-md-6 text-end">
                <div class="trial-counter">
                    Trial: <?= $experiment->current_trial ?> / 20
                </div>
                <div>
                    Correct so far: <?= $experiment->correct_count ?>
                </div>
            </div>
        </div>
    </div>

    <div class="shapes-container text-center">
        <h3>Choose a shape:</h3>
        <div class="row justify-content-center">
            <?php foreach ($shapes as $shape): ?>
                <div class="col-md-4">
                    <?= Html::beginForm(['guess'], 'post') ?>
                        <?= Html::hiddenInput('shape_id', $shape->id) ?>
                        <button type="submit" class="shape-button">
                            <img src="<?= $shape->image_path ?>" alt="<?= Html::encode($shape->name) ?>">
                            <div style="margin-top: 10px; font-weight: bold;">
                                <?= Html::encode(ucfirst($shape->name)) ?>
                            </div>
                        </button>
                    <?= Html::endForm() ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="mt-4">
        <div class="alert alert-info">
            <strong>Instructions:</strong>
            <ul>
                <li>You will complete 20 trials in total</li>
                <li>In each trial, guess which shape is stored in the database</li>
                <li>Click on the shape button to make your guess</li>
                <li>After 20 trials, you will see your results</li>
            </ul>
        </div>
    </div>
</div>