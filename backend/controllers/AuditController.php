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
    $request['SupplierSearch']['status'] = 'wait';
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
      'auditing' => '待审核'
    ];    
    $model = $this->findModel($id);
    $model->scenario = 'audit';
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      $this->redirect(['index']);
    }

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
    $url = "http://gys.aimergroup.com:8090/?r=supplierform/update&id=".$id;
    return $this->render('qrcode',[
        'id' => $id,
        'url' => $url,
      ]);
  }


  public function actionCode($id)
  {
    $url = "http://gys.aimergroup.com:8090/?r=supplierform/update&id=".$id;
    $png = QrCode::png($url);    //调用二维码生成方法
    return $png;
  }
}




?>