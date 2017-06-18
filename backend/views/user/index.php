<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'table table-sm table-striped table-bordered text-center',
            ],
            'summaryOptions' => ['tag' => 'p', 'class' => 'text-right text-muted font-italic'],
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['class' => 'text-center'],
                ],
                [
                    'attribute' => 'username',
                    'headerOptions' => ['class' => 'text-center'],
                    'filterInputOptions' => ['class' => 'form-control form-control-sm'],
                ],
                [
                    'attribute' => 'email',
                    'headerOptions' => ['class' => 'text-center'],
                    'filterInputOptions' => ['class' => 'form-control form-control-sm'],
                ],
                [
                    'attribute' => 'status',
                    'headerOptions' => ['class' => 'text-center'],
                    'filter' => User::getStatusLabels(),
                    'filterInputOptions' => ['class' => 'form-control form-control-sm'],
                    'value' => function ($model, $key, $index, $column) {
                        return $model->statusLabel;
                    },
                ],
                [
                    'attribute' => 'createdAt',
                    'headerOptions' => ['class' => 'text-center'],
                    'filter' => DateRangePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'createTimeRange',
                        'convertFormat' => true,
                        'options' => ['class' => 'form-control form-control-sm'],
                        'pluginOptions' => [
                            'timePicker' => true,
                            'timePickerIncrement' => 10,
                            'locale' => ['format' => 'Y-m-d h:i:s'],
                        ],
                    ]),
                    'format' => ['date', 'php:Y-m-d H:i:s'],
                ],
                [
                    'class' => 'common\grid\ActionColumn',
                    'header' => 'Operation',
                    'headerOptions' => ['class' => 'text-center'],
                    'defaultButtonSize' => 'sm',
                ],
            ],
        ]); ?>

    <?php Pjax::end(); ?>

</div>
