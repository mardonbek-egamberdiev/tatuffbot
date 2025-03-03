<?php

/* @var $this yii\web\View */

use common\models\Client;
use common\models\Contact;
use common\models\News;
use common\models\Order;
use common\models\OurService;
use common\models\Resume;
use common\models\Vacancy;
use yii\helpers\Url;

$this->title = 'Mahalla bot';


$resumeCount = 10;

$contact_count = 10;

$clientCount = 10;

$vacancyCount = 10;
?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">

                        <p>Botga a'zolar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= Url::to(['client/index']) ?>" class="small-box-footer">Kirish <i
                                class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <p>Mahallalar</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-university"></i>
                    </div>
                    <a href="<?= Url::to(['quarters/index']) ?>" class="small-box-footer">Kirish <i
                                class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <p>Sozlamalar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <a href="<?= Url::to(['/translate-manager']) ?>" class="small-box-footer">Kirish <i
                                class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->render('_chart') ?>