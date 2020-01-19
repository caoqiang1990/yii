<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Department;
use backend\models\Attachment;

/* @var $this yii\web\View */
/* @var $model backend\models\Document */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('document', 'Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-view">


    <p>
        <?= Html::a(Yii::t('document', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('document', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('document', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'department',
                'value' => function ($model) {
                    return Department::getDepartmentById($model->department) ? Department::getDepartmentById($model->department)->department_name : NULL;
                }
            ],
            [
                'attribute' => 'doc',
                'format' => [
                    'image',
                    [
                        'height' => '50',
                        'weight' => '50'
                    ]
                ],
                'value' => function ($model) {
                    if ($model->doc) {
                        $attachmentModel = new Attachment();
                        $attach = $attachmentModel->getAttachByID($model->doc);
                        return $attach->url;
                    } else {
                        return null;
                    }
                }
            ],
        ],
    ]) ?>

</div>
