<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Update User: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update User';
?>
<div class="row">
    <div class="col-lg-8">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>