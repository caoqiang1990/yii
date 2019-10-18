<?php

namespace backend\controllers;

use Yii;
use backend\models\Document;
use backend\models\DocumentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\web\Response;

/**
 * DocumentController implements the CRUD actions for Document model.
 */
class DocumentController extends Controller
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
   * Lists all Document models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new DocumentSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Document model.
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
   * Creates a new Document model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new Document();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['code' => 'success', 'message' => '添加成功'];
    }

    $cate = [
        '集团文件',
        '品牌媒介',
        '综采&工程',
        '产品实现',
        '装修监理',
        '系统支持'
    ];

    return $this->render('create', [
        'model' => $model,
        'cate' => $cate,
    ]);
  }

  /**
   * Updates an existing Document model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['code' => 'success', 'message' => '修改成功'];
    }

    return $this->render('update', [
        'model' => $model,
    ]);
  }

  /**
   * Deletes an existing Document model.
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
   * Finds the Document model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Document the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Document::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException(Yii::t('document', 'The requested page does not exist.'));
  }


  /**
   * 上传附件
   * @return [type] [description]
   */
  public function actionUploadAttachment()
  {

    $field = Yii::$app->request->post('field');
    $documentModel = new Document();

    if (Yii::$app->request->isPost) {
      if (empty($_FILES)) {
        echo Json::encode([
            'filepath' => '',
            'error' => '请选择要上传文件',
        ]);
      } else {
        switch ($field) {
          case 'doc_id':
            $documentModel->doc = UploadedFile::getInstance($documentModel, 'doc_id');
            $field = 'doc';
            break;
          default:
            break;
        }
        if ($uploadInfo = $documentModel->upload($field)) {
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
      }

    } else {
      echo Json::encode([
          'filepath' => '',
          'error' => '请选择要上传文件',
      ]);
    }
  }
}
