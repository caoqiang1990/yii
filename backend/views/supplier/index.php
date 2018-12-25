<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\models\SupplierLevel;
use backend\models\SupplierTrade;
use mdm\admin\components\Helper; 

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SuppliersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('suppliers', 'Suppliers');
$this->params['breadcrumbs'][] = $this->title;
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
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model) {
                    $url = Url::to(['update','id'=>$model->id]);
                    $options = ['title' => $model->name];
                    return Html::a($model->name,$url,$options);
                }
            ],
            // [
            //     'attribute' => 'level',
            //     'value' => function($model){
            //         $levelModel = new SupplierLevel;
            //         return $levelModel::getLevelById($model->level) ? $levelModel::getLevelById($model->level)->level_name : '';
            //     },
            //     'filter' => SupplierLevel::getLevel(),
            // ],
            [
                'attribute' => 'trade',
                'value' => function($model){
                    return SupplierTrade::getTradeById($model->trade) ? SupplierTrade::getTradeById($model->trade)->trade_name : '';
                },
                'filter' => SupplierTrade::getTrade(),
            ],
            // [
            //     'attribute' => 'total_fund',
            //     'value' => function($model){
            //         $fund = $model->getTotalFund($model->id);
            //         return $fund ? $fund->trade_fund : '';
            //     }
            // ],
            'business_contact',  
            'business_email',
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
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn('{view}{update}{delete}'), 

            ],
            [
                //'label'=>  (Helper::checkRoute('supplier-detail/create') || Helper::checkRoute('history/index')) ? '更多操作' : '',
                'label'=>  (Helper::checkRoute('history/index')) ? '更多操作' : '',
                'format'=>'raw',
                'value' => function($model){
                $operator_1 = '';
                $operator_2 = '';
                // if (Helper::checkRoute('supplier-detail/create')) {
                //     $url_1 = Url::to(['supplier-detail/create','sid'=>$model->id]);
                //     $operator_1 = Html::a('与我方关系', $url_1, ['title' => '与我方关系']);

                // }

                if (Helper::checkRoute('history/index')) {
                    $url_2 = Url::to(['history/index','object_id'=>$model->id]);
                    $operator_2 = Html::a('历史记录', $url_2, ['title' => '历史记录']);
                }
                    return $operator_1.' '.$operator_2; 
                }
            ],   
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
