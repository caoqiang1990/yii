<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sname',
            'legal_person',
            'business_license',
            'tax_registration_certificate',
            'orcc',
            'service_authorization_letter',
            'certified_assets',
            'effective_credentials',
            'opening_bank',
            'bank_no',
            'account_name',
            'account_no',
            'registration_certificate',
            'manufacturing_licence',
            'business_certificate',
            'credibility_certificate',
            'headcount',
            'address',
            'telephone',
            'mobile',
            'fax',
            'email:email',
            'contact',
            'url:url',
            'black_box',
            'white_box',
            'remarks:ntext',
            'update_date',
            'operator',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
