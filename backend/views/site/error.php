<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
            <h3>抱歉~</h3>

            <p>
                <?php
                //nl2br(Html::encode($message))
                ?>
            </p>
            <p>
                您要访问的页面找不到了！
            </p>
            <p>
                如果问题一直持续出现，请联系管理员哟！
            </p>
            <p>
                <a href='<?= Yii::$app->homeUrl ?>'>返回首页</a>
            </p>
        </div>
    </div>

</section>
