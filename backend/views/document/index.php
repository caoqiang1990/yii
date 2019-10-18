<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Department;
use backend\models\Attachment;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = Yii::t('document', 'Documents');
?>
<div class="document-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('document', 'Create Document'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
//          [
//              'attribute' => 'department',
//              'value' => function ($model) {
//                return Department::getDepartmentById($model->department) ? Department::getDepartmentById($model->department)->department_name : NULL;
//              }
//          ],
            [
                'attribute' => 'cate',
                'value' => function ($model) {
                    $cate = [
                        '集团文件',
                        '品牌媒介',
                        '综采&工程',
                        '产品实现',
                        '装修监理',
                        '系统支持'
                    ];
                    return $model->cate ? $cate[$model->cate] : NULL;
                },
                'filter' => [
                    '集团文件',
                    '品牌媒介',
                    '综采&工程',
                    '产品实现',
                    '装修监理',
                    '系统支持']
            ],
            'doc_name',
            [
                'attribute' => 'doc',
                'value' => function ($model) {
                    if ($model->doc) {
                        $attachmentModel = new Attachment();
                        $attach = $attachmentModel->getAttachByID($model->doc);
                        $url = $attach->url;
                        $options = ['title' => $attach->filename, 'target' => '_blank'];
                        return Html::a($attach->filename, $url, $options);
                    } else {
                        return null;
                    }

                },
                'format' => 'raw',

            ],
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
