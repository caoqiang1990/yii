<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SuppliersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('suppliers', 'Suppliers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('suppliers', 'Create Suppliers'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'sname',
            'legal_person',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
