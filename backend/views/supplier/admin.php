<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\models\SupplierLevel;
use backend\models\SupplierCategory;
use backend\models\SupplierTrade;
use mdm\admin\components\Helper; 

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SuppliersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '供应商新增';
?>
<div class="suppliers-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?php if(Helper::checkRoute('create')) {  ?>
        <?= Html::a(Yii::t('suppliers', 'Create Suppliers'), ['create'], ['class' => 'btn btn-success']) ?>
    <?php } ?>
    <?php if(Helper::checkRoute('uploadxls')) {  ?>
        <?= Html::a(Yii::t('suppliers', 'Import Suppliers'), ['uploadxls'], ['class' => 'btn btn-success']) ?>
    <?php } ?>
    </p>
    
    <?php Pjax::end(); ?>
</div>
