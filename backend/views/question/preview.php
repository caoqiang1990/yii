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

    .header {
        /*border: 1px solid #777;*/
        margin-bottom: 20px;
    }
</style>

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
        <div class="row">
            <div class="col-xs-12 text-center">
                <div class="option">
                    <div class="order">第<?= $order ?>题 <span><a class="btn" style="color:white !important;"
                                                                href="<?= Url::to(['answer/update', 'id' => $answer['id'], 'question_id' => $question_id]) ?>">编辑</a></span>
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
                                        <input type="radio" name="option_<?= $key + 1 ?>" id="optionsRadios1"
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
    <div style="height:20px;width:100%"></div>
</div>