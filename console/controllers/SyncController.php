<?php

namespace console\controllers;
use yii;
use yii\console\Controller;
use console\models\Supplier;
use console\models\SupplierDetail;

class SyncController extends Controller {

  public function actionIndex()
  {
    $sql = "SELECT * FROM supplier WHERE source='add'";
    $supplier = Yii::$app->db->createCommand($sql)->queryAll();
    foreach ($supplier as $v) {
      $detail = SupplierDetail::getBySid($v['id']);
      if ($detail) {
        $supplierModel = Supplier::getByID($v['id']);
        $supplierModel->scenario = 'sync';
        $supplierModel->cate_id1 = $detail->cate_id1;
        $supplierModel->cate_id2 = $detail->cate_id2;
        $supplierModel->cate_id3 = $detail->cate_id3;
        $supplierModel->save();
      }
    }
  }
}