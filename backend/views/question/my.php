<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;
use yii\web\View;
use yii\helpers\Url;
use backend\models\TemplateRecord;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PitchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = '我参与的评论';


$js = <<<JS
//此处点击按钮提交数据的jquery
$('.finish').click(function(){
    var id = $(this).attr('data-id');
    $.ajax({
            url: "finish",
            type: "POST",
            dataType: "json",
            data: {'id':id},
            success: function(data) {
                if (data.status == 'success') {
                    alert(data.msg);
                    location.reload();
                }                    
                if (data.status == 'fail') {
                    alert(data.msg);
                }
            },
            error: function() {
                alert('网络错误！');
            }
        });
})

$('.start').click(function(){
    var id = $(this).attr('data-id');
    $.ajax({
            url: "start",
            type: "POST",
            dataType: "json",
            data: {'id':id},
            success: function(data) {
                if (data.status == 'success') {
                    alert(data.msg);
                    location.reload();
                }                    
                if (data.status == 'fail') {
                    alert(data.msg);
                }
            },
            error: function() {
                alert('网络错误！');
            }
        });
})
JS;
$this->registerJs($js, View::POS_READY);
?>
<div class="question-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'title',
            'desc:ntext',
            'start_date',
            'end_date',
            [
                //'label'=>  (Helper::checkRoute('supplier-detail/create') || Helper::checkRoute('history/index')) ? '更多操作' : '',
                'label' => (Helper::checkRoute('template/survey')) ? '更多操作' : '',
                'format' => 'raw',
                'value' => function ($model) {
                    $operator_1 = '';
                    $operator_2 = '';
                    if (Helper::checkRoute('template/survey')) {
                        $templateRecordModel = new TemplateRecord();
                        $user_id = Yii::$app->user->identity->id;
                        $hasFinished = $templateRecordModel->hasTemplateRecord($model->template_id, $model->id, $user_id);
                        if (!$hasFinished) {
                            $url_2 = Url::to(['template/survey', 'template_id' => $model->template_id,'question_id'=>$model->id]);
                            $operator_2 = Html::a('评价', $url_2, ['title' => '评价', 'class' => '', 'data-id' => $model->id]);
                        } else {
                            $url_2 = Url::to(['template/result', 'template_id' => $model->template_id,'question_id'=>$model->id]);
                            $operator_2 = Html::a('评价结果', $url_2, ['title' => '评价结果', 'class' => '', 'data-id' => $model->id]);
                        }
                    }
                    return $operator_1 . ' ' . $operator_2;
                }

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
