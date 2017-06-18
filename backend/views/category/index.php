<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
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
                    'attribute' => 'name',
                    'headerOptions' => ['class' => 'text-center'],
                    'filterInputOptions' => ['class' => 'form-control form-control-sm'],
                ],
                [
                    'attribute' => 'key',
                    'headerOptions' => ['class' => 'text-center'],
                    'filterInputOptions' => ['class' => 'form-control form-control-sm'],
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
