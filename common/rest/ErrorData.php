<?php
namespace common\rest;

use Yii;

/**
 * ErrorData
 *
 * @author Cosmo<daixianceng@gmail.com>
 */
class ErrorData extends Data
{
    /**
     * @inheritdoc
     */
    public function __construct($data = null)
    {
        parent::__construct(self::STATUS_ERROR, $data);
    }
}
