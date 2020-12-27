<?php

namespace app\models;

use Yii;
use yii\base\Event;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property-read mixed $authKey
 * @property string $password
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const STATUS_DELETED = 0;

    public const STATUS_ACTIVE = 10;

    public $password;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['auth_key'],
                ],
                'value'      => function ($event) {
                    return $this->generateAuthKey();
                },
            ],
            [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['verification_token'],
                ],
                'value'      => function ($event) {
                    return $this->generateEmailVerificationToken();
                },
            ],
            [
                'class'             => AttributeBehavior::class,
                'attributes'        => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['password_hash'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['password_hash'],
                ],
                'skipUpdateOnClean' => false,
                'value'             => function (Event $event) {
                    return $event->sender->password === null ? $this->password_hash : $this->hashPassword();
                },
            ],
        ];
    }

    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    protected static function findByCondition($condition)
    {
        return parent::findByCondition($condition)->andWhere(['status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    private function generateAuthKey(): string
    {
        return Yii::$app->security->generateRandomString(32);
    }

    private function hashPassword(): string
    {
        return Yii::$app->security->generatePasswordHash($this->password);
    }

    private function generateEmailVerificationToken(): string
    {
        return Yii::$app->security->generateRandomString() . '_' . time();
    }
}
