<?php

namespace backend\controllers;

use Yii;
use backend\models\SupplierLevel;
use backend\models\SupplierLevelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\AdminLog;

/**
 * SupplierLevelController implements the CRUD actions for SupplierLevel model.
 */
class SupplierLevelController extends Controller
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
     * Lists all SupplierLevel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SupplierLevelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SupplierLevel model.
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
     * Creates a new SupplierLevel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SupplierLevel();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            AdminLog::saveLog('supplierlevel', 'create', $model->getByID($model->primaryKey), $model->primaryKey);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $status = [0=>'无效',1=>'有效'];
        return $this->render('create', [
            'model' => $model,
            'status' => $status,
        ]);
    }

    /**
     * Updates an existing SupplierLevel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $original = $model->getByID($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            AdminLog::saveLog('supplierlevel', 'update', $model->getByID($model->primaryKey), $model->primaryKey,$original);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $status = [0=>'无效',1=>'有效'];

        return $this->render('update', [
            'model' => $model,
            'status' => $status,
        ]);
    }

    /**
     * Deletes an existing SupplierLevel model.
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
     * Finds the SupplierLevel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SupplierLevel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SupplierLevel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
