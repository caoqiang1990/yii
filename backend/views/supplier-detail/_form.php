<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierDetail */
/* @var $form yii\widgets\ActiveForm */
?>
<?php  if($detail_obj_list){?>
<div style="border:1px dashed #3c8dbc;padding:20px">
<p>已填信息</p>
<?php foreach($detail_obj_list as $detail){?>
<div class="supplier-detail-form" style="border:1px dashed blue;margin-top: 20px">
    <div class="row">
    <div class="col-xs-6">
        <div class="form-group">
        <label class="control-label"><?= Yii::t('detail','one_level_department') ?></label>
        <input class="form-control" type="text" disabled="disabled" value=<?= $detail->one_level_department?> >
        </div>
    </div>

    <div class="col-xs-6">
        <div class="form-group">
        <label class="control-label"><?= Yii::t('detail','second_level_department') ?></label>
        <input class="form-control" type="text" disabled="disabled" value=<?= $detail->second_level_department?> >
        </div>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
        <label class="control-label"><?= Yii::t('detail','coop_date') ?></label>
        <input class="form-control" type="text" disabled="disabled" value=<?= $detail->coop_date ?>>
        </div>
    </div>
    <div class="col-xs-6">
    <div class="form-group">
    <label class="control-label"><?= Yii::t('detail','coop_fund1') ?></label>
    <input class="form-control" type="text" disabled="disabled" value=<?= $detail->coop_fund1?> >
    </div>
    </div>
    <div class="col-xs-6">
    <div class="form-group">
    <label class="control-label"><?= Yii::t('detail','trade_fund1') ?></label>
    <input class="form-control" type="text" disabled="disabled" value=<?= $detail->trade_fund1?> >
    </div>
    </div>
    <div class="col-xs-6">
    <div class="form-group">
    <label class="control-label"><?= Yii::t('detail','coop_fund2') ?></label>
    <input class="form-control" type="text" disabled="disabled" value=<?= $detail->coop_fund2?> >
    </div>
    </div>
    <div class="col-xs-6">
    <div class="form-group">
    <label class="control-label"><?= Yii::t('detail','trade_fund2') ?></label>
    <input class="form-control" type="text" disabled="disabled" value=<?= $detail->trade_fund2?> >
    </div>
    </div>
    <div class="col-xs-6">
    <div class="form-group">
    <label class="control-label"><?= Yii::t('detail','coop_fund3') ?></label>
    <input class="form-control" type="text" disabled="disabled" value=<?= $detail->coop_fund3?> >
    </div>
    </div>
    <div class="col-xs-6">
    <div class="form-group">
    <label class="control-label"><?= Yii::t('detail','trade_fund3') ?></label>
    <input class="form-control" type="text" disabled="disabled" value=<?= $detail->trade_fund3?> >
    </div>
    </div>   
    <div class="col-xs-6">
    <div class="form-group">
    <label class="control-label"><?= Yii::t('detail','name') ?></label>
    <input class="form-control" type="text" disabled="disabled" value=<?= $detail->name?> >
    </div>
    </div> 
    <div class="col-xs-6">
    <div class="form-group">
    <label class="control-label"><?= Yii::t('detail','mobile') ?></label>
    <input class="form-control" type="text" disabled="disabled" value=<?= $detail->mobile?> >
    </div>
    </div>
    <div class="col-xs-12">
    <div class="form-group">
    <label class="control-label"><?= Yii::t('detail','reason') ?></label>
    <textarea class="form-control" type="text" disabled="disabled" rows="6"> <?=$detail->reason?></textarea>
    </div>
    </div>              
    </div>
</div>
<?php } ?>
</div>
<?php } ?>

<div class="supplier-detail-form">

  <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'sid')->label(false)->hiddenInput(['value' => $sid]) ?>

    <div class="row">
    <div class="col-xs-6">
    <?= $form->field($model, 'level')->dropDownList($level) ?>
    </div>    
    <div class="col-xs-6">
    <?= $form->field($model, 'one_level_department')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-xs-6">
    <?= $form->field($model, 'second_level_department')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <div class="form-group field-supplier-coop_date required">
    <label class="control-label" for="supplier-coop_date">合作起始时间</label>
    <?= DatePicker::widget([
    'model' => $model,
    'attribute' => 'coop_date',
    'template' => '{addon}{input}',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);?>
    </div>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'coop_fund1')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'trade_fund1')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fund_year1')->hiddenInput(['maxlength' => true])->label(false) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'coop_fund2')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'trade_fund2')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fund_year2')->hiddenInput(['maxlength' => true])->label(false) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'coop_fund3')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'trade_fund3')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fund_year3')->hiddenInput(['maxlength' => true])->label(false) ?>
    
    </div>                    
    <div class="col-xs-6">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
    </div>    
    <div class="col-xs-12"> 
    <?= $form->field($model, 'reason')->textArea(['rows'=>6]) ?>
    </div>    
    <div class="form-group">
    <div class="col-xs-12">

        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>    
        <?php  if($detail_obj_list){?>
        <?php //Html::a('追加一个与我方关系',Url::to(['supplier-detail/create','sid'=>$sid]))
        ?>
        <?php } ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>
    </div>

</div>
<?= Html::jsFile('@web/plugin/timepicker/bootstrap-datepicker.js') ?>
<script>
$(function () {
  //Date picker
  $('#datepicker').datepicker({
    autoclose: true,
    format:'yyyy-mm-dd'
  })
})

</script>
