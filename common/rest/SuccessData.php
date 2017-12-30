<?php
namespace common\rest;

use Yii;

/**
 * SuccessData
 *
 * @author Cosmo<daixianceng@gmail.com>
 */
class SuccessData extends Data
{
    /**
     * @inheritdoc
     */
    public function __construct($data = null)
    {
        parent::__construct(self::STATUS_SUCCESS, $data);
    }
}
