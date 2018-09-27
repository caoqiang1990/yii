<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Vendor;
use yii\data\ActiveDataProvider;

class VendorController extends Controller
{
  public function actionIndex()
  {
    $model=new Vendor();
    // $dataProvider = new ActiveDataProvider([
    //     'query' => Vendor::find()->orderBy('id'),//此处添加where条件时：'query'=>User::find()->where(['username'=>'lizi']);
    // ]);
    $dataProvider = $model->search(Yii::$app->request->queryParams);

    return $this->render('index', [
        'model' => $model,
        'dataProvider' => $dataProvider,
    ]);    
  }



}



?>