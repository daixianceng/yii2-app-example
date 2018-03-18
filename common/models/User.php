<?php
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\helpers\Url;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $passwordHash
 * @property string $avatar
 * @property string $email
 * @property string $authKey
 * @property integer $status
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property string $password write-only password
 * @property string|null $statusLabel read-only status label
 * @property boolean $isEnabled read-only whether is enabled
 */
class User extends ActiveRecord implements StatusInterface, SortInterface, IdentityInterface
{
    /**
     * The name of the insert scenario.
     */
    const SCENARIO_INSERT = 'insert';

    /**
     * The name of the upload avatar scenario.
     */
    const SCENARIO_UPLOAD_AVATAR = 'upload-avatar';

    /**
     * @property \yii\web\UploadedFile|null
     */
    public $avatarFile;

    /**
     * @property string
     */
    public $passwordNew;

    /**
     * @property array|null
     */
    private static $statusLabels;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public static function sortField()
    {
        return 'id';
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
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'trim'],
            [['username'], 'required'],
            [['username'], 'unique'],
            [['username'], 'string', 'length' => [2, 20]],

            [['passwordNew'], 'required', 'on' => [self::SCENARIO_INSERT]],
            [['passwordNew'], 'string', 'length' => [6, 40]],

            [['avatarFile'], 'required', 'on' => [self::SCENARIO_UPLOAD_AVATAR]],
            [
                'avatarFile',
                'image',
                'extensions' => 'jpg, png',
                'mimeTypes' => 'image/jpeg, image/png',
                'checkExtensionByMimeType' => true,
                'minSize' => 100,
                'maxSize' => 204800,
                'tooBig' => 'The {attribute} size can not be greater than 200KB',
                'tooSmall' => 'The {attribute} size can not be less than 0.1KB',
                'notImage' => 'The {file} is not a valid image file',
            ],

            [['email'], 'trim'],
            [['email'], 'email'],

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
            'username' => 'Username',
            'passwordNew' => 'New password',
            'passwordHash' => 'Hashed password',
            'accessToken' => 'Access token',
            'avatar' => 'Avatar Name',
            'avatarFile' => 'Avatar File',
            'avatarURL' => 'Avatar URL',
            'email' => 'Email',
            'authKey' => 'Auth key',
            'status' => 'Status',
            'createdAt' => 'Create time',
            'updatedAt' => 'Update time',
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'username',
            'avatar',
            'avatarURL',
            'email',
            'status',
            'statusLabel',
            'isEnabled',
            'createdAt',
            'updatedAt',
        ];
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'passwordNew',
            'passwordHash',
            'authKey',
            'accessToken',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['authorId' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ENABLED]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token, 'status' => self::STATUS_ENABLED]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ENABLED]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
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
     * Gets avatar URL of the model
     *
     * @return string
     */
    public function getAvatarURL()
    {
        return Url::toAvatar($this->avatar);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->passwordHash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->passwordHash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates access token
     */
    public function generateAccessToken()
    {
        $this->accessToken = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates avatar name
     */
    public function generateAvatarName($extension)
    {
        $this->avatar = Yii::$app->security->generateRandomString(32) . '.' . $extension;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->generateAuthKey();
            } elseif (!empty($this->passwordNew)) {
                $this->setPassword($this->passwordNew);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->username;
    }
}
