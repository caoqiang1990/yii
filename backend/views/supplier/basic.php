<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\models\SupplierLevel;
use backend\models\SupplierCategory;
use backend\models\SupplierTrade;
use mdm\admin\components\Helper;
use mdm\admin\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SuppliersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$department = $department_info->department_name;
$this->title = '变更基本信息';
$this->params['breadcrumbs'][] = ['label' => '供应商名录查询', 'url' => \yii\helpers\Url::to(['supplier/admin-index'])];
$this->params['breadcrumbs'][] = '变更基本信息';
?>
<div class="suppliers-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            //'options'=>['class'=>'hidden']//关闭分页
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
            'maxButtonCount' => 5,
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    if (Helper::checkRoute('update')) {
                        $url = Url::to(['update', 'id' => $model->id]);
                        $options = ['title' => $model->name];
                        return Html::a($model->name, $url, $options);
                    } else {
                        return $model->name;
                    }
                },
                'headerOptions' => [
                    'width' => '50px'
                ],
            ],
            [
                'attribute' => 'cate_id1',
                'value' => function ($model) {
                    $categoryModel = new SupplierCategory;
                    return $categoryModel::getCategoryById($model->cate_id1) ? $categoryModel::getCategoryById($model->cate_id1)->category_name : '';
                },
                'filter' => SupplierCategory::getCategoryByParams('id,category_name', 1),
                'headerOptions' => [
                    'width' => '100px'
                ],
            ],
            [
                'attribute' => 'cate_id2',
                'value' => function ($model) {
                    $categoryModel = new SupplierCategory;
                    return $categoryModel::getCategoryById($model->cate_id2) ? $categoryModel::getCategoryById($model->cate_id2)->category_name : '';
                },
                'filter' => $cate2,
                'headerOptions' => [
                    'width' => '100px'
                ]
            ],
            [
                'attribute' => 'cate_id3',
                'value' => function ($model) {
                    $categoryModel = new SupplierCategory;
                    return $categoryModel::getCategoryById($model->cate_id3) ? $categoryModel::getCategoryById($model->cate_id3)->category_name : '';
                },
                'filter' => $cate3,
                'headerOptions' => [
                    'width' => '100px'
                ]
            ],
            [
                'attribute' => 'level',
                'value' => function ($model) {
                    $levelModel = new SupplierLevel;
                    return $levelModel::getLevelById($model->level) ? $levelModel::getLevelById($model->level)->level_name : '';
                },
                'filter' => SupplierLevel::getLevel(),
                'headerOptions' => [
                    'width' => '100px'
                ]
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
            //'business_contact',  
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
            [
                'attribute' => 'updated_by',
                'value' => function ($model) {
                    $user = User::findOne($model->updated_by);
                    return $user ? $user->truename : '';
                },
                'headerOptions' => [
                    'width' => '100px'
                ]
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return date('Y-m-d H:i:s', $model->updated_at);
                }
            ],
            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn('{view}{update}{delete}'),

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
