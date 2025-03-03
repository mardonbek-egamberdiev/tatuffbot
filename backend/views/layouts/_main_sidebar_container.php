<?php

use yii\helpers\Url;

?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Url::to(['/']) ?>" class="brand-link">
        <img src="<?= Url::base() ?>/adminLte3/img/AdminLTELogo.png" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8;width: 29px">
        <span class="brand-text font-weight-light"><?= Yii::$app->name ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="<?= Url::to(['/']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Bosh sahifa
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= Url::to(['/client']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                           Botga a'zolar
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= Url::to(['/quarters']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-university"></i>
                        <p>
                            Mahallalar
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= Url::to(['/translate-manager']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Sozlamalar
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= Url::to(['/site/cache-flush']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-broom"></i>
                        <p>
                            Clear cache
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
