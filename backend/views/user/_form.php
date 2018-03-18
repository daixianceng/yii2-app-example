<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div>

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'avatarFile')->widget(FileInput::className(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'showUpload' => false,
            'browseLabel' => 'Select Image',
            'removeLabel' => 'Remove',
            'initialPreview' => $model->isNewRecord ? [] : [$model->avatarURL],
            'initialPreviewAsData' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'passwordNew')->passwordInput()->hint('Required when creating new one.') ?>

    <?= $form->field($model, 'email')->input('email') ?>

    <?= $form->field($model, 'status')->dropDownList(User::getStatusLabels()) ?>

    <div class="form-group row">
        <div class="offset-sm-3 col-sm-9">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
