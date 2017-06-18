<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Post;
use common\models\Category;
use kartik\select2\Select2;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\bootstrap\ActiveForm */

$allTags = Post::findAllTags();
?>

<div>

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'key')->hint('Will be used to URL') ?>

    <?= $form->field($model, 'categoryId')->dropDownList(Category::findKeyValuePairs()) ?>

    <?= $form->field($model, 'tagCollection')->widget(Select2::classname(), [
        'data' => array_combine($allTags, $allTags),
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10,
        ],
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList(Post::getStatusLabels()) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 5]) ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'allowedContent' => true,
        ],
    ]) ?>

    <div class="form-group row">
        <div class="offset-sm-3 col-sm-9">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
