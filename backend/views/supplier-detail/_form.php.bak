<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierDetail */
/* @var $form yii\widgets\ActiveForm */

$formatJS = <<<JS
    var dataCateID_1 = function(params){
        return {cate_id:'1'};
    };
    var dataCateID_2 = function(params){
        var cate_id1 = $('#supplierdetail-cate_id1').val()
        var cate_id = cate_id1.join('-');
        return {cate_id1:cate_id};
    };
    var dataCateID_3 = function(params){
        var cate_id2 = $('#supplierdetail-cate_id2').val()
        var cate_id = cate_id2.join('-');
        return {cate_id2:cate_id};
    };    
    var unSelect_1 = function(){
        $('#supplierdetail-cate_id2').select2('val',0);
        $('#supplierdetail-cate_id3').select2('val',0);
    }
    var unSelect_2 = function(){
        $('#supplierdetail-cate_id3').select2('val',0);
    }    
JS;


$this->registerJs($formatJS, View::POS_HEAD);
$resultsJs = <<<JS
function (data,params) {
    return data;
}
JS;
?>
<?php  if($detail_obj_list){?>
<div style="padding:20px">
<p><h4>已填信息</h4></p>
<?php foreach($detail_obj_list as $detail){?>
<div class="supplier-detail-form" style="margin-top: 20px;border-bottom:1px dashed #3c8dbc">
    <div class="row">
    <div class="col-xs-6">
        <div class="form-group">
        <label class="control-label"><?= Yii::t('detail','cate_id1') ?></label>
        <input class="form-control" type="text" disabled="disabled" value=<?= $detail->cate_id1?> >
        </div>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
        <label class="control-label"><?= Yii::t('detail','cate_id2') ?></label>
        <input class="form-control" type="text" disabled="disabled" value=<?= $detail->cate_id2?> >
        </div>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
        <label class="control-label"><?= Yii::t('detail','cate_id3') ?></label>
        <input class="form-control" type="text" disabled="disabled" value=<?= $detail->cate_id3?> >
        </div>
    </div>            
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
        <label class="control-label"><?= Yii::t('detail','develop_department') ?></label>
        <input class="form-control" type="text" disabled="disabled" value=<?= $detail->develop_department?> >
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
    <?= //$form->field($model, 'business_type')->dropDownList($type) 
        $form->field($model, 'cate_id1')->widget(Select2::classname(), [
            //'value' => $model->cate_id1,
            'options' => [
                'placeholder' => '请选择总类',
                'multiple' => true
                ],
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => Url::to(['get-all-cate']),
                    'dataType' => 'json',
                    'data' => new JsExpression('dataCateID_1'),
                    'processResults' => new JsExpression($resultsJs),
                    //'cache' => true,
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(result) { return result.category_name; }'),
                'templateSelection' => new JsExpression('function (select) { return select.category_name; }'),
            ],
            'pluginEvents' => [
                "change" => "function() { console.log('change'); }",
                "select2:opening" => "function() { console.log('select2:opening'); }",
                "select2:open" => "function() { console.log('open'); }",
                "select2:closing" => "function() { console.log('close'); }",
                "select2:close" => "function() { console.log('close'); }",
                "select2:selecting" => "function() { console.log('selecting'); }",
                "select2:select" => "function() { console.log('select'); }",
                "select2:unselecting" => "function() { console.log('unselecting'); }",
                "select2:unselect" => new JsExpression('unSelect_1')
            ]

        ]);
    ?>
    </div>
   <div class="col-xs-6">
    <?= //$form->field($model, 'business_type')->dropDownList($type) 
        $form->field($model, 'cate_id2')->widget(Select2::classname(), [
            'options' => [
                'placeholder' => '请选择大类',
                'multiple' => true
                ],
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => Url::to(['get-all-cate']),
                    'dataType' => 'json',
                    'data' =>  new JsExpression('dataCateID_2'),
                    //'data' =>  {'qid':$('#supplierdetail-cate_id1').val()},
                    'cache' => true,
                ],
                'escapeMarkup' => new JsExpression('function (markup) { console.log(markup);  return markup; }'),
                'templateResult' => new JsExpression('function(result) { console.log(result); return result.category_name; }'),
                'templateSelection' => new JsExpression('function (select) { console.log(select);  return select.category_name; }'),
            ],
            'pluginEvents' => [
                "change" => "function() { console.log('change'); }",
                "select2:opening" => "function() { console.log('select2:opening'); }",
                "select2:open" => "function() { console.log('open'); }",
                "select2:closing" => "function() { console.log('close'); }",
                "select2:close" => "function() { console.log('close'); }",
                "select2:selecting" => "function() { console.log('selecting'); }",
                "select2:select" => "function() { console.log('select'); }",
                "select2:unselecting" => "function() { console.log('unselecting'); }",
                "select2:unselect" => new JsExpression('unSelect_2')
            ]

        ]);
    ?>
    </div>    
    <div class="col-xs-6">
    <?= //$form->field($model, 'business_type')->dropDownList($type) 
        $form->field($model, 'cate_id3')->widget(Select2::classname(), [
            'options' => [
                'placeholder' => '请选择子类',
                'multiple' => true
                ],
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => Url::to(['get-all-cate']),
                    'dataType' => 'json',
                    'data' =>  new JsExpression('dataCateID_3'),
                    //'data' =>  {'qid':$('#supplierdetail-cate_id1').val()},
                    'cache' => true,
                ],
                'escapeMarkup' => new JsExpression('function (markup) { console.log(markup);  return markup; }'),
                'templateResult' => new JsExpression('function(result) { console.log(result); return result.category_name; }'),
                'templateSelection' => new JsExpression('function (select) { console.log(select);  return select.category_name; }'),
            ],
            'pluginEvents' => [
                "change" => "function() { console.log('change'); }",
            ]

        ]);
    ?>
    </div>        
    <div class="col-xs-6">
    <?= $form->field($model, 'level')->dropDownList($level,['prompt'=>'请选择等级']) ?>
    </div>    
    <div class="col-xs-6">
    <?= $form->field($model, 'one_level_department')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'second_level_department')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'develop_department')->textInput(['maxlength' => true]) ?>
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
