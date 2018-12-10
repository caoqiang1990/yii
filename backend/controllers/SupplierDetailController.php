<?php

namespace backend\controllers;

use Yii;
use backend\models\SupplierDetail;
use backend\models\SupplierDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Supplier;
use backend\models\SupplierFunds;
use backend\models\SupplierLevel;
use common\models\AdminLog;

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
    public function actionCreate($sid='')
    {
        $model = new SupplierDetail;
        $model->scenario = 'add';
        $post = Yii::$app->request->post('SupplierDetail');
        $funds = array();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            AdminLog::saveLog('supplierdetail', 'create', $model->getByID($model->primaryKey), $model->primaryKey);
            if ($model->id) {
                for($i=1;$i<=3;$i++) {
                    $funds[$i-1]["sid"] = $post['sid'];
                    $funds[$i-1]["detail_id"] = $model->id;
                    $funds[$i-1]["coop_fund"] = $post["coop_fund{$i}"];
                    $funds[$i-1]["trade_fund"] = $post["trade_fund{$i}"];
                    $funds[$i-1]["year"] = $post["fund_year{$i}"];
                    $funds[$i-1]["created_at"] = time();
                    $funds[$i-1]["updated_at"] = time();
                }     
                Yii::$app->db->createCommand()->batchInsert('supplier_funds',['sid','detail_id','coop_fund','trade_fund','year','created_at','updated_at'],$funds)->execute();
            }
            return $this->redirect(['supplier/index']);
        }
        $supplierModel = new Supplier;
        $fundModel = new SupplierFunds;
        $levelModel = new SupplierLevel;
        $supplierObj = $supplierModel->find($sid)->one();
        $level = $levelModel::getLevelByParams();//供应商等级
        $where['sid'] = $sid;
        $detailObjList = $model->find()->where($where)->all();
        foreach ($detailObjList as $id => &$detail) {
                $map['detail_id'] = $detail->id;
                $funds = $fundModel->find()->where($map)->all();
                if ($funds) {
                    foreach ($funds as $k => $v) {
                        $id = $k + 1;
                        $detail->{"coop_fund$id"} = $v->coop_fund;
                        $detail->{"trade_fund$id"} = $v->trade_fund;
                    }
                }
    
        }
        //前三年
        $model->fund_year1 = date('Y') - 3;
        $model->fund_year2 = date('Y') - 2;
        $model->fund_year3 = date('Y') - 1;
        return $this->render('create', [
            'model' => $model,
            'name' => $supplierObj->name,
            'sid' => $sid,
            'detail_obj_list' => $detailObjList,
            'level' => $level,
        ]);
    }

    /**
     * Updates an existing SupplierDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$sid='')
    {
        $model = $this->findModel($id);
        $model->scenario = 'edit';

        $original = $model->getByID($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            AdminLog::saveLog('supplierdetail', 'update', $model->getByID($model->primaryKey), $model->primaryKey,$original);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $supplierModel = new Supplier;
        $nameObject = $supplierModel->getNameByID($model->sid);

        return $this->render('update', [
            'model' => $model,
            'name' => $nameObject->name,
            'sid' => $sid,
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
