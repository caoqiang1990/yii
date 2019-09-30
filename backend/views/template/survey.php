<?php

use yii\widgets\ActiveForm;
use backend\models\Question;

$this->title = '';


?>
<style>
    .theader th {
        vertical-align: middle !important;
        text-align: center !important;
        background-color: #777;
    }

    .tfooter td {
        font-weight: bolder;
    }
</style>
<script>
    function survey() {
        $('#survey').submit();
    }
</script>
<?php $form = ActiveForm::begin([
    'id' => 'survey'
]); ?>

<div class="container-fluid">
    <?= $form->field($templaterecordmodel, 'template_id')->hiddenInput(['value' => $template_id])->label(false); ?>
    <?= $form->field($templaterecordmodel, 'question_id')->hiddenInput(['value' => $question_id])->label(false); ?>
    <?= $form->field($templaterecordmodel, 'count')->hiddenInput(['value' => count($answers)])->label(false); ?>
    <table class="table table-bordered">
        <tr class="theader">
            <th></th>
            <th>考评关键点</th>
            <th>分值<br/>权重</th>
            <th>80%-100%</th>
            <th>50%-79%</th>
            <th>0%-49%</th>
            <th>项目打分</th>
            <th>合作整体过程重点描述</th>
        </tr>
        <?php
        $count = count($answers);
        foreach ($answers as $key => $answer) {
            $order = $key + 1;
            ?>
            <tr>
                <?php
                if ($order == 1) {

                    ?>
                    <td style="vertical-align: middle;text-align: center" <?= $order == 1 ? "rowspan='$count'" : ""; ?>><?= $model->name; ?></td>
                    <?php
                }
                ?>
                <td><?= $answer['title']; ?></td>
                <td><?= $answer['weight']; ?></td>
                <td><?= $answer['options_1']; ?></td>
                <td><?= $answer['options_2']; ?></td>
                <td><?= $answer['options_3']; ?></td>
                <td><?= $form->field($templaterecordmodel, 'result_' . $order)->textInput()->label(false); ?></td>
                <?php
                if ($order == 1) {

                    ?>
                    <td style="vertical-align: middle;text-align: center" <?= $order == 1 ? "rowspan='$count'" : ""; ?>>
                        <b>合作项目:</b> <?= Question::findOne($question_id)->title ?><br />
                        <p style="font-size:10px !important;">请根据该合作项目填写合作感受</p>
                        <?= $form->field($templaterecordmodel, 'reason')->textarea(['rows' => 6])->label(false); ?>
                    </td>
                    <?php
                }
                ?>
            </tr>

            <?php
        }
        ?>
        <tr class="tfooter">
            <td colspan="2" style="vertical-align: middle;text-align: center">合计</td>
            <td style="vertical-align: middle;text-align: center">100</td>
            <td style="vertical-align: middle;"><?= $form->field($templaterecordmodel, 'department')->textInput()->label('评价事业部'); ?></td>
            <td style="vertical-align: middle;"><?= $form->field($templaterecordmodel, 'operator')->textInput()->label('经办人'); ?></td>
            <td style="vertical-align: middle;"><?= $form->field($templaterecordmodel, 'total')->textInput()->label('实际得分'); ?></td>
            <td style="vertical-align: middle;text-align: center"></td>
            <td style="vertical-align: middle;">
                是否还有合作意向： <?= $form->field($templaterecordmodel, 'is_satisfy')->checkboxList(['1' => '是', '0' => '否'])->label(false); ?></td>
        </tr>
    </table>

    <div class="row" style="margin-top: 10px">
        <div class="col-xs-12 text-center">
            <input class="btn btn-primary" type="button" onclick="survey()" value="提交">
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <div style="height:20px;width:100%"></div>
</div>