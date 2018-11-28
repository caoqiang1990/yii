<?php

namespace backend\controllers;

use Yii;
use backend\models\SupplierCategory;
use backend\models\SupplierCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SupplierCategoryController implements the CRUD actions for SupplierCategory model.
 */
class SupplierCategoryController extends Controller
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
     * Lists all SupplierCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SupplierCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SupplierCategory model.
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
     * Creates a new SupplierCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SupplierCategory();
        $post = Yii::$app->request->post();
        if (isset($post['SupplierCategory']['pid'])) {
            $info = $model::getCategoryById($post['SupplierCategory']['pid']);
            $post['SupplierCategory']['level'] = $info->level + 1;
        }
        if ($model->load($post) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $status = [0 => '无效',1 => '有效'];
        $level = $model->getOptions();

        return $this->render('create', [
            'model' => $model,
            'level' => $level,
            'status' => $status,
        ]);
    }

    /**
     * Updates an existing SupplierCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if (isset($post['SupplierCategory']['pid'])) {
            $info = $model::getCategoryById($post['SupplierCategory']['pid']);
            if ($post['SupplierCategory']['pid'] == 0) {
                $post['SupplierCategory']['level'] = 1;
            }else{
                $post['SupplierCategory']['level'] = $info->level + 1;
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $status = [0 => '无效',1 => '有效'];
        $level = $model->getOptions();
        
        return $this->render('update', [
            'model' => $model,
            'level' => $level,
            'status' => $status,
        ]);
    }

    /**
     * Deletes an existing SupplierCategory model.
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
     * Finds the SupplierCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SupplierCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SupplierCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
