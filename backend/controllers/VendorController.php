<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Vendor;
use yii\data\ActiveDataProvider;
use backend\models\UploadForm;
use yii\web\UploadedFile;

class VendorController extends Controller
{
    /**
     * 供应商列表
     * @return [type] [description]
     */
    public function actionIndex()
    {
        $model = new Vendor();
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
        $model = new Vendor();
        $model->load(Yii::$app->getRequest()->post());
        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                var_dump('文件上传成功');
                die;
                // 文件上传成功
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    public function actionTest()
    {
        var_dump(Yii::$app->user->identity);
        die;
    }

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                // 文件上传成功
                return;
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
}


?>