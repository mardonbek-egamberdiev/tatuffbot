<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "quarters".
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Quarters extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_ACTIVE= 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quarters';
    }

    /**
     * {@inheritdoc}
     */

    public static function statusTypes()
    {
        return [
            self::STATUS_NEW => 'Faol emas',
            self::STATUS_ACTIVE => 'Faol',
        ];
    }

    public function statusTypesName()
    {
        return ArrayHelper::getValue(self::statusTypes(), $this->status, $this->status);
    }

    public static function getStatusBadges()
    {
        $labels = self::statusTypes();
        return
            [
                self::STATUS_NEW => '<span class="badge badge-danger">' . self::getArrayValue($labels, self::STATUS_NEW) . '</span>',
                self::STATUS_ACTIVE => '<span class="badge badge-success">' . self::getArrayValue($labels, self::STATUS_ACTIVE) . '</span>',
            ];
    }
    public static function getArrayValue($array, $key, $defaultValue=null)
    {
        if (isset($array[$key])){
            return $array[$key];
        }
        return $defaultValue;
    }
    public function getStatusBadge()
    {
        return self::getArrayValue(self::getStatusBadges(), $this->status, $this->status);
    }
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
            'blameable' => [
                'class' => BlameableBehavior::class,
            ],
        ];
    }


    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => 'Mahala',
            'status' =>'Holati',
            'created_at' => 'Yaratilgan vaqti',
            'updated_at' => 'Tahrirlangan vaqti',
            'created_by' => 'Yaratdi',
            'updated_by' => 'O\'zgartirdi',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public static function map(){

        return ArrayHelper::map(self::find()->all(),'id','title');
    }
}
