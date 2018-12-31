<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\SupplierLevel;
use backend\models\SupplierCategory;
use backend\models\SupplierTrade;
use backend\models\SupplierType;
use mdm\admin\components\Helper; 
use backend\models\SupplierNature;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('suppliers', 'Suppliers'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-view">

    <p>
    <?php if(Helper::checkRoute('Update')) {  ?>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php } ?>

    <?= Html::a('返回', ['basic'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            [
                'attribute' => 'level',
                'value' => function($model){
                    $level = SupplierLevel::getLevelById($model->level);
                    if (!$level) {
                        return '';
                    }
                    return $level->level_name;
                }
            ],
            [
                'attribute' => 'trade',
                'value' => function($model){
                    $trade = SupplierTrade::getTradeById($model->trade);
                    if (!$trade) {
                        return '';
                    }
                    return $trade->trade_name;
                }
            ],
             [
                'attribute' => 'cate_id1',
                'value' => function($model){
                    $categoryModel = new SupplierCategory;
                    return $categoryModel::getCategoryById($model->cate_id1) ? $categoryModel::getCategoryById($model->cate_id1)->category_name : '';
                },
            ],
            [
                'attribute' => 'cate_id2',
                'value' => function($model){
                    $categoryModel = new SupplierCategory;
                    return $categoryModel::getCategoryById($model->cate_id2) ? $categoryModel::getCategoryById($model->cate_id2)->category_name : '';
                },
            ],
            [
                'attribute' => 'cate_id3',
                'value' => function($model){
                    $categoryModel = new SupplierCategory;
                    return $categoryModel::getCategoryById($model->cate_id3) ? $categoryModel::getCategoryById($model->cate_id3)->category_name : '';
                },
            ],
            'business_contact',
            'business_position',
            'business_phone',
            'business_mobile',
            'business_address',
            //'business_type',
            [
                'attribute' => 'business_type',
                'value' => function($model){
                    $type = SupplierType::getTypeById($model->business_type);
                    if (!$type) {
                        return '';
                    }
                    return $type->type_name;
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
            [
                'attribute' => 'firm_nature',
                'value' => function($model) {
                    $nature = SupplierNature::getNatureById($model->firm_nature);
                    return $nature ? $nature->nature_name : '';
                }
            ],
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
    <p>
    <?php if(Helper::checkRoute('Update')) {  ?>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php } ?>

    <?= Html::a('返回', ['basic'], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
