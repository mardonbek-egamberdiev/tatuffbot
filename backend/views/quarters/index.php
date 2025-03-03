<?php

use common\models\Quarters;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\QuartersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mahallalar');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-primary card-outline border-default" style="padding: 10px 5px">
    <div class="kv-panel-before table-sm">
        <div class="btn-toolbar kv-grid-toolbar toolbar-container float-right mb-2">
            <?= Html::a('<i class="fa fa-plus"></i> Yangi qo\'shish', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                'title',

                'created_at:date',
                //'updated_at',
                [
                    'attribute' => 'created_by',
                    'value' => function (Quarters $model) {
                        return $model->createdBy->username;
                    }
                ],
                [
                    'attribute' => 'status',
                    'value' => 'statusBadge',
                    'format' => 'raw',
                    'filter' => Quarters::statusTypes(),
                ],
                //'created_by',
                //'updated_by',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

        <?php Pjax::end(); ?>

    </div>
</div>
