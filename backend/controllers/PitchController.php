<?php

namespace backend\controllers;

use Yii;
use backend\models\Pitch;
use backend\models\PitchSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Json;
use backend\models\Supplier;
use backend\models\Attachment;


/**
 * PitchController implements the CRUD actions for Pitch model.
 */
class PitchController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Pitch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PitchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pitch model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Pitch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pitch();
        $model->scenario = 'add';
        $model->department = Yii::$app->user->identity->department;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        //供应商集合
        $suppliers = Supplier::getSuppliers();
        return $this->render('create', [
            'model' => $model,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Updates an existing Pitch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'edit';
        $model->sids = explode(',', $model->sids);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        //供应商集合
        $suppliers = Supplier::getSuppliers();
        $attachmentModel = new Attachment();
        $image = $attachmentModel->getImageByID($model->record);
        $model->record_url = $image ? $image->url : '';        
        return $this->render('update', [
            'model' => $model,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Deletes an existing Pitch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pitch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pitch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pitch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('pitch', 'The requested page does not exist.'));
    }


    /**
     * 上传附件
     * @return [type] [description]
     */
    public function actionUploadAttachment()
    {
        $field = Yii::$app->request->post('field');
        $pitchModel = new Pitch();
        $pitchModel->scenario = 'upload';

        if (Yii::$app->request->isPost) {
            switch ($field) {
                case 'record_id':
                    $pitchModel->record = UploadedFile::getInstance($pitchModel, 'record_id');
                    $field = 'record';
                    break;
                default:
                    # code...
                    break;
            }
            if ($uploadInfo = $pitchModel->upload($field)) {
                echo Json::encode([
                    'filepath' => $uploadInfo['filepath'],
                    'imageid' => $uploadInfo['imageid'],
                    'error' => '', //上传的error字段，如果没有错误就返回空字符串，否则返回错误信息，客户端会自动判定该字段来认定是否有错
                ]);
            } else {
                echo Json::encode([
                    'filepath' => '',
                    'imageid' => '',
                    'error' => '文件上传失败',
                ]);
            }
        } else {
            echo Json::encode([
                'filepath' => '',
                'error' => '文件上传失败',
            ]);
        }

    }

}
