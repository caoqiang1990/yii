<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\AdminLog;
use yii\data\ActiveDataProvider;

class AdminLogController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AdminLog::find(),
            'sort' => [
                'defaultOrder' => [
                    'addtime' => SORT_DESC
                ]
            ],
        ]);
        return $this->render('index',[
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView($id){
       return $this->render('view',[
           'model'=>AdminLog::findOne($id),
       ]);
    }

}