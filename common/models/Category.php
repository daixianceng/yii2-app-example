<?php
namespace common\models;

use Yii;
use yii\db\Query;
use himiklab\sortablegrid\SortableGridBehavior;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $id
 * @property string $key
 * @property string $name
 * @property string $sequence
 */
class Category extends \yii\db\ActiveRecord implements SortInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public static function sortField()
    {
        return 'sequence';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => self::sortField(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'name'], 'required'],
            [['key', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'name' => 'Name',
            'sequence' => 'Sequence',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['categoryId' => 'id']);
    }

    /**
     * Finds category by key
     *
     * @param string $key
     * @return static|null
     */
    public static function findByKey($key)
    {
        return static::findOne(['key' => $key]);
    }

    /**
     * Finds category id-name pairs
     *
     * @return array
     */
    public static function findKeyValuePairs()
    {
        return (new Query())
            ->select(['id', 'name'])
            ->from(static::tableName())
            ->orderBy(['id' => SORT_ASC])
            ->createCommand()
            ->queryAll(\PDO::FETCH_KEY_PAIR);
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->name;
    }
}
