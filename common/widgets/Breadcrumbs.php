<?php
namespace common\widgets;

/**
 * Bootstrap breadcrumbs
 */
class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    /**
     * @inheritdoc
     */
    public $itemTemplate = "<li class=\"breadcrumb-item\">{link}</li>\n";
    /**
     * @inheritdoc
     */
    public $activeItemTemplate = "<li class=\"breadcrumb-item active\">{link}</li>\n";
}
