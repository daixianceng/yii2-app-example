<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use common\widgets\Breadcrumbs;
use common\widgets\Alert;
?>

<?php $this->beginContent('@app/views/layouts/base.php'); ?>

<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#topNavbarContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand" href="/"><?= Html::encode(Yii::$app->name) ?></a>

    <div class="collapse navbar-collapse" id="topNavbarContent">

        <?= Nav::widget([
            'items' => [
                [
                    'label' => Html::tag('i', '', ['class' => 'fa fa-pencil']) . ' Writing',
                    'url' => ['/post/create'],
                    'encode' => false,
                ],
            ],
            'options' => [
                'class' => 'navbar-nav mr-auto',
            ],
        ]); ?>

        <?= Nav::widget([
            'items' => [
                [
                    'label' => Html::tag('i', '', ['class' => 'fa fa-user']) . ' Profile',
                    'dropDownOptions' => [
                        'class' => 'dropdown-menu-right'
                    ],
                    'items' => [
                        [
                            'label' => 'View profile',
                            'url' => ['/user/view', 'id' => 1],
                        ],
                        '<div class="dropdown-divider"></div>',
                        [
                            'label' => 'Logout',
                            'url' => ['/site/logout'],
                        ],
                    ],
                    'encode' => false,
                ],
            ],
            'options' => [
                'class' => 'navbar-nav',
            ],
        ]); ?>

    </div>

</nav>

<div class="container-fluid">

    <div class="row">

        <nav class="col-sm-3 col-md-2 bg-faded sidebar pt-3 pb-3">

            <?= Nav::widget([
                'items' => [
                    [
                        'label' => 'Overview',
                        'url' => ['/overview/index'],
                    ],
                    [
                        'label' => 'Categories',
                        'url' => ['/category/index'],
                        'active' => Yii::$app->controller->id === 'category',
                    ],
                    [
                        'label' => 'Posts',
                        'url' => ['/post/index'],
                        'active' => Yii::$app->controller->id === 'post',
                    ],
                    [
                        'label' => 'Users',
                        'url' => ['/user/index'],
                        'active' => Yii::$app->controller->id === 'user',
                    ],
                ],
                'options' => [
                    'class' => 'nav nav-pills flex-column',
                ],
            ]); ?>

        </nav>

        <main class="col-sm-9 col-md-10 pt-3">

            <h1 class="display-4 mb-3"><?= Html::encode($this->title) ?></h1>

            <?= Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'] ?? [],
            ]) ?>

            <?= Alert::widget() ?>

            <?= $content ?>

        </main>

    </div>

</div>

<?php $this->endContent(); ?>
