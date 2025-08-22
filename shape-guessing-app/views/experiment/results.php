<?php

/** @var yii\web\View $this */
/** @var app\models\Experiment $experiment */
/** @var array $results */
/** @var app\models\Shape[] $shapes */

use yii\bootstrap5\Html;

$this->title = 'Experiment Results';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
.result-correct {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
}

.result-incorrect {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
}

.shape-mini {
    width: 30px;
    height: 30px;
    display: inline-block;
    margin-right: 5px;
}

.results-summary {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
}

.trial-row {
    padding: 8px;
    margin: 2px 0;
    border-radius: 5px;
}
");
?>

<div class="experiment-results">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="results-summary">
        <h3>Experiment Completed!</h3>
        <div class="row">
            <div class="col-md-6">
                <h4>Your Performance:</h4>
                <p><strong>Correct Guesses:</strong> <?= $experiment->correct_count ?> out of 20</p>
                <p><strong>Accuracy:</strong> <?= number_format(($experiment->correct_count / 20) * 100, 1) ?>%</p>
            </div>
            <div class="col-md-6">
                <h4>Experiment Info:</h4>
                <p><strong>Started:</strong> <?= date('Y-m-d H:i:s', strtotime($experiment->created_at)) ?></p>
                <p><strong>Completed:</strong> <?= date('Y-m-d H:i:s', strtotime($experiment->completed_at)) ?></p>
            </div>
        </div>
    </div>

    <h3>Trial by Trial Results:</h3>
    <div class="results-table">
        <div class="row">
            <div class="col-md-2"><strong>Trial</strong></div>
            <div class="col-md-3"><strong>Your Choice</strong></div>
            <div class="col-md-3"><strong>Correct Answer</strong></div>
            <div class="col-md-2"><strong>Result</strong></div>
            <div class="col-md-2"><strong>Status</strong></div>
        </div>
        <hr>
        
        <?php foreach ($results as $result): ?>
            <div class="row trial-row <?= $result['is_correct'] ? 'result-correct' : 'result-incorrect' ?>">
                <div class="col-md-2">
                    <strong><?= $result['trial'] ?></strong>
                </div>
                <div class="col-md-3">
                    <img src="<?= $shapes[$result['user']]->image_path ?>" class="shape-mini" alt="<?= $shapes[$result['user']]->name ?>">
                    <?= Html::encode(ucfirst($shapes[$result['user']]->name)) ?>
                </div>
                <div class="col-md-3">
                    <img src="<?= $shapes[$result['correct']]->image_path ?>" class="shape-mini" alt="<?= $shapes[$result['correct']]->name ?>">
                    <?= Html::encode(ucfirst($shapes[$result['correct']]->name)) ?>
                </div>
                <div class="col-md-2">
                    <?= $result['is_correct'] ? '✓' : '✗' ?>
                </div>
                <div class="col-md-2">
                    <span class="badge <?= $result['is_correct'] ? 'bg-success' : 'bg-danger' ?>">
                        <?= $result['is_correct'] ? 'Correct' : 'Incorrect' ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-4">
        <div class="row">
            <div class="col-md-6">
                <?= Html::a('Start New Experiment', ['index', 'new' => 1], ['class' => 'btn btn-primary']) ?>
            </div>
            <div class="col-md-6 text-end">
                <?= Html::a('View Statistics', ['/statistics/index'], ['class' => 'btn btn-info']) ?>
            </div>
        </div>
    </div>
</div>