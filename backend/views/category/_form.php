<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div>

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'key')->hint('The category key used by URL.') ?>

    <div class="form-group row">
        <div class="offset-sm-3 col-sm-9">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
