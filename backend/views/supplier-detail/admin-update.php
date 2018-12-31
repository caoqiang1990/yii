<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tabs\TabsX;

$content1 = 'd';
$content2 = 'd';
$content3 = 'd';
$content4 = 'd';

$items = [
    [
        'label'=>'<i class="fas fa-home"></i> Home',
        'content'=>$content1,
        'active'=>true
    ],
    [
        'label'=>'<i class="fas fa-user"></i> Profile',
        'content'=>$content2,
        'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/site/tabs-data'])]
    ],
    [
        'label'=>'<i class="fas fa-list-alt"></i> Menu',
        'items'=>[
             [
                 'label'=>'Option 1',
                 'encode'=>false,
                 'content'=>$content3,
             ],
             [
                 'label'=>'Option 2',
                 'encode'=>false,
                 'content'=>$content4,
             ],
        ],
    ],
    [
        'label'=>'<i class="fas fa-king"></i> Disabled',
        'linkOptions' => ['class'=>'disabled']
    ],
];


echo TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    'encodeLabels'=>false
]);


?>