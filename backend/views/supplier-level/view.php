<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierLevel */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('level', 'Supplier Levels'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-level-view">
    <p>
        <?php if (Helper::checkRoute('Update')) { ?>
            <?= Html::a(Yii::t('level', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?php if (Helper::checkRoute('Delete')) { ?>
            <?= Html::a(Yii::t('level', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('level', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'level_name',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status ? '有效' : '无效';
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('Y-m-d H:i:s', $model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return date('Y-m-d H:i:s', $model->updated_at);
                }
            ]
        ],
    ]) ?>

</div>
