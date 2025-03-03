<?php

use common\models\Client;
use common\models\Quarters;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Botga a\'zolar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-primary card-outline border-default" style="padding: 10px 5px">
    <div class="kv-panel-before table-sm">

        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= Html::beginForm(['client/select'], 'post') ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pager' => ['class' => \yii\bootstrap4\LinkPager::class],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ['class' => '\yii\grid\CheckboxColumn'],

//            'id',
                [
                    'attribute' => 'gender',
                    'format' => 'raw',
                    'filter' => Client::genders(),
                    'value' => function(Client $model){
                        if ($model->gender === Client::TYPE_GENDER_A){
                            return 'Ayol';
                        }
                        if ($model->gender === Client::TYPE_GENDER_E){
                            return 'Erkak';
                        }
                    }
                ],
                'user_id',
                [
                    'attribute' => 'street_id',
                    'format' => 'raw',
                    'filter' => Quarters::map(),
                    'value' => function(Client $model){
                        return $model->quarter->title ?? '';
                    }
                ],
                'full_name',
                'username',
                //'data',
                //'step',
                //'created_at',
                //'updated_at',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {delete}'
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
        <?= Html::submitButton('<i class="fas fa-sms"></i> Xabar yuborish', ['class' => 'btn btn-primary']) ?>
        <?php Html::endForm() ?>
    </div>
</div>