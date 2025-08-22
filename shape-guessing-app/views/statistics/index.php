<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'Statistics';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="statistics-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Raw Data Export</h4>
                </div>
                <div class="card-body">
                    <p>Download all experiment data as a CSV file for further analysis.</p>
                    <?= Html::a('Download CSV', ['export-csv'], [
                        'class' => 'btn btn-success',
                        'data-pjax' => '0'
                    ]) ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Histogram Analysis</h4>
                </div>
                <div class="card-body">
                    <p>View distribution of correct guesses and statistical analysis.</p>
                    <?= Html::a('View Histogram', ['histogram'], [
                        'class' => 'btn btn-primary'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="alert alert-info">
            <h5>About the Statistics</h5>
            <ul>
                <li><strong>CSV Export:</strong> Contains raw data from all completed experiments including user choices, correct answers, and timestamps.</li>
                <li><strong>Histogram:</strong> Shows the distribution of correct guesses across all users with comparison to expected random distribution.</li>
                <li><strong>Statistical Analysis:</strong> Includes probability calculation to assess if the observed results differ significantly from random chance.</li>
            </ul>
        </div>
    </div>
</div>