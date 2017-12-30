<?php
namespace common\rest;

use Yii;

/**
 * Serializer converts resource objects and collections into array representation.
 *
 * @author Cosmo<daixianceng@gmail.com>
 */
class Serializer extends \yii\rest\Serializer
{
    /**
     * @inheritdoc
     */
    public function serialize($data)
    {
        if ($data instanceof DataInterface) {
            return $this->serializeData($data);
        } else {
            return parent::serialize($data);
        }
    }

    /**
     * Serializes a data object.
     * @param DataInterface $data
     * @return array the array representation of the data
     */
    protected function serializeData($data)
    {
        $dataArray = $data->toArray([], [], false);

        foreach ($dataArray as $field => $definition) {
            $dataArray[$field] = static::serialize($definition);
        }

        return $dataArray;
    }
}
