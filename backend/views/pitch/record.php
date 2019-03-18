<?php

use mdm\admin\models\User;

$this->title = '';

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
        min-height: 100%;
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
        <li role="presentation" class="active"><a href="#">比稿记录</a></li>
    </ul>
    <div class="content">
        <div class="row">
            <div class="form-group">
                <label for="" class="col-xs-2 control-label">项目名称:</label>
                <div class="col-sm-5">
                    <?= $model->name ? $model->name : '无' ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label for="" class="col-xs-2 control-label">项目描述:</label>

                <div class="col-sm-5">
                    <?= $model->desc ? $model->desc : '无' ?>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="form-group">
                <label for="" class="col-xs-2 control-label">项目备注:</label>

                <div class="col-sm-5">
                    <?= $model->remark ? $model->remark : '无'; ?>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="form-group">
                <label for="" class="col-xs-2 control-label">上传记录:</label>

                <div class="col-sm-5">
                    <?php if ($model->record_url) { ?>
                    <a href="<?= $model->record_url ?>" target="_blank"><img style="width:100px"
                                                                             src="<?= $model->record_url ?>"></a>
                    <?php } else { ?>
                        无
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 10px;margin-bottom: 10px">
            <div class="form-group">
                <label for="" class="col-xs-2 control-label">审核记录:</label>

                <div class="col-sm-5">
                    <ul class="timeline">
                        <!-- timeline time label -->
                        <?php if (!empty($records)) { ?>
                            <?php foreach ($records as $record) { ?>
                                <?php if (!$record['attachment']) { ?>
                                    <li class="time-label">
                  <span class="bg-red">
                    <?= date('Y-m-d H:i:s', $record['created_at']) ?>
                  </span>
                                    </li>
                                    <!-- /.timeline-label -->
                                    <li>
                                        <i class="fa fa-user bg-aqua"></i>

                                        <div class="timeline-item">
                                            <!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->

                                            <h3 class="timeline-header no-border"><a
                                                        href="#"><?= User::findIdentity($record['created_by'])->username ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<?= $record['content'] ?>
                                            </h3>
                                        </div>
                                    </li>
                                <?php } ?>
                                <?php if ($record['attachment']) { ?>
                                    <li class="time-label">
              <span class="bg-red">
                <?= date('Y-m-d H:i:s', $record['created_at']) ?>
              </span>
                                    </li>
                                    <li>
                                        <i class="fa fa-camera bg-purple"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="fa"></i></span>

                                            <h3 class="timeline-header"><?= $record['content'] ?></h3>

                                            <div class="timeline-body">
                                                <?php foreach ($record['url'] as $url) { ?>
                                                    <?php if ($url['filetype'] == 'image') {?>
                                                    <a href="<?= $url['url'] ?>" target="_blank">
                                                        <img src="<?= $url['url'] ?>" style="height:50px" class="margin">
                                                    </a>
                                                    <?php } ?>

                                                    <?php if ($url['filetype'] == 'file') {?>
                                                        <a href="<?= $url['url'] ?>" target="_blank">
                                                            <span><?=$url['filename']?></span>
                                                        </a>
                                                    <?php } ?>

                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>

                            <?php } ?>
                            <!-- END timeline item -->
                            <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                            </li>
                        <?php } else { ?>
                            <li>暂无留言</li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="form-group">
                <label for="" class="col-xs-2 control-label">项目结果:</label>

                <div class="col-sm-5">
                    <?= $model->result ? $model->result : '无'; ?>
                </div>
            </div>
        </div>
    </div>
</div>