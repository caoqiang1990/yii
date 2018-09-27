<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Menu */

$this->title = Yii::t('vendor', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a(Yii::t('vendor', 'Create Menu'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'columns' => [
        'id',
        [
            'attribute' => 'vendorname',
            'content' => function($dataProvider){
                return $dataProvider['vendorname'];
            },
        ],
        [
            'attribute' => 'created_at',
            'format' =>  ['date', 'php:Y-m-d H:i:s'],
        ],

    ],
]); ?>

</div>
