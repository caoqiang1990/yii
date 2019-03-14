<?php
use yii\helpers\Html;

$link = Yii::$app->params['frontUrl_test'].'/collect/attachment?id='.$pitch_id.'&sid='.$supplier->id;
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($supplier->name) ?>,</p>

    <p>根据下面链接完善信息:</p>

    <p><?= Html::a(Html::encode($link), $link) ?></p>
</div>
