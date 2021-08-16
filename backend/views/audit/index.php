<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\models\SupplierLevel;
use backend\models\SupplierCategory;
use backend\models\SupplierTrade;
use mdm\admin\components\Helper;
use backend\models\Department;
use mdm\admin\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SuppliersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '待审核';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-index">

  <?php Pjax::begin(); ?>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'pager' => [
        //'options'=>['class'=>'hidden']//关闭分页
          'firstPageLabel' => '首页',
          'lastPageLabel' => '尾页',
          'maxButtonCount' => 5,
      ],
      'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
          [
              'attribute' => 'name',
              'format' => 'raw',
              'value' => function ($model) {
                if (Helper::checkRoute('view')) {
                  $url = Url::to(['view', 'id' => $model->id]);
                  $options = ['title' => $model->name];
                  return Html::a($model->name, $url, $options);
                } else {
                  return $model->name;
                }
              }
          ],
          [
              'attribute' => 'action',
              'value' => function ($model) {
                $name_arr = [
                    '10' => '正常',
                    '11' => '新增供应商',
                    '12' => '信息变更',
                ];
                $action = $model->action;
                return $action ? $name_arr[$action] : '';
              },
              'filter' => [
                  '10' => '正常',
                  '11' => '新增供应商',
              ],
          ],
          [
              'attribute' => 'status',
              'label' => '状态',
              'value' => function ($model) {
                switch ($model->status) {
                  case '10':
                    $text = '正常';
                    break;
                  case 'wait':
                    $text = '待完善';
                    break;
                  case 'auditing':
                    $text = '待审核';
                    break;
                  default:
                    $text = '';
                    break;
                }
                return $text;
              },
              'filter' => $status,
          ],
          [
              'attribute' => '',
              'label' => '申请人',
              'value' => function ($model) {
                $user = User::findOne($model->created_by);
                return $user ? $user->truename : '';
              },
              'filter' => User::getUsers(),
              'headerOptions' => [
                  'width' => '100px'
              ]
          ],
          [
              'attribute' => '',
              'label' => '部门',
              'value' => function ($model) {
                if ($model->department) {
                  return Department::getDepartmentById($model->department) ? Department::getDepartmentById($model->department)->department_name : NULL;
                } else {
                    return '';
                }
              },
          ],
          [
            //'label'=>  (Helper::checkRoute('supplier-detail/create') || Helper::checkRoute('history/index')) ? '更多操作' : '',
              'label' => '更多操作',
              'format' => 'raw',
              'value' => function ($model) {
                $operator_1 = '';
                $operator_2 = '';
                if (Helper::checkRoute('audit')) {
                  $url_1 = Url::to(['audit', 'id' => $model->id]);
                  $operator_1 = Html::a('审核', $url_1, ['title' => '审核']);

                }

                if (Helper::checkRoute('audit/qrcode')) {
                  $url_2 = Url::to(['audit/qrcode', 'id' => $model->id]);
                  $operator_2 = Html::a('生成二维码', $url_2, ['title' => '生成二维码']);
                }
                return $operator_1 . ' | ' . $operator_2;
              }
          ],
      ],
  ]); ?>
  <?php Pjax::end(); ?>
</div>
