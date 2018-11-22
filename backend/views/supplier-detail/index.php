<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Supplier;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SupplierDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('detail','Supplier Details');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('detail','Create Supplier Detail'), ['create','sid'=>$sid], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
            //'mobile',
            //'reason:ntext',
            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}'
            ],
        ],
    ]); ?>
</div>
