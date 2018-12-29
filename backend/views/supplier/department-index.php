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
$department = $department_info->department_name;
$this->title = '部门供应商' . '-' . $department;
$this->params['breadcrumbs'][] = ['label' => '供应商名录查询', 'url' => \yii\helpers\Url::to(['supplier/admin-index'])];
$this->params['breadcrumbs'][] = '部门供应商';
?>
<div class="suppliers-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model) {
                    if(Helper::checkRoute('department-view')) {
                        $url = Url::to(['/supplier/department-view','id'=>$model->id]);
                        $options = ['title' => $model->name];
                        return Html::a($model->name,$url,$options);
                    } else {
                        return $model->name;
                    }
                }
            ], 
             [
                'attribute' => 'cate_id1',
                'value' => function($model){
                    $categoryModel = new SupplierCategory;
                    return $categoryModel::getCategoryById($model->cate_id1) ? $categoryModel::getCategoryById($model->cate_id1)->category_name : '';
                },
                'filter' => SupplierCategory::getCategoryByParams('id,category_name',1),
            ],
            [
                'attribute' => 'cate_id2',
                'value' => function($model){
                    $categoryModel = new SupplierCategory;
                    return $categoryModel::getCategoryById($model->cate_id2) ? $categoryModel::getCategoryById($model->cate_id2)->category_name : '';
                },
                'filter' => SupplierCategory::getCategoryByParams('id,category_name',2),
            ],
            [
                'attribute' => 'cate_id3',
                'value' => function($model){
                    $categoryModel = new SupplierCategory;
                    return $categoryModel::getCategoryById($model->cate_id3) ? $categoryModel::getCategoryById($model->cate_id3)->category_name : '';
                },
                'filter' => SupplierCategory::getCategoryByParams('id,category_name',3),
            ],
            [
                'attribute' => 'level',
                'value' => function($model){
                    $levelModel = new SupplierLevel;
                    return $levelModel::getLevelById($model->level) ? $levelModel::getLevelById($model->level)->level_name : '';
                },
                'filter' => SupplierLevel::getLevel(),
            ],
            // [
            //     'attribute' => 'trade',
            //     'value' => function($model){
            //         return SupplierTrade::getTradeById($model->trade) ? SupplierTrade::getTradeById($model->trade)->trade_name : '';
            //     },
            //     'filter' => SupplierTrade::getTrade(),
            // ],
            // [
            //     'attribute' => 'total_fund',
            //     'value' => function($model){
            //         $fund = $model->getTotalFund($model->id);
            //         return $fund ? $fund->trade_fund : '';
            //     }
            // ],
            'business_contact',  
            //'business_email',
            //'business_license',
            //'tax_registration_certificate',
            //'orcc',
            //'service_authorization_letter',
            //'certified_assets',
            //'effective_credentials',
            //'opening_bank',
            //'bank_no',
            //'account_name',
            //'account_no',
            //'registration_certificate',
            //'manufacturing_licence',
            //'business_certificate',
            //'credibility_certificate',
            //'headcount',
            //'address',
            //'telephone',
            //'mobile',
            //'fax',
            //'email:email',
            //'contact',
            //'url:url',
            //'black_box',
            //'white_box',
            //'remarks:ntext',
            //'update_date',
            //'operator',
            // [
            //     'attribute' => 'created_at',
            //     'value' => function($model){
            //         return date('Y-m-d H:i:s',$model->created_at);
            //     }
            // ],
            // [
            //     'attribute' => 'updated_at',
            //     'value' => function($model){
            //         return date('Y-m-d H:i:s',$model->updated_at);
            //     }
            // ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>