<?php



/* @var $this View */

use backend\models\SendMessage;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var SendMessage $selectForm */

$this->title = "Xabar yozish";
?>

<div class="card card-white">
    <div class="card-header">
        <b class="text-danger">Rasm yuklansa a'zolarga rasmli xabar, aks xolda rasmsiz xabar boradi!</b>
    </div>
    <div class="card-body">

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'action' => Url::to(['client/send-message'])
        ]); ?>

        <?= $form->field($selectForm,'message')->textarea(['rows' => 6])?>
        <?= $form->field($selectForm,'gender')->dropdownList(SendMessage::genders())?>
        <?= $form->field($selectForm,'img')->fileInput()?>
        <div class="form-group">
            <?= Html::submitButton('Yuborish', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
