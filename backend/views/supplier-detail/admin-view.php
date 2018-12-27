<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Supplier;
use mdm\admin\components\Helper; 
use backend\models\SupplierLevel;
use backend\models\SupplierCategory;
use backend\models\SupplierTrade;
use backend\models\SupplierType;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierDetail */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('detail','Supplier Details'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-detail-view">

    <p>
      <?= Html::a('返回', ['admin-index'], ['class' => 'btn btn-primary']) ?>
    </p>
  <?= DetailView::widget([
        'model' => $supplier,
        'attributes' => [
            //'id',
            'name',
            [
                'attribute' => 'level',
                'value' => function($model){
                    return SupplierLevel::getLevelById($model->level)->level_name;
                }
            ],
            [
                'attribute' => 'trade',
                'value' => function($model){
                    return SupplierTrade::getTradeById($model->trade)->trade_name;
                }
            ],
            'cate_id1',
            'cate_id2',
            'cate_id3',
            'business_contact',
            'business_position',
            'business_phone',
            'business_mobile',
            'business_address',
            //'business_type',
            [
                'attribute' => 'trade',
                'value' => function($model){
                    return SupplierType::getTypeById($model->business_type)->type_name;
                }
            ],            
            'business_email',
            'business_scope',
            'business_customer1',
            'business_customer2',
            'business_customer3',
            'material_name1',
            'material_name2',
            'material_name3',
            'instrument_device1',
            'instrument_device2',
            'instrument_device3',
            'instrument_device4',
            'firm_nature',
            'coop_content',
            'url',
            'headcount',
            'register_fund',
            'register_date',
            'factory_summary',
            'factory_land_area',
            'factory_work_area',
            'legal_person',
            'legal_position',
            'legal_phone',
            'sales_latest',
            'tax_latest',
            'social_responsibility',
            'department_name',
            'department_manager',
            'department_manager_phone',
            'enterprise_code_desc',
            'enterprise_license_desc',
            'enterprise_license_relate_desc',
            'enterprise_certificate_desc',
            'enterprise_certificate_etc_desc',
            [
                'attribute' => 'status',
                'value' => function($model){
                    switch ($model->status) {
                        case 10:
                            $text = '正常';
                            break;
                        case 0:
                            $text = '';
                        default:
                            $text = '';
                            break;
                    }
                    return $text;
                }
            ],
            [
                'attribute' => 'source',
                'value' => function($model){
                    switch ($model->source) {
                        case 'import':
                            $text = '导入';
                            break;
                        case 'add':
                            $text = '新增';
                            break;
                        default:
                            $text = '';
                            break;
                    }
                    return $text;
                }
            ],
            [
                'attribute' => 'public_flag',
                'value' => function($model){
                    switch ($model->public_flag) {
                        case 'y':
                            $text = '共享';
                            break;
                        
                        default:
                            $text = '保密';
                            break;
                    }
                    return $text;
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    return date('Y-m-d H:i:s',$model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($model){
                    return date('Y-m-d H:i:s',$model->updated_at);
                }
            ],
        ],
    ]) ?>
    <?php
        $key = 0;
        foreach($detail_obj_list as $model) {
            $key++;
    ?>
    <p>合作关系<?= $key ?></p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'one_level_department',
            'second_level_department',
            'name',
            'mobile',
            'coop_fund1',
            'trade_fund1',
            'coop_fund2',
            'trade_fund2',
            'coop_fund3',
            'trade_fund3',                        
            'reason:ntext',
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    return date('Y-m-d H:i:s',$model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($model){
                    return date('Y-m-d H:i:s',$model->updated_at);
                }
            ],
        ],
    ]) ?>
    <?php
        }
    ?>
    <p>
      <?= Html::a('返回', ['admin-index'], ['class' => 'btn btn-primary']) ?>
    </p>
</div>