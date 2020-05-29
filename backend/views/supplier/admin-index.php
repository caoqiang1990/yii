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

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SuppliersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '集团供应商';
$this->params['breadcrumbs'][] = ['label' => '供应商名录查询', 'url' => \yii\helpers\Url::to(['supplier/admin-index'])];
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
                if (Helper::checkRoute('admin-view')) {
                  $url = Url::to(['admin-view', 'id' => $model->id]);
                  $options = ['title' => $model->name];
                  return Html::a($model->name, $url, $options);
                } else {
                  return $model->name;
                }
              }
          ],
          [
              'attribute' => 'cate_id1',
              'value' => function ($model) {
                $categoryModel = new SupplierCategory;
                return $categoryModel::getCategoryById($model->cate_id1) ? $categoryModel::getCategoryById($model->cate_id1)->category_name : '';
              },
              'filter' => SupplierCategory::getCategoryByParams('id,category_name', 1),
          ],
          [
              'attribute' => 'cate_id2',
              'value' => function ($model) {
                $categoryModel = new SupplierCategory;
                return $categoryModel::getCategoryById($model->cate_id2) ? $categoryModel::getCategoryById($model->cate_id2)->category_name : '';
              },
              'filter' => $cate2,
          ],
//          [
//              'attribute' => 'cate_id3',
//              'value' => function ($model) {
//                $categoryModel = new SupplierCategory;
//                return $categoryModel::getCategoryById($model->cate_id3) ? $categoryModel::getCategoryById($model->cate_id3)->category_name : '';
//              },
//              'filter' => $cate3,
//          ],
          [
              'attribute' => 'level',
              'value' => function ($model) {
                $levelModel = new SupplierLevel;
                return $levelModel::getLevelById($model->level) ? $levelModel::getLevelById($model->level)->level_name : '';
              },
              'filter' => SupplierLevel::getLevel(),
          ],
          [
              'attribute' => 'cooperate',
              'value' => function ($model) {
                return $model->cooperate == 1 ? '未合作' : '合作';
              },
              'filter' => [1 => '未合作', 2 => '合作'],
          ],
        // [
        //     'attribute' => 'trade',
        //     'value' => function($model){
        //         return SupplierTrade::getTradeById($model->trade) ? SupplierTrade::getTradeById($model->trade)->trade_name : '';
        //     },
        //     'filter' => SupplierTrade::getTrade(),
        // ],
        // [
        //     'attribute' => 'total_fund',
        //     'value' => function($model){
        //         $fund = $model->getTotalFund($model->id);
        //         return $fund ? $fund->trade_fund : '';
        //     }
        // ],
          [
              'attribute' => 'department',
              'value' => function ($model) {
                return Department::getDepartmentById($model->department) ? Department::getDepartmentById($model->department)->department_name : NULL;
              },
              'filter' => $department,
          ],
          'business_contact',
        //'business_email',
        //'business_license',
        //'tax_registration_certificate',
        //'orcc',
        //'service_authorization_letter',
        //'certified_assets',
        //'effective_credentials',
        //'opening_bank',
        //'bank_no',
        //'account_name',
        //'account_no',
        //'registration_certificate',
        //'manufacturing_licence',
        //'business_certificate',
        //'credibility_certificate',
        //'headcount',
        //'address',
        //'telephone',
        //'mobile',
        //'fax',
        //'email:email',
        //'contact',
        //'url:url',
        //'black_box',
        //'white_box',
        //'remarks:ntext',
        //'update_date',
        //'operator',
        // [
        //     'attribute' => 'created_at',
        //     'value' => function($model){
        //         return date('Y-m-d H:i:s',$model->created_at);
        //     }
        // ],
        // [
        //     'attribute' => 'updated_at',
        //     'value' => function($model){
        //         return date('Y-m-d H:i:s',$model->updated_at);
        //     }
        // ],
          [
            //'label'=>  (Helper::checkRoute('supplier-detail/create') || Helper::checkRoute('history/index')) ? '更多操作' : '',
              'label' => (Helper::checkRoute('supplier-detail/create')) ? '更多操作' : '',
              'format' => 'raw',
              'value' => function ($model) {
                $operator_1 = '';
                $operator_2 = '';
                if (Helper::checkRoute('supplier-detail/create')) {
                  $url_1 = Url::to(['supplier-detail/create', 'sid' => $model->id]);
                  $operator_1 = Html::a('建立合作关系', $url_1, ['title' => '建立合作关系']);

                }

                // if (Helper::checkRoute('history/index')) {
                //     $url_2 = Url::to(['history/index','object_id'=>$model->id]);
                //     $operator_2 = Html::a('历史记录', $url_2, ['title' => '历史记录']);
                // }
                return $operator_1 . ' ' . $operator_2;
              }
          ],
      ],
  ]); ?>
  <?php Pjax::end(); ?>
</div>
