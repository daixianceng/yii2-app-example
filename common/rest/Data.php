<?php
namespace common\rest;

use Yii;
use yii\base\Arrayable;
use yii\base\ArrayableTrait;

/**
 * Data
 *
 * @author Cosmo<daixianceng@gmail.com>
 */
abstract class Data implements DataInterface, Arrayable
{
    use ArrayableTrait;

    /**
     * @var string the status field.
     */
    public $status;

    /**
     * @var mixed the data field.
     */
    public $data;

    /**
     * Constructor.
     * @param string status
     * @param mixed data
     */
    public function __construct($status, $data = null)
    {
        $this->status = $status;
        $this->data = $data;
    }
}
