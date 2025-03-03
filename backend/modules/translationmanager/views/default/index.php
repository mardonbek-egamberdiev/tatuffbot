<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel wokster\translationmanager\models\SourceMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tarjimalar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card" style="padding: 10px 5px">
    <div class="kv-panel-before table-sm">
        <div class="btn-toolbar kv-grid-toolbar toolbar-container float-right mb-2">
            <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Qo\'shish'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box box-default">
            <div class="box-header with-border">
                <span class="label label-default">записей <?= $dataProvider->getCount()?> из <?= $dataProvider->getTotalCount()?></span>
            </div>
            <div class="box-body">
                <?= GridView::widget([
                    'summary' => '',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'pager' => ['class' => \yii\bootstrap4\LinkPager::class],
                    'columns' => Yii::$app->controller->module->grid_column,
                ]); ?>
            </div>
        </div>
    </div>
</div>
