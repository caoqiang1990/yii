<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Supplier;
use mdm\admin\components\Helper; 
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SupplierDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '部门供应商';
$this->params['breadcrumbs'][] = ['label' => '供应商名录查询', 'url' => \yii\helpers\Url::to(['supplier/admin-index'])];
$this->params['breadcrumbs'][] = $this->title;
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

        ],
    ]); ?>
</div>
