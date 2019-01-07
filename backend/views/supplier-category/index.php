<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\SupplierCategory;
use mdm\admin\components\Helper; 

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SupplierCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('category', 'Supplier Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-category-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?php if(Helper::checkRoute('create')) {  ?>
        <?= Html::a(Yii::t('category', 'Create Supplier Category'), ['create'], ['class' => 'btn btn-success']) ?>
    <?php } ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager'=>[
            //'options'=>['class'=>'hidden']//关闭分页
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页',
            'maxButtonCount' => 5, 
        ],        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'category_name',
            [
                'attribute' => 'level',
                'value' => function($model) {
                    switch ($model->level) {
                        case '1':
                            return '总类';
                            break;
                        case '2':
                            return '大类';
                            break;
                        case '3':
                            return '子类';
                            break;    
                        default:
                            return '未选择';
                            break;
                    }
                },
                'filter' => [1=>'总类',2=>'大类',3=>'子类']
            ],
            [
                'attribute' => 'pid',
                'value' => function($model) {
                    $info = $model->getCategoryById($model->pid);
                    if (!$info){
                        return '父类';
                    }else{
                        return $info['category_name'];
                    }
                },
            ],
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status ? '有效' : '无效';
                },
                'filter' => ['无效','有效']
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

            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn('{view}{update}{delete}'), 

            ],            
        ],
    ]); ?>
</div>
