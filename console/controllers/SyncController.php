<?php

namespace console\controllers;
use yii;
use yii\console\Controller;
use console\models\Supplier;
use console\models\SupplierDetail;

class SyncController extends Controller {

  public function actionIndex()
  {
    //$sql = "SELECT * FROM supplier WHERE source='add' and status='10'";
    $sql = "SELECT * FROM supplier WHERE status='10'";
    $supplier = Yii::$app->db->createCommand($sql)->queryAll();
    foreach ($supplier as $v) {
      $detail = SupplierDetail::getBySid($v['id']);
      if ($detail && ($detail['one_level_department'] == $v['department'])) {
        $supplierModel = Supplier::getByID($v['id']);
        $supplierModel->scenario = 'sync';
        if ($detail['cate_id1']) {
          $supplierModel->cate_id1 = $detail['cate_id1'];
        }
        if ($detail['cate_id2']) {
          $supplierModel->cate_id2 = $detail['cate_id2'];
        }
        if ($detail['cate_id3']) {
          $supplierModel->cate_id3 = $detail['cate_id3'];
        }
        if ($detail['level']) {
          $supplierModel->level = $detail['level'];
        }
        $supplierModel->save();
      }
    }
  }
}