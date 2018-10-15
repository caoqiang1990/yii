<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Category;

class CategoryController extends Controller
{
  public function actionCreate()
    {
        $model = new Category();
        $list = $model->getOptions();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'list' => $list
            ]);
        }
    }
}




?>