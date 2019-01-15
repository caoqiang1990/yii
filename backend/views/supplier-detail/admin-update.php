<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\tabs\TabsX;
use yii\helpers\Url;
use yii\bootstrap\Tabs;
$this->title = '合作关系';
$content = '<div style="margin-top:10px"></div>';

$items = [
    // [
    //     'label'=>'<i class="fa fa-users"></i> 基础信息',
    //     'content'=> $content.$this->render('/supplier/view',['model'=>$model]),
    //     'active'=>true,
    // ],

];
if ($supplier_detail) {
  $i = 1;
  foreach ($supplier_detail as $detail) {
    $items[] = [
          'label'=>'<i class="fa fa-users"></i> 合作关系'.$i,
          'content'=> $content.$this->render('/supplier-detail/view',['model'=>$detail]),
      ];
    $i++;
  }
} else {
  $items[] = [
        'label'=>'<i class="fa fa-users"></i> 合作关系',
        'content'=> $content.'<a class="btn btn-primary" href="javascript:history.go(-1)">返回</a><br />'.$content.'暂无合作',
        'active'=>true,
  ];
}

echo Tabs::widget([
    'items'=>$items,
    'encodeLabels'=>false
]);


?>