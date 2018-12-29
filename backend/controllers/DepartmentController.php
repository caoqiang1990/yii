<?php

namespace backend\controllers;

use Yii;
use backend\models\Department;
use backend\models\DepartmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\AdminLog;

/**
 * DepartmentController implements the CRUD actions for Department model.
 */
class DepartmentController extends Controller
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
     * Lists all Department models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DepartmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Department model.
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
     * Creates a new Department model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Department();
        $post = Yii::$app->request->post();
        if (isset($post['Department`']['pid'])) {
            if ($post['Department`']['pid'] == 0) {
                $post['Department`']['level'] = 1;
            }else{
                $info = $model::getDepartmentById($post['Department`']['pid']);
                $post['Department`']['level'] = $info->level + 1;
            }
        }
        if ($model->load($post) && $model->save()) {
            AdminLog::saveLog('Department`', 'create', $model->getByID($model->primaryKey), $model->primaryKey);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $status = [0 => '无效',1 => '有效'];
        $level = $model->getOptions();

        return $this->render('create', [
            'model' => $model,
            'level' => $level,
            'status' => $status
        ]);
    }

    /**
     * Updates an existing Department model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if (isset($post['Department']['pid'])) {
            if ($post['Department']['pid'] == 0) {
                $post['Department']['level'] = 1;
            }else{
                $info = $model::getDepartmentById($post['Department']['pid']);
                $post['Department']['level'] = $info->level + 1;
            }
        }

        $original = $model->getByID($id);
        if ($model->load($post) && $model->save()) {
            AdminLog::saveLog('Department', 'update', $model->getByID($model->primaryKey), $model->primaryKey,$original);
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
     * Deletes an existing Department model.
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
     * Finds the Department model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Department the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Department::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('department', 'The requested page does not exist.'));
    }
}
