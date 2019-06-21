<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\AnswerAsset;
use yii\helpers\Url;

$title = '选项';
$this->params['breadcrumbs'][] = $title;
AnswerAsset::register($this);
?>

<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.6.1/Sortable.min.js"></script>

<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<style>
    .container-fluid {
        padding-top: 20px;
    }

    .content {
        padding: 20px;
        min-height: 88%;
        border: 1px solid #dee5e7;
        border-top-width: 0;
        overflow-y: hidden;
    }

    .list-group {
        cursor: move;
    }

    .list-group .add {
        bottom: -41px;
        z-index: 1;
    }

    .list-group span {
        padding-right: 10px;
    }

    .list-group .answer {
        top: -50px;
    }

    .list-group .edit {
        float: right;
    }

    .list-group li:hover {
        background-color: #e0a7ab;
    }

    .list-group li:hover i {
        opacity: 1;
        cursor: pointer;
    }

    .list-group .edit i {
        opacity: 0;
        padding-left: 20px;
    }

    .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
        z-index: 2;
        color: #fff;
        background-color: #e0a7ab;
        border-color: #e0a7ab;

    }

    .error {
        color: red;
    }

    .form-group {
        margin-bottom: 25px;
    }

</style>
<div class="container-fluid">
    <ul class="nav nav-tabs">
<!--        <li role="presentation" class="active"><a href="#">新增选项</a></li>-->

    </ul>
    <div class="content ">
        <?php $form = ActiveForm::begin([
            'id' => 'myform',
            'method' => 'post',
            'options' => [
                'class' => 'form-horizontal',
                'onkeydown' => "if(event.keyCode==13){return false;}"
            ],
        ]); ?>
        <?= Html::errorSummary($model, ['style' => 'color:red']) ?>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">问答题目:</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="question_title" placeholder="请输入问答题目" value="<?=$model->title;?>">
                <label for="question_title" class="error"
                       style="position: absolute;z-index: 100;display: none">请输入问答题目</label>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">问答描述:</label>

            <div class="col-sm-5">
                <textarea class="form-control" rows="2" name="question_desc" placeholder="描述"><?=$model->desc;?></textarea>

            </div>
        </div>
        <!--    <div class="form-group">
               <label for="" class="col-sm-2 control-label">类型:</label>
               <div class="col-sm-5">
                   <label class="radio-inline">
                       <input type="radio" name="question_type" id="" value="1" checked> 单选
                   </label>
                   <label class="radio-inline">
                       <input type="radio" name="question_type" id="" value="2" > 多选
                   </label>
               </div>

           </div> -->
        <input type="hidden" name="question_type" id="" value="1" checked>
        <div class="form-group" style="display:none">
            <label for="option_sort" class="col-sm-2 control-label">正确选项:</label>
            <div class="col-sm-5">
                <label for="answers" class="error answer_error"
                       style="position: relative;z-index: 100;top: 35px;display: none">请选择正确的答案</label>
            </div>

        </div>
        <div class="form-group" style="margin-top: 1.5%;">
            <label for="" class="col-sm-2 control-label">问答选项:</label>
            <div class="col-sm-5">
                <ul class="list-group">
                    <!--     <li data-id="0" class="list-group-item">
                            <span class="sort">C</span><span class="desc">选项</span>
                            <span class="edit">
                            <i class="choose" title="选为答案">√</i> <i class="remove" title="取消选中">x</i><i class="del" title="删除选项">删除</i>
                        </span>
                        </li> -->

                </ul>
            </div>
        </div>
<!--        <div class="form-group">-->
<!--            <label for="" class="col-sm-2 control-label">占比（单位百分比）:</label>-->
<!---->
<!--            <div class="col-sm-5">-->
<!--                <select name="question_ratio" id="" class="form-control">-->
<!--                    <option --><?= $model->ratio == 10 ? 'selected' : '';  ?><!--  value="10">10%</option>-->
<!--                    <option --><?= $model->ratio == 20 ? 'selected' : '';  ?><!--  value="20">20%</option>-->
<!--                    <option --><?= $model->ratio == 30 ? 'selected' : '';  ?><!--  value="30">30%</option>-->
<!--                    <option --><?= $model->ratio == 40 ? 'selected' : '';  ?><!--  value="40">40%</option>-->
<!--                    <option --><?= $model->ratio == 50 ? 'selected' : '';  ?><!--  value="50">50%</option>-->
<!--                </select>-->
<!--            </div>-->
<!--        </div>-->
        <div class="form-group" style="margin-top: 4%">
            <div class="col-sm-offset-2 col-sm-10">
                <?= Html::submitButton($model->isNewRecord ? '继续,下一选项' : '更新', ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-primary']) ?>
                <?= Html::a($model->isNewRecord ? '预览' : '取消', $model->isNewRecord ? Url::to(['question/preview', 'question_id' => $question_id]) : 'javascript:history.go(-1)', $model->isNewRecord ? ['class' => 'btn btn-primary btn-success'] : ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <input type="hidden" name="question_id" value="<?= $question_id; ?>" checked>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script>
    var option_sort;
    $(function () {
        mysortable = new Mysortable(1, '', '.list-group');
        <?php
            if ($model->options) {
        ?>
        option_sort = eval('<?=$model->options;?>');
        for (var i = 0; i <= option_sort.length; i++) {
            mysortable.addOptions(1, i, option_sort[i].desc);
        }
        <?php }else{ ?>
        for (var i = 1; i <= 4; i++) {
            mysortable.addOptions(1, 0, i);
        }
        // mysortable.addOptions(4,0,1);
        <?php } ?>
        $('input[name=question_type]').change({mysortable: mysortable}, function (e) {
            var mysortable = e.data.mysortable;
            mysortable.type = $(this).val();
            mysortable.obj.find('li').removeClass('active');
            mysortable.store();
        });

    });


</script>