<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mdm\admin\models\User;

$this->title = '';
?>
    <div class="row text-center">
      <div class="col-xs-6 text-right"><label>项目名称:</label></div>
      <div class="col-xs-6 text-left"><?=$pitchModel->name;?></div>   
    </div>
    <div class="row text-center">
      <div class="col-xs-6 text-right"><label>项目描述:</label></div>
      <div class="col-xs-6 text-left"><?=$pitchModel->desc;?></div>   
    </div>
    <div class="row">
        <div class="col-xs-6 text-right"><label>项目附件:</label></div>
        <div class="col-xs-6">
        <?php if (!empty($initialPreview)) { ?>
        <?php foreach($initialPreview as $url) { ?>
            <a href="<?= $url?>" target="_blank"><img class="img-responsive"  src="<?= $url ?>" style="height:100px;display:inline-block;margin-right:10px"></a>
        <?php } ?>
        <?php } else { ?>
            无
        <?php } ?>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
      <!-- row -->
      <div class="row">
        <div class="col-md-12">
          <!-- The time line -->
          <ul class="timeline">
            <!-- timeline time label -->
            <?php if (!empty($records)) {?>
            <?php foreach($records as $record) {?>
            <li class="time-label">
                  <span class="bg-red">
                    <?= date('Y-m-d H:i:s',$record['created_at'])?>
                  </span>
            </li>
            <!-- /.timeline-label -->
            <li>
              <i class="fa fa-user bg-aqua"></i>

              <div class="timeline-item">
                <!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->

                <h3 class="timeline-header no-border"><a href="#"><?= User::findIdentity($record['created_by'])->username ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<?= $record['content']?></h3>
              </div>
            </li>
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
        <!-- /.col -->
      </div>

    </section>
    <?php $form = ActiveForm::begin(); ?>
      <div class="form-group margin-bottom-none">
          <?= $form->field($model, 'pitch_id')->hiddenInput()->label(false) ?>
        <div class="col-sm-9">
          <?= $form->field($model, 'content')->textInput(['maxlength' => true,'placeholder'=>'留言','class'=>'form-control input-sm'])->label(false) ?>
        </div>
        <div class="col-sm-3">
          <?= Html::submitButton('提交', ['class' => 'btn btn-danger pull-right btn-block btn-sm']) ?>
        </div>
      </div>

    <?php ActiveForm::end(); ?>
