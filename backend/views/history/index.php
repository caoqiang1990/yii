<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use mdm\admin\models\User;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\HistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('history', '修改记录');
$this->params['breadcrumbs'][] = ['label' => '供应商列表', 'url' => \yii\helpers\Url::to(['supplier/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'pager'=>[
            //'options'=>['class'=>'hidden']//关闭分页
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页',
            'maxButtonCount' => 5, 
        ],        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'desc',
            [
                'attribute' => 'created_by',
                'value' => function($model){
                    $userModel = new User;
                    $userInfo = $userModel::findIdentity($model->created_by);
                    return $userInfo ? $userInfo->username : '';
                }
            ],
            [
                'attribute' => 'updated_by',
                'value' => function($model){
                    $userModel = new User;
                    $userInfo = $userModel::findIdentity($model->updated_by);
                    return $userInfo ? $userInfo->username : '';
                }
            ],
            //'created_at',
            //'updated_at',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
