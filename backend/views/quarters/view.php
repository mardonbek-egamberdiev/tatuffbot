<?php

use common\models\Quarters;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Quarters */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mahallalar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card card-primary">
    <div class="card-body">
        <div class="banner-view">
            <p>
                <?= Html::a('<i class="fas fa-pen"></i> O\'zgartirish', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="fas fa-trash-alt"></i> O\'chirish', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Ushbu elementni o\'chirmoqchimisiz?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'title',
            'created_at:date',
            'updated_at:date',
            [
                'attribute' => 'created_by',
                'value' => function (Quarters $model) {
                    return $model->createdBy->username;
                }
            ],
            [
                'attribute' => 'updated_by',
                'value' => function (Quarters $model) {
                    return $model->updatedBy->username;
                }
            ],
            [
                'attribute' => 'status',
                'value' => 'statusBadge',
                'format' => 'raw',
            ],
        ],
    ]) ?>
        </div>
    </div>
</div>