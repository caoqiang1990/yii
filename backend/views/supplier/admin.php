<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\models\SupplierLevel;
use backend\models\SupplierCategory;
use backend\models\SupplierTrade;
use mdm\admin\components\Helper; 
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SuppliersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '供应商新增';
$cssString = ".modal-content{padding:10px;}";  
$this->registerCss($cssString); 
?>
<div class="suppliers-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?php if(Helper::checkRoute('admin-add')) {  ?>
        <?php 
            echo Html::a('创建',['admin-add'], [
                'id' => 'create',
                'data-toggle' => 'modal',
                'data-target' => '#modal_ajax',
                'class' => 'btn btn-success',
            ]);
        ?>
    <?php } ?>
    </p>
    <div class="modal fade" id="modal_ajax" role="basic" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-body">
              <span> &nbsp;&nbsp;Loading... </span>
          </div>
      </div>
      </div>
    </div>
</div>
