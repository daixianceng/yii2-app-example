<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'key',
            [
                'attribute' => 'categoryId',
                'value' => $model->category,
            ],
            'tags',
            [
                'attribute' => 'authorId',
                'value' => $model->author,
            ],
            [
                'attribute' => 'status',
                'value' => $model->statusLabel,
            ],
            'createdAt:datetime',
            'updatedAt:datetime',
        ],
    ]) ?>

</div>
