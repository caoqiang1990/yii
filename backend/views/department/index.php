<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('department', 'Departments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('department', 'Create Department'), ['create'], ['class' => 'btn btn-success']) ?>
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
            'department_name',
            'pid',
            'level',
            //'status',
            //'order_no',
            //'created_at',
            //'updated_at',

            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn('{view}{update}{delete}'), 

            ],
            [
                'label'=>  (Helper::checkRoute('department/assignment')) ? '更多操作' : '',
                'format'=>'raw',
                'value' => function($model){
                    $operator_1 = '';
                    $operator_2 = '';
                    // if (Helper::checkRoute('supplier-detail/create')) {
                    //     $url_1 = Url::to(['supplier-detail/create','sid'=>$model->id]);
                    //     $operator_1 = Html::a('与我方关系', $url_1, ['title' => '与我方关系']);

                    // }

                    if (Helper::checkRoute('department/assignment') && $model->pid === 0) {
                        $url_2 = Url::to(['department/assignment','id'=>$model->id]);
                        $operator_2 = Html::a('分配员工', $url_2, ['title' => '分配员工']);
                    }
                    return $operator_1.' '.$operator_2;
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
