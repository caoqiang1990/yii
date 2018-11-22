<?php

namespace backend\controllers;

use Yii;
use backend\models\SupplierDetail;
use backend\models\SupplierDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Supplier;

/**
 * SupplierDetailController implements the CRUD actions for SupplierDetail model.
 */
class SupplierDetailController extends Controller
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
     * Lists all SupplierDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SupplierDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $sid = Yii::$app->request->get('sid');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sid' => $sid,
        ]);
    }

    /**
     * Displays a single SupplierDetail model.
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
     * Creates a new SupplierDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SupplierDetail();
        $model->scenario = 'add';
        $post = Yii::$app->request->post('SupplierDetail');
        $funds = array();
        $sid = Yii::$app->request->get('sid');
        $supplierModel = new Supplier;
        $nameObject = $supplierModel->getNameByID($sid);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->id) {
                for($i=1;$i<=3;$i++) {
                    $funds[$i-1]["detail_id"] = $model->id;
                    $funds[$i-1]["coop_fund"] = $post["coop_fund{$i}"];
                    $funds[$i-1]["trade_fund"] = $post["trade_fund{$i}"];
                    $funds[$i-1]["created_at"] = time();
                    $funds[$i-1]["updated_at"] = time();
                }     
                Yii::$app->db->createCommand()->batchInsert('supplier_funds',['detail_id','coop_fund','trade_fund','created_at','updated_at'],$funds)->execute();
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'name' => $nameObject->name,
            'sid' => $sid,
        ]);
    }

    /**
     * Updates an existing SupplierDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'edit';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $supplierModel = new Supplier;
        $nameObject = $supplierModel->getNameByID($model->sid);

        return $this->render('update', [
            'model' => $model,
            'name' => $nameObject->name,
        ]);
    }

    /**
     * Deletes an existing SupplierDetail model.
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
     * Finds the SupplierDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SupplierDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SupplierDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
