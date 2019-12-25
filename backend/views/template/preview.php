<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '';


?>
<style>
    .theader th {
        vertical-align: middle !important;
        text-align: center !important;
        background-color: #777;
        border:1px solid black !important;
    }
    table td{border:1px solid black !important;}
    .tfooter td {
        font-weight:bolder;
    }
</style>

<div class="container-fluid">

    <table class="table table-bordered">
        <tr class="theader">
            <th></th>
            <th>考评关键点</th>
            <th>分值<br />权重</th>
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
            <tr >
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
                <td></td>
                <?php
                if ($order == 1) {

                    ?>
                    <td style="vertical-align: middle;text-align: center" <?= $order == 1 ? "rowspan='$count'" : ""; ?>>
                        <b>合作项目：</b>____________
                        <br />
                        <b>请根据该合作项目填写合作感受</b>
                        <br />____________
                        <br />
                        <br />
                        <br />
                    </td>
                    <?php
                }
                ?>
            </tr>

            <?php
        }
        ?>
        <tr class="tfooter" >
            <td colspan="2" style="vertical-align: middle;text-align: center">合计</td>
            <td style="vertical-align: middle;text-align: center">100</td>
            <td style="vertical-align: middle;">评价事业部____________</td>
            <td style="vertical-align: middle;">经办人____________</td>
            <td colspan="2" style="vertical-align: middle;">实际得分____________</td>
            <td style="vertical-align: middle;text-align: center"></td>
        </tr>
    </table>
    <div style="height:20px;width:100%"></div>
</div>