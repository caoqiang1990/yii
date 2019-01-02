<?php
use yii\helpers\Html;
use mdm\admin\models\form\ModifyUser;
use yii\helpers\Url;
/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <!-- <?= Html::a('<span class="logo-mini">供应商管理</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?> -->
	<?= Html::a('<span class="logo-mini"><img src="/static/images/aimer-logo-min.jpg" style="width:100%;max-width:230px;" alt="Aimer Logo"/></span><span class="logo-lg"><img src="/static/images/aimer-logo.jpg" style="width:100%;max-width:230px;" alt="Aimer Logo"/></span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="<?= Url::to(['/admin/user/profile','id' => Yii::$app->user->identity->id]) ?>" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                            if (!Yii::$app->user->identity->head_url) {
                        ?>
                            <img src="/static/images/aimer_head.jpg" class="user-image" alt="User Image"/>
                        <?php
                            } else {
                                $user = new ModifyUser();
                                $head_url = $user->parseImageUrl(Yii::$app->user->identity->head_url);
                        ?>
                            <img src="<?= $head_url?>" class="user-image" alt="User Image"/>

                        <?php
                            }
                        ?>
                        <span class="hidden-xs"><?= Yii::$app->user->identity->truename ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php
                                if (!Yii::$app->user->identity->head_url) {
                            ?>
                                <img src="/static/images/aimer_head.jpg" class="img-circle" alt="User Image"/>
                            <?php
                                } else {
                            ?>      
                                <img src="<?= $head_url?>" class="img-circle" alt="User Image"/>
                            <?php
                                }
                            ?>                                                  
                            <p>
                                <?= Yii::$app->user->identity->truename ?>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a(
                                    '个人设置',
                                    ['admin/user/profile','id'=>Yii::$app->user->identity->id],
                                    ['class' => 'btn btn-default btn-flat']
                                ) ?>                             
                                <?= Html::a(
                                    '修改密码',
                                    ['admin/user/change-password'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>                            
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    '退出',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
