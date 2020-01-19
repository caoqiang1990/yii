<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '';


?>
<style>
    .option {
        width: 80%;
        /*height: 200px;*/
        border: 1px solid #777;
        margin: auto;
        /*box-shadow:4px 4px 10px #eee; border:1px solid #eee*/
        margin-top: 5px;
    }

    .order {
        height: 36px;
        width: 100%;
        /*border:1px solid red;*/
        line-height: 36px;
        text-align: left;
        padding-left: 10px;
        color: white;
        /*background-color: #ffb74d;*/
        background-color: #3c8dbc;
    }

    .order span {
        float: right;
        margin-right: 10px;
        color: white;
    }

    .option_content {
        padding: 10px;
        text-align: left;
    }

    .option_content p {
        height: 40px;
        line-height: 40px;
    }

    .option_select {

    }

    .headert {
        /*border: 1px solid #777;*/
        margin-bottom: 20px;
    }
</style>
<script>
    function survey() {
        var count = $('.radio_name').length;
        for (var i = 0; i < count; i++) {
            var obj = $('.radio_name')[i];
            var radio_name = $(obj).val();
            if (!$('input[name=' + radio_name + ']:checked').val()) {
                alert('请填写完整！');
                return false;
            } else {
                $('input[name=' + radio_name + ']').focus();
            }
        }
        $('#survey').submit();
    }
</script>
<?php $form = ActiveForm::begin([
    'id' => 'survey'
]); ?>
<input name="question_id" type="hidden" value="<?= $question_id; ?>">
<input name="count" type="hidden" value="<?= count($answers); ?>">
<div class="container-fluid">
    <div class="row header">
        <div class="col-xs-12" class="text-center">
            <div class="option text-center" style="border:none">
                <span style="font-size: 40px"><?= $model->title ?></span>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="option" style="border:none">
                <?= $model->desc; ?>
            </div>
        </div>
    </div>
    <?php
    foreach ($answers as $key => $answer) {
        $order = $key + 1;
        ?>
        <input type="hidden" class="radio_name" value="option_<?= $answer['id'] ?>">
        <div class="row">
            <div class="col-xs-12 text-center">
                <div class="option">
                    <div class="order">第<?= $order ?>题 <span></span>
                    </div>
                    <div class="option_content">
                        <p><?= $answer['title']; ?></p>
                        <div class="option_select">
                            <?php
                            $options = json_decode($answer['options'], true);
                            foreach ($options as $option) {
                                ?>
                                <div class="radio">
                                    <label>
                                        <input class="radio_select" type="radio" name="option_<?= $answer['id'] ?>"
                                               id="optionsRadios1"
                                               value="<?= $option['desc'] ?>">
                                        <?= $option['desc'] ?>
                                    </label>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    ?>
    <div class="row" style="margin-top: 10px">
        <div class="col-xs-12 text-center">
            <input class="btn btn-primary" type="button" onclick="survey()" value="提交">
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <div style="height:20px;width:100%"></div>
</div>