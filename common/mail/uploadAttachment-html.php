<?php
use yii\helpers\Html;

$link = Yii::$app->params['frontUrl'].'/collect/attachment?verid='.enCrypt($pitch_id).'&signid='.enCrypt($supplier->id);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($supplier->name) ?>,</p>

    <p>根据下面链接完善信息:</p>

    <p><?= Html::a(Html::encode($link), $link) ?></p>
</div>
<div>
    此为系统邮件，请勿回复。
</div>
