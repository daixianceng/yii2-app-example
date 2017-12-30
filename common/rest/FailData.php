<?php
namespace common\rest;

use Yii;

/**
 * FailData
 *
 * @author Cosmo<daixianceng@gmail.com>
 */
class FailData extends Data
{
    /**
     * @inheritdoc
     */
    public function __construct($data = null)
    {
        parent::__construct(self::STATUS_FAIL, $data);
    }
}
