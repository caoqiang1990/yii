<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Pitch */

$this->title = '';
$this->params['breadcrumbs'][] = '比稿详情';
?>
<div class="pitch-view">

    <p>
        <a class="btn btn-primary" href="javascript:history.go(-1)">返回</a>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'desc',
            'start_date',
            'end_date',
            //'sids:ntext',
            //'record',
            'remark',
            'result:ntext',
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    return date('Y-m-d H:i:s',$model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($model){
                    return date('Y-m-d H:i:s',$model->updated_at);
                }
            ],
        ],
    ]) ?>

</div>
