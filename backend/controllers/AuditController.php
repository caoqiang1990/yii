<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Supplier;
use backend\models\SupplierSearch;
use yii\web\NotFoundHttpException;
use dosamigos\qrcode\QrCode;


class AuditController extends Controller
{

  public function actionIndex()
  {
    $searchModel = new SupplierSearch();
    $request = Yii::$app->request->queryParams;
    $department = Yii::$app->user->identity->department;
    $request['SupplierSearch']['department'] = $department;
    if (isset($request['SupplierSearch']['status']) && $request['SupplierSearch']['status'])  {
      $request['SupplierSearch']['supplier_status'] = $request['SupplierSearch']['status'];
    } else {
      $request['SupplierSearch']['supplier_status'] = ['wait','auditing'];
    }
    $dataProvider = $searchModel->search($request);

    $status = [
      'wait' => '待完善',
      'auditing' => '待审核'
    ];

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'status' => $status,
    ]);
  }


  public function actionView($id)
  {
      return $this->render('view', [
          'model' => Supplier::findOne($id),
      ]);
  }  


  public function actionAudit($id)
  {
    $status = [
      '10' => '审核通过',
      'wait' => '待完善',
      'auditing' => '待审核',
      '20' => '审核不通过',
    ];    
    $model = $this->findModel($id);
    $model->scenario = 'audit';
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      $this->redirect(['index']);
    }
    $model->status = '';
    return $this->render('audit',[
        'model' => $model,
        'status' => $status,
      ]);
  }

  protected function findModel($id)
  {
      if (($model = Supplier::findOne($id)) !== null) {
          return $model;
      }

      throw new NotFoundHttpException('The requested page does not exist.');
  }

  public function actionQrcode($id)
  {
    $model = $this->findModel($id);
    $url = "http://gys.aimergroup.com:8090/?r=supplierform/update&id=".enCrypt($id);
    return $this->render('qrcode',[
        'id' => $id,
        'url' => $url,
      ]);
  }


  public function actionCode($id)
  {
    $url = "http://gys.aimergroup.com:8090/?r=supplierform/update&id=".enCrypt($id);
    $png = QrCode::png($url);    //调用二维码生成方法
    return $png;
  }
}




?>