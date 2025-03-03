<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Quarters */

$this->title = Yii::t('app', 'Qo\'shish');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mahallalar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quarters-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
