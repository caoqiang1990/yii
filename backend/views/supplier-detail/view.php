<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Supplier;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierDetail */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('detail','Supplier Details'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-detail-view">

    <p>
    <?php if(Helper::checkRoute('Update')) {  ?>
        <?= Html::a(Yii::t('detail','Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php }  ?>
    <?php if(Helper::checkRoute('Delete')) {  ?>
        <?= Html::a(Yii::t('detail','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    <?php }  ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'sid',
                'value' => function($model){
                    $supplierModel = new Supplier;
                    $nameObject = $supplierModel->getNameByID($model->sid);
                    if (!$nameObject) {
                        return '未知';
                    }
                    return $nameObject->name;
                }
            ],
            'one_level_department',
            'second_level_department',
            'name',
            'mobile',
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

</div>
