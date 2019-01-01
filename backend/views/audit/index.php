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

$this->title = '待审核';
$this->params['breadcrumbs'][] = $this->title;
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
                    if(Helper::checkRoute('view')) {
                        $url = Url::to(['view','id'=>$model->id]);
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
            // [
            //     'attribute' => 'level',
            //     'value' => function($model){
            //         $levelModel = new SupplierLevel;
            //         return $levelModel::getLevelById($model->level) ? $levelModel::getLevelById($model->level)->level_name : '';
            //     },
            //     'filter' => SupplierLevel::getLevel(),
            // ],
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
            [
              'attribute' => 'status',
              'value' => function($model) {
                switch ($model->status) {
                  case '10':
                    $text = '正常';
                    break;
                  case 'wait':
                    $text = '待完善';
                    break;
                  case 'auditing':
                    $text = '待审核';
                    break;  
                  default:
                    $text = '';
                    break;
                }
                return $text;
              },
              'filter' => $status, 
            ],
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

            // [
            //     'header' => '操作',
            //     'class' => 'yii\grid\ActionColumn',
            //     'template' => Helper::filterActionColumn('{view}{update}{delete}'), 

            // ],
            [
                //'label'=>  (Helper::checkRoute('supplier-detail/create') || Helper::checkRoute('history/index')) ? '更多操作' : '',
                'label'=>  '更多操作',
                'format'=>'raw',
                'value' => function($model){
                $operator_1 = '';
                $operator_2 = '';
                if (Helper::checkRoute('audit')) {
                    $url_1 = Url::to(['audit','id'=>$model->id]);
                    $operator_1 = Html::a('审核', $url_1, ['title' => '审核']);

                }

                // if (Helper::checkRoute('history/index')) {
                //     $url_2 = Url::to(['history/index','object_id'=>$model->id]);
                //     $operator_2 = Html::a('历史记录', $url_2, ['title' => '历史记录']);
                // }
                    return $operator_1.' '.$operator_2; 
                }
            ],   
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
