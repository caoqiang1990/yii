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
    <table class="table table-bordered">
        <tr class="theader">
            <th></th>
            <th>考评关键点</th>
            <th>分值<br/>权重</th>
            <th>80-100</th>
            <th>50-79</th>
            <th>0-49</th>
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
                <td><?= $form->field($templaterecordmodel, 'result_' . $order)->textInput(['disabled' => true])->label(false); ?></td>
                <?php
                if ($order == 1) {

                    ?>
                    <td style="vertical-align: middle;text-align: center" <?= $order == 1 ? "rowspan='$count'" : ""; ?>>
                        <b>合作项目:</b><?= Question::findOne($question_id)->title ?>
                        <p style="font-size: 10px">请根据该合作项目填写合作感受</p>
                        <?= $form->field($templaterecordmodel, 'reason')->textarea(['rows' => 6,'disabled' => true])->label(false);?>
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
            <td style="vertical-align: middle;"><?= $form->field($templaterecordmodel, 'department')->textInput(['disabled' => true])->label('评价事业部'); ?></td>
            <td style="vertical-align: middle;"><?= $form->field($templaterecordmodel, 'operator')->textInput(['disabled' => true])->label('经办人'); ?></td>
            <td style="vertical-align: middle;"><?= $form->field($templaterecordmodel, 'total')->textInput(['disabled' => true])->label('实际得分'); ?></td>
            <td style="vertical-align: middle;text-align: center"></td>
            <td style="vertical-align: middle;">
                是否还有合作意向： <?= $form->field($templaterecordmodel, 'is_satisfy')->checkboxList(['1' => '是', '0' => '否'],['itemOptions'=>['disabled'=>true]])->label(false); ?></td>
        </tr>
    </table>
    <?php ActiveForm::end(); ?>
    <div style="height:20px;width:100%"></div>
</div>