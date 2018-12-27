<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Supplier;
use mdm\admin\components\Helper; 
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SupplierDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => '与我方关系列表', 'url' => \yii\helpers\Url::to(['supplier/index'])];
?>
<div class="supplier-detail-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'sid',
                'format' => 'raw',
                'value' => function($model){
                    $supplier = Supplier::getSupplierById($model->sid);
                    if (!$supplier) {
                        return '';
                    }
                    if(Helper::checkRoute('view')) {
                       
                        $url = Url::to(['view','id'=>$model->id]);
                        $options = ['title' => $supplier->name];
                        return Html::a($supplier->name,$url,$options);
                    } else {
                        return $supplier->name;
                    }                    
                }
            ],
            'one_level_department',
            'second_level_department',
            'name',
            //'mobile',
            //'reason:ntext',
            //'created_at',
            //'updated_at',

            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn('{view}{update}{delete}'), 

            ],   
            [
                'label'=>  (Helper::checkRoute('supplier-detail/create')) ? '更多操作' : '',
                'format'=>'raw',
                'value' => function($model){
                    $operator_1 = '';
                    if (Helper::checkRoute('supplier-detail/create')) {
                        $url_1 = Url::to(['supplier-detail/create','sid'=>$model->sid]);
                        $operator_1 = Html::a('与我方关系', $url_1, ['title' => '与我方关系']);

                    }
                   return $operator_1; 
                }
            ],               
        ],
    ]); ?>
</div>
