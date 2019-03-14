<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $supplier->id]);
?>
Hello <?= $supplier->name ?>,

请尽快按要求完善:

<?= $resetLink ?>
