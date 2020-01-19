<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\AnswerAsset;
use yii\helpers\Url;
use mdm\admin\components\Helper;
use yii\bootstrap\Modal;

$this->title = '';
$title = '新增问答';
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
    / / border: 1 px solid #dee5e7;
        overflow-y: hidden;
    }

    .error {
        color: red;
    }

    .form-group {
        margin-bottom: 25px;
    }

</style>
<div class="container-fluid">
    <div class="content">
        <div class="row">
            <div class="cos-xs-12 text-center">
                <?php
                echo Html::a('添加选项', ['answer'], [
                    'id' => 'create',
                    'data-toggle' => 'modal',
                    'data-target' => '#modal_ajax',
                    'class' => 'btn btn-success',
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_ajax" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>