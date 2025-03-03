<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card card-primary">
    <div class="card-body">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'user_id')->textInput() ?>

        <?= $form->field($model, 'street_id')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'data')->textInput(['maxlength' => true]) ?>

<!--        --><?//= $form->field($model, 'step')->textInput(['maxlength' => true]) ?>

<!--        --><?//= $form->field($model, 'created_at')->textInput() ?>
<!---->
<!--        --><?//= $form->field($model, 'updated_at')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>