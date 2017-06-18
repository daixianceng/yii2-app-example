<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;

$this->title = 'Overview';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>

    <?= Highcharts::widget([
        'options' => [
            'title' => ['text' => 'Daily Visitors'],
            'xAxis' => [
              'categories' => ['Apples', 'Bananas', 'Oranges']
            ],
            'yAxis' => [
              'title' => ['text' => 'Number of visitors']
            ],
            'series' => [
              ['name' => 'Jane', 'data' => [1, 0, 4]],
            ]
        ]
    ]); ?>

    <?= Highcharts::widget([
        'options' => [
            'title' => ['text' => 'Daily Posts'],
            'xAxis' => [
              'categories' => ['Apples', 'Bananas', 'Oranges']
            ],
            'yAxis' => [
              'title' => ['text' => 'Number of posts']
            ],
            'series' => [
              ['name' => 'Jane', 'data' => [1, 0, 4]],
            ]
        ]
    ]); ?>

</div>