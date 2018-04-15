<?php
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use himiklab\sortablegrid\SortableGridBehavior;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property string $id
 * @property string $categoryId
 * @property string $title
 * @property string $key
 * @property string $tags
 * @property string $intro
 * @property string $content
 * @property string $authorId
 * @property integer $status
 * @property string $sequence
 * @property string $createdAt
 * @property string $updatedAt
 * @property array $tagCollection
 */
class Post extends \yii\db\ActiveRecord implements StatusInterface, SortInterface
{
    /**
     * @property array
     */
    public $tagCollection = [];

    /**
     * @property array|null
     */
    private static $statusLabels;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
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
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
            ],
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
            [['categoryId', 'title', 'key', 'tagCollection', 'intro', 'content', 'status'], 'required'],

            [['categoryId'], 'integer'],
            [['categoryId'], 'exist', 'targetClass' => Category::className(), 'targetAttribute' => 'id'],

            [['title', 'key'], 'trim'],
            [['title', 'key'], 'string', 'max' => 255],

            [['key'], 'unique'],

            [['tagCollection'], 'each', 'rule' => ['string', 'max' => 10]],
            [['tagCollection'], 'filter', 'filter' => 'array_unique'],

            [['intro'], 'trim'],
            [['intro'], 'string', 'length' => [10, 140]],

            [['content'], 'string'],

            [['status'], 'default', 'value' => self::STATUS_ENABLED],
            [['status'], 'in', 'range' => [self::STATUS_ENABLED, self::STATUS_DISABLED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categoryId' => 'Category',
            'title' => 'Title',
            'key' => 'Key',
            'tags' => 'Tags',
            'tagCollection' => 'Tags',
            'intro' => 'Introduction',
            'content' => 'Content',
            'authorId' => 'Author',
            'status' => 'Status',
            'sequence' => 'Sequence',
            'createdAt' => 'Create Time',
            'updatedAt' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'categoryId',
            'title',
            'key',
            'tags',
            'tagCollection',
            'intro',
            'content',
            'authorId',
            'status',
            'statusLabel',
            'isEnabled',
            'sequence',
            'createdAt',
            'updatedAt',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'categoryId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'authorId']);
    }

    /**
     * @inheritdoc
     */
    public function enable()
    {
        $this->status = self::STATUS_ENABLED;
    }

    /**
     * @inheritdoc
     */
    public function disable()
    {
        $this->status = self::STATUS_DISABLED;
    }

    /**
     * @inheritdoc
     */
    public function getIsEnabled()
    {
        return $this->status === self::STATUS_ENABLED;
    }

    /**
     * Gets status labels
     *
     * @return array
     */
    public static function getStatusLabels()
    {
        if (self::$statusLabels === null) {
            self::$statusLabels = [
                self::STATUS_ENABLED => 'Enabled',
                self::STATUS_DISABLED => 'Disabled',
            ];
        }

        return self::$statusLabels;
    }

    /**
     * Gets status label of the model
     *
     * @return string|null
     */
    public function getStatusLabel()
    {
        $labels = static::getStatusLabels();

        return $labels[$this->status] ?? null;
    }

    /**
     * Finds post by key
     *
     * @param string $key
     * @return static|null
     */
    public static function findByKey($key)
    {
        return static::findOne(['key' => $key, 'status' => self::STATUS_ENABLED]);
    }

    /**
     * Finds all tags from posts
     *
     * @return array
     */
    public static function findAllTags()
    {
        $tagsColumn = static::find()->select('tags')->column();
        $allTags = array_values(
            array_unique(explode(',', implode(',', $tagsColumn)))
        );

        return $allTags;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->tags = implode(',', $this->tagCollection);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        if ($this->tags) {
            $this->tagCollection = explode(',', $this->tags);
        }

        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->title;
    }
}
