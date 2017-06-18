<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = 'Update Category: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Category';
?>
<div class="row">
    <div class="col-lg-8">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>