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
use yii\web\Response;
use backend\models\SupplierCategory;
use backend\models\SupplierSearch;

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

        //与我方关系与部门相关
        $department = Yii::$app->user->identity->department;
        $request['SupplierDetailSearch'] = Yii::$app->request->queryParams;
        $request['SupplierDetailSearch']['one_level_department'] = $department;
        $dataProvider = $searchModel->search($request);

        $sid = Yii::$app->request->get('sid');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sid' => $sid,
        ]);
    }

    /**
     * Lists all SupplierDetail models.
     * @return mixed
     */
    public function actionAdminIndex()
    {
        $searchModel = new SupplierSearch();
        $request = Yii::$app->request->queryParams;
        $department = Yii::$app->user->identity->department;
        //排除这几个一级部门
        $filter_department = ['大数据信息中心','总裁办','品管部','供应链部'];
        if (!in_array($department,$filter_department)) {
            $request['SupplierSearch']['public_flag'] = 'y';
            $request['SupplierSearch']['department'] = $department;
        } else {
            $request['SupplierSearch']['department'] = $department;
        }
        $dataProvider = $searchModel->search($request);

        return $this->render('admin-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $model = $this->findModel($id);
        if (!$model) {
            throw new NotFoundHttpException("您访问的页面不存在");
        }
        $supplierModel = Supplier::getSupplierById($model->sid);
        $fundModel = new SupplierFunds;
        $where['sid'] = $model->sid;
        $detailObjList = SupplierDetail::find()->where($where)->all();
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
                // $detail['cate_id1'] = implode(',', SupplierCategory::getCategoryNameByParams($detail->cate_id1));
                // $detail['cate_id2'] = implode(',', SupplierCategory::getCategoryNameByParams($detail->cate_id2));
                // $detail['cate_id3'] = implode(',', SupplierCategory::getCategoryNameByParams($detail->cate_id3));

        }            
        return $this->render('view', [
            'model' => $model,
            'supplier' => $supplierModel,
            'detail_obj_list' => $detailObjList,
        ]);
    }

    /**
     * Displays a single SupplierDetail model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAdminView($id)
    {
        $model = $this->findModel($id);
        if (!$model) {
            throw new NotFoundHttpException("您访问的页面不存在");
        }
        $supplierModel = Supplier::getSupplierById($model->sid);

        $fundModel = new SupplierFunds;
        $where['sid'] = $model->sid;
        $detailObjList = SupplierDetail::find()->where($where)->all();
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
                // $detail['cate_id1'] = implode(',', SupplierCategory::getCategoryNameByParams($detail->cate_id1));
                // $detail['cate_id2'] = implode(',', SupplierCategory::getCategoryNameByParams($detail->cate_id2));
                // $detail['cate_id3'] = implode(',', SupplierCategory::getCategoryNameByParams($detail->cate_id3));

        }    
        return $this->render('admin-view', [
            'model' => $model,
            'supplier' => $supplierModel,
            'detail_obj_list' => $detailObjList,
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
            return $this->redirect(['index']);
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
                // $detail['cate_id1'] = implode(',', SupplierCategory::getCategoryNameByParams($detail->cate_id1));
                // $detail['cate_id2'] = implode(',', SupplierCategory::getCategoryNameByParams($detail->cate_id2));
                // $detail['cate_id3'] = implode(',', SupplierCategory::getCategoryNameByParams($detail->cate_id3));

        }
        //前三年
        $model->fund_year1 = date('Y') - 3;
        $model->fund_year2 = date('Y') - 2;
        $model->fund_year3 = date('Y') - 1;
        $model->one_level_department = Yii::$app->user->identity->department;
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'edit';
        $sid = $model->sid;
        $original = $model->getByID($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            AdminLog::saveLog('supplierdetail', 'update', $model->getByID($model->primaryKey), $model->primaryKey,$original);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $supplierModel = new Supplier;
        $fundModel = new SupplierFunds;
        $levelModel = new SupplierLevel;
        $supplierObj = $supplierModel->find($sid)->one();
        $level = $levelModel::getLevelByParams();//供应商等级
        $map['detail_id'] = $id;
        $funds = $fundModel->find()->where($map)->all();
        if ($funds) {
            foreach ($funds as $k => $v) {
                $id = $k + 1;
                $model->{"coop_fund$id"} = $v->coop_fund;
                $model->{"trade_fund$id"} = $v->trade_fund;
            }
        }
        $model->cate_id1 = implode(',', SupplierCategory::getCategoryNameByParams($model->cate_id1));
        $model->cate_id2 = implode(',', SupplierCategory::getCategoryNameByParams($model->cate_id2));
        $model->cate_id3 = implode(',', SupplierCategory::getCategoryNameByParams($model->cate_id3));        
        //前三年
        $model->fund_year1 = date('Y') - 3;
        $model->fund_year2 = date('Y') - 2;
        $model->fund_year3 = date('Y') - 1;

        return $this->render('update', [
            'model' => $model,
            'name' => $supplierObj->name,
            'sid' => $sid,
            'level' => $level,
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

    /**
     * 根据id获取分类键值对
     * @return [type] [description]
     */
    public function actionGetAllCate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $cate_id = Yii::$app->request->get('cate_id','');
        //获取对应的大类
        $cate_id1 = Yii::$app->request->get('cate_id1','');
        //获取对应的子类
        $cate_id2 = Yii::$app->request->get('cate_id2','');
        $where = [];
        if ($cate_id) {
            $where['pid'] = 0;
            $where['status'] = 1;
        }
        //获取对应总类的大类
        if ($cate_id1) {
            $cate_id1 = explode('-', $cate_id1);
            $where['pid'] = $cate_id1;
            $where['level'] = 2;
            $where['status'] = 1;
        }
        if ($cate_id2) {
            $cate_id2 = explode('-',$cate_id2);
            $where['pid'] = $cate_id2;
            $where['level'] = 3;
            $where['status'] = 1;
        }
        if (empty($where)) {
            $category = '';
        }else{
            $categoryModel = new SupplierCategory;
            $category = $categoryModel::find()->select('id,category_name')->where($where)->asArray()->all();
            //return $category;
        }
        $out = ['results' => $category];
        return $out;
    }

}
