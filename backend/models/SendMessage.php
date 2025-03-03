<?php

namespace backend\models;

use common\models\Client;
use yii\helpers\ArrayHelper;

class SendMessage extends \yii\base\Model
{
    public $message;
    public $img;
    public $gender;

    public function rules()
    {
        return [
            [['message', 'gender'], 'required'],
            [['img'], 'image'],
            [['message'], 'string'],
            [['gender'],'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'message' => 'Xabar matni',
            'img' => 'Rasm',
            'gender' => 'Jinsi',
        ];
    }

    public static function genders(){

        return [
          Client::TYPE_GENDER_E => 'Erkak',
          Client::TYPE_GENDER_A => 'Ayol',
          2 => 'Barchasi',
        ];
    }
}