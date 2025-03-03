<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $street_id
 * @property string|null $full_name
 * @property string|null $username
 * @property string|null $data
 * @property string|null $step
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 * @property int|null $gender
 */
class Client extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const TYPE_GENDER_E = 0;
    const TYPE_GENDER_A = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    public function behaviors()
    {
        return [

            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at', 'status','gender'], 'integer'],
            [['street_id', 'full_name', 'username', 'data', 'step','file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'street_id' => 'Mahalla',
            'gender' => 'Jinsi',
            'full_name' => 'Ism va Familya',
            'username' => 'Username',
            'data' => 'Ma\'lumotlar',
            'step' => 'Step',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getStatusFilter()
    {
        return [
            self::STATUS_ACTIVE => 'Faol',
            self::STATUS_INACTIVE => 'Faol emas',
        ];
    }

    public static function genders()
    {
        return [
            self::TYPE_GENDER_E => 'Erkak',
            self::TYPE_GENDER_A => 'Ayol',
        ];
    }

    public function getQuarter()
    {

        return $this->hasOne(Quarters::class,['id'=>'street_id']);
    }
}
