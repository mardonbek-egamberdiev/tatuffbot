<?php

use common\models\Client;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'Botga a\'zolar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card card-primary">
    <div class="card-body">
        <div class="banner-view">
            <p>
<!--                --><?//= Html::a('<i class="fas fa-pen"></i> O\'zgartirish', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
//                    'id',
                    'user_id',
                    [
                        'attribute' => 'street_id',
                        'format' => 'raw',
                        'value' => function(Client $model){
                            return $model->quarter->title ?? '';
                        }
                    ],
                    'full_name',
                    'username',
                    'data',
//                    'step',
                    'created_at:date',
//                    'updated_at',
                ],
            ]) ?>

        </div>
    </div>
</div>