<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="container">

    <div class="row pt-5">
        <div class="col">
            <h1 class="display-4 mb-3"><?= Html::encode($this->title) ?></h1>

            <p class="lead text-danger">
                <?= nl2br(Html::encode($message)) ?>
            </p>

            <p>
                <em>The above error occurred while the Web server was processing your request.</em>
            </p>
            <p>
                <em>Please <abbr title="Email: <?= Yii::$app->params['supportEmail'] ?>">contact us</abbr> if you think this is a server error. Thank you.</em>
            </p>
        </div>
    </div>

</div>
