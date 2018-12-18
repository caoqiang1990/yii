<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\SupplierLevel;
use backend\models\SupplierTrade;
use backend\models\SupplierType;
use backend\models\SupplierCategory;
use backend\models\Attachment;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */

$this->title = \Yii::t('suppliers','DetailView');
$this->params['breadcrumbs'][] = ['label' => Yii::t('suppliers', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('suppliers', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('suppliers', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('suppliers', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            // [
            //     'attribute' => 'level',
            //     'value' => function($model){
            //         return SupplierLevel::getLevelById($model->level)->level_name;
            //     }
            // ],
			[
                 'attribute' => 'trade',
                 'value' => function($model){
                     return SupplierTrade::getTradeById($model->trade)->trade_name;
                 }
            ],
            'url',
            'business_address',
            'register_date',
            'coop_content',
            
			'business_contact',               // title attribute (in plain text)
			'business_position:html',    // description attribute in HTML
			'business_phone',
			'business_mobile',
			[
                 'attribute' => 'business_type',
                 'value' => function($model){
                     return SupplierType::getTypeById($model->business_type)->type_name;
                 }
            ],
			'business_email',
			'business_scope',
			'business_customer1',
			'business_customer2',
			'business_customer3',
			'material_name1',
			'material_name2',
			'material_name3',
			'instrument_device1',
			'instrument_device2',
			'instrument_device3',
			'instrument_device4',
			[
				'attribute' => 'enterprise_code',
				'label' => $model->getAttributeLabel('enterprise_code_image_id'),//Yii::t('suppliers','enterprise_code'),
				'value' => Html::img(Attachment::findOne($model->enterprise_code)->url, ['alt' => 'enterprise_code']),
			],
			[
				'attribute' => 'enterprise_license',
				'label' => $model->getAttributeLabel('enterprise_license_image_id'),//Yii::t('suppliers','enterprise_license'),
				'value' => Html::img(Attachment::findOne($model->enterprise_license)->url, ['alt' => 'enterprise_license']),
			],
			[
				'attribute' => 'enterprise_license_relate',
				'label' => $model->getAttributeLabel('enterprise_license_relate_image_id'),//Yii::t('suppliers','enterprise_license_relate'),
				'value' => Html::img(Attachment::findOne($model->enterprise_license_relate)->url, ['alt' => 'enterprise_license_relate']),
			],
			[
				'attribute' => 'enterprise_certificate',
				'label' => $model->getAttributeLabel('enterprise_certificate_image_id'),//Yii::t('suppliers','enterprise_certificate'),
				'value' => Html::img(Attachment::findOne($model->enterprise_certificate)->url, ['alt' => 'enterprise_certificate']),
			],
			[
				'attribute' => 'enterprise_certificate_etc',
				'label' => $model->getAttributeLabel('enterprise_certificate_etc_image_id'),//Yii::t('suppliers','enterprise_certificate_etc'),
				'value' => Html::img(Attachment::findOne($model->enterprise_certificate_etc)->url, ['alt' => 'enterprise_certificate_etc']),
			],
			'created_at:datetime', // creation date formatted as datetime
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
