<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Vendor;
use yii\data\ActiveDataProvider;

class VendorController extends Controller
{
  /**
   * 供应商列表
   * @return [type] [description]
   */
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

  /**
   * 供应商添加
   * @return [type] [description]
   */
  public function actionCreate()
  {
    return $this->render('create',[]);
  }



  public function actionTest()
  {
    var_dump(Yii::$app->user->identity);die;
  }


}



?>