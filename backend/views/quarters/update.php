<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Quarters */

$this->title =$model->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mahallalar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Tahrirlash';
?>
<div class="quarters-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
