<?php
namespace common\grid;

use Yii;
use yii\helpers\Html;

/**
 * ActionColumn is a column for the [[GridView]] widget that displays buttons for viewing and manipulating the items.
 *
 * @author Cosmo <daixianceng@gmail.com>
 */
class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * @var string the default button size used for displaying large(lg) or small(sm) buttons.
     */
    public $defaultButtonSize;

    /**
     * @inheritdoc
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye');
        $this->initDefaultButton('update', 'pencil');
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        $btnStyle = 'primary';
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        $btnStyle = 'warning';
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        $btnStyle = 'danger';
                        break;
                    default:
                        $title = ucfirst($name);
                        $btnStyle = 'primary';
                }
                $options = array_merge([
                    'class' => "btn btn-$btnStyle" . ($this->defaultButtonSize ? " btn-{$this->defaultButtonSize}" : ''),
                    'role' => 'button',
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('i', '', ['class' => "fa fa-$iconName"]);
                return Html::a("$icon $title", $url, $options);
            };
        }
    }
}
