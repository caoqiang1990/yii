
<?php
 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 
/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
$this->title = '分类列表';
$this->params['breadcrumbs'][] = $this->title;
?>
 
<div class="category-form">
    <?php $form = ActiveForm::begin([
      'options' => ['data' =>['id'=>1,'name'=>2],'autoIdPrefix' => 'dddd_'],
      'method' => 'get',
      'id' => '你大业',
      'action' => 'www.baidu.com',
      'fieldClass' =>'yii\widgets\ActiveField',
      'ajaxParam' =>'ddd'
      
    ]); ?>
    <?= $form->field($model, 'cate_name')->textInput(['value' => '回显内容 ']) ?>
    <?= $form->field($model,'pid')->dropDownList($list)?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>