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
use backend\models\Department;

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
        //获取用户的对应的部门id
        $department = Yii::$app->user->identity->department;
        $department_info = Department::getDepartmentById($department);
        if (!$department_info) {
            throw new NotFoundHttpException("此用户不包含管理部门");
        }
        $sids = SupplierDetail::getSupplierByDepartment($department);
        $where['department'] = $department;
        $supplier_ids = 'none';
        $admin_ids = Supplier::find()->select('id')->distinct()->where($where)->asArray()->all();
        if ($sids && $admin_ids) {
            $ids = array_column($admin_ids,'id');
            $supplier_ids = array_keys(array_flip($sids) + array_flip($ids));
        } else {
            if ($sids) {
                $supplier_ids = $sids;
            }
            if ($admin_ids) {
                $supplier_ids = array_column($admin_ids,'id');
            }
        }

        $request['SupplierSearch']['id'] = $supplier_ids;
        $request['SupplierSearch']['supplier_status'] = '10';
        $dataProvider = $searchModel->search($request);
        if (isset($request['SupplierSearch']['cate_id1'])) {
            $cate2 = SupplierCategory::getCategoryByParams('id,category_name',2,$request['SupplierSearch']['cate_id1']);
        } else {
            $cate2 = SupplierCategory::getCategoryByParams('id,category_name',2);
        }
        if (isset($request['SupplierSearch']['cate_id2'])) {
            $cate3 = SupplierCategory::getCategoryByParams('id,category_name',3,$request['SupplierSearch']['cate_id2']);
        } else {
            $cate3 = SupplierCategory::getCategoryByParams('id,category_name',3);
        }
        return $this->render('admin-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'department_info' => $department_info,
            'cate2' => $cate2,
            'cate3' => $cate3,
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
        // $supplierModel = Supplier::getSupplierById($model->sid);
        // $fundModel = new SupplierFunds;
        // $where['sid'] = $model->sid;
        // $detailObjList = SupplierDetail::find()->where($where)->all();
        // foreach ($detailObjList as $id => &$detail) {
        //         $map['detail_id'] = $detail->id;
        //         $funds = $fundModel->find()->where($map)->all();
        //         if ($funds) {
        //             foreach ($funds as $k => $v) {
        //                 $id = $k + 1;
        //                 $detail->{"coop_fund$id"} = $v->coop_fund;
        //                 $detail->{"trade_fund$id"} = $v->trade_fund;
        //             }
        //         }
        //         // $detail['cate_id1'] = implode(',', SupplierCategory::getCategoryNameByParams($detail->cate_id1));
        //         // $detail['cate_id2'] = implode(',', SupplierCategory::getCategoryNameByParams($detail->cate_id2));
        //         // $detail['cate_id3'] = implode(',', SupplierCategory::getCategoryNameByParams($detail->cate_id3));

        // }            
        return $this->render('view', [
            'model' => $model,
            //'supplier' => $supplierModel,
            //'detail_obj_list' => $detailObjList,
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
                $funds = $fundModel->find()->where($map)
                ->andfilterwhere(['in','year',[date('Y') - 3,date('Y') - 2,date('Y') - 1]])
                ->orderBy('year asc')->all();
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
        $supplierModel = new Supplier;
        $fundModel = new SupplierFunds;
        $levelModel = new SupplierLevel;        
        $supplierObj = $this->findSupplierModel($sid);
        $model->scenario = 'add';
        $post = Yii::$app->request->post();
        $funds = array();
        $department = Yii::$app->user->identity->department;
        if (Yii::$app->request->isPost) {
            $post['SupplierDetail']['one_level_department'] = $supplierObj->department;
            $post['SupplierDetail']['develop_department'] = $supplierObj->department;
        }
        if ($model->load($post) && $model->save()) {
            AdminLog::saveLog('supplierdetail', 'create', $model->getByID($model->primaryKey), $model->primaryKey);
            return $this->redirect(['/supplier/admin-index']);
        }

        $level = $levelModel::getLevelByParams();//供应商等级
        $where['sid'] = $sid;
        $detailObjList = $model->find()->where($where)->all();
        foreach ($detailObjList as $id => &$detail) {
                $map['detail_id'] = $detail->id;
                $funds = $fundModel->find()->where($map)
                ->andfilterwhere(['in','year',[date('Y') - 3,date('Y') - 2,date('Y') - 1]])
                ->orderBy('year asc')->all();
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
        //获取供应商对应的一级部门        
        $department_info = Department::getDepartmentById($supplierObj->department);
        $model->one_level_department = $department_info ? $department_info->department_name : '';
        //部门列表
        $one_level_department = Department::getDepartmentByParams('id,department_name',1);
        $second_level_department = Department::getDepartmentByParams('id,department_name',2);
        return $this->render('create', [
            'model' => $model,
            'name' => $supplierObj->name,
            'sid' => $sid,
            'detail_obj_list' => $detailObjList,
            'level' => $level,
            'second_level_department' => $second_level_department,
            'one_level_department' => $one_level_department
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
            return $this->redirect(['admin-index']);
        }

        $supplierModel = new Supplier;
        $fundModel = new SupplierFunds;
        $levelModel = new SupplierLevel;
        $supplierObj = $supplierModel->find($sid)->one();
        $level = $levelModel::getLevelByParams();//供应商等级
        $map['detail_id'] = $id;
        $funds = $fundModel->find()->where($map)
        ->andfilterwhere(['in','year',[date('Y') - 3,date('Y') - 2,date('Y') - 1]])
        ->orderBy('year asc')->all();
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

        if ($model->one_level_department) {
            $department = Department::getDepartmentById($model->one_level_department);
            $model->one_level_department = $department->department_name;
        }
        if ($model->second_level_department) {
            $department = Department::getDepartmentById($model->second_level_department);
            $model->second_level_department = $department->department_name;
        } 
        if ($model->develop_department) {
            $department = Department::getDepartmentById($model->develop_department);
            $model->develop_department = $department->department_name;
        }                       
        $one_level_department = Department::getDepartmentByParams('id,department_name',1);
        $second_level_department = Department::getDepartmentByParams('id,department_name',2);
        return $this->render('update', [
            'model' => $model,
            'name' => $supplierObj->name,
            'sid' => $sid,
            'level' => $level,
            'second_level_department' => $second_level_department,
            'one_level_department' => $one_level_department,
        ]);
    }

    public function actionAdminUpdate($id)
    {
        $model = Supplier::findOne($id);
        $where['sid'] = $id;
        $where['one_level_department'] = Yii::$app->user->identity->department;
        $supplier_detail = SupplierDetail::find()->where($where)->all();
        $fundModel = new SupplierFunds;
        if ($supplier_detail) {
            foreach($supplier_detail as &$detail) {
                $detail->supplier_name = $model->name; 
                $map['detail_id'] = $detail->id;
                $funds = $fundModel->find()->where($map)
                ->andfilterwhere(['in','year',[date('Y') - 3,date('Y') - 2,date('Y') - 1]])
                ->orderBy('year asc')->all();
                if ($funds) {
                    foreach ($funds as $k => $v) {
                        $id = $k + 1;
                        $detail->{"coop_fund$id"} = $v->coop_fund;
                        $detail->{"trade_fund$id"} = $v->trade_fund;
                    }
                }
            } 
        }
        return $this->render('admin-update',[
                'model' => $model,
                'supplier_detail' => $supplier_detail,
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

    protected function findSupplierModel($id)
    {
        if (($model = Supplier::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }    

}
