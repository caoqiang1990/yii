<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Supplier;
use mdm\admin\components\Helper; 
use backend\models\SupplierLevel;
use backend\models\SupplierCategory;
use backend\models\SupplierTrade;
use backend\models\SupplierType;
use backend\models\Department;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierDetail */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('detail','Supplier Details'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-detail-view">

    <p>
    <?php if(Helper::checkRoute('Update')) {  ?>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php }  ?>
        <a class="btn btn-primary" href="javascript:history.go(-1)">返回</a>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'level',
                'value' => function($model){
                    $level = SupplierLevel::getLevelById($model->level);
                    return $level ? $level->level_name : '';
                }
            ],
            [
                'attribute' => 'one_level_department',
                'label' => '供应商管理部门(一级部门)',
                'value' => function($model) {
                    $department = Department::getDepartmentById($model->one_level_department);
                    return $department ? $department->department_name : '';
                }
            ],
            [
                'attribute' => 'second_level_department',
                'label' => '供应商管理部门(二级部门)',
                'value' => function($model) {
                    $department = Department::getDepartmentById($model->second_level_department);
                    return $department ? $department->department_name : '';
                }
            ],
            [
                'attribute' => 'one_coop_department',
                'label' => '供应商合作部门(一级部门)',
                'value' => function($model) {
                    $department = Department::getDepartmentById($model->one_coop_department);
                    return $department ? $department->department_name : '';
                }
            ],
            [
                'attribute' => 'second_coop_department',
                'label' => '供应商合作部门(二级部门)',
                'value' => function($model) {
                    $department = Department::getDepartmentById($model->second_coop_department);
                    return $department ? $department->department_name : '';
                }
            ],            
            'name',
            'mobile',
            'coop_fund1',
            'trade_fund1',
            'coop_fund2',
            'trade_fund2',
            'coop_fund3',
            'trade_fund3',                        
            'reason:ntext',
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
        <a class="btn btn-primary" href="javascript:history.go(-1)">返回</a>
    </p>
</div>
