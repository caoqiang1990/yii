<?php
declare(strict_types=1);

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use backend\models\Attachment;
use backend\models\Supplier;
use backend\models\SupplierCategory;
use backend\models\SupplierLevel;
use backend\models\SupplierSearch;
use backend\models\SupplierTrade;
use backend\models\SupplierType;
use backend\models\UploadForm;
use common\models\AdminLog;
use moonland\phpexcel\Excel;
use backend\models\SupplierNature;
use yii\web\BadRequestHttpException;
use backend\models\SupplierDetail;
use mdm\admin\components\Configs;
use backend\models\AdminAdd;
use backend\models\Department;
use backend\models\SupplierFunds;
use backend\models\DepartmentAssignment;

/**
 * SuppliersController implements the CRUD actions for Suppliers model.
 */
class SupplierController extends Controller
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
   * Lists all Suppliers models.
   * @return mixed
   */
  public function actionIndex(): string
  {
    $searchModel = new SupplierSearch();
    $request = Yii::$app->request->queryParams;
    $department = Yii::$app->user->identity->department;
    //排除这几个一级部门
    $filter_department = ['大数据信息中心', '总裁办', '品管部', '供应链部'];
    if (!in_array($department, $filter_department)) {
      $request['SupplierSearch']['public_flag'] = 'y';
    }
    $dataProvider = $searchModel->search($request);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Lists all Suppliers models.
   * @return mixed
   */
  public function actionAdminIndex(): string
  {
    $searchModel = new SupplierSearch();
    $request = Yii::$app->request->queryParams;
    $department = Yii::$app->user->identity->department;
    $is_administrator = Yii::$app->user->identity->is_administrator;
    $department_info = Department::getDepartmentById($department);
    if (!$department_info) {
      throw new NotFoundHttpException("此用户不包含管理部门");
    }
    if ($is_administrator == 2) {
      $request['SupplierSearch']['public_flag'] = 'y';
    }
    $request['SupplierSearch']['supplier_status'] = '10';
    $dataProvider = $searchModel->search($request);
    if (isset($request['SupplierSearch']['cate_id1'])) {
      $cate2 = SupplierCategory::getCategoryByParams('id,category_name', 2, $request['SupplierSearch']['cate_id1']);
    } else {
      $cate2 = SupplierCategory::getCategoryByParams('id,category_name', 2);
    }
    if (isset($request['SupplierSearch']['cate_id2'])) {
      $cate3 = SupplierCategory::getCategoryByParams('id,category_name', 3, $request['SupplierSearch']['cate_id2']);
    } else {
      $cate3 = SupplierCategory::getCategoryByParams('id,category_name', 3);
    }
    $departmentModel = new Department();
    $department = $departmentModel::getDepartment();
    return $this->render('admin-index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'cate2' => $cate2,
        'cate3' => $cate3,
        'department' => $department,
    ]);
  }

  /**
   * Lists all Suppliers models.
   * @return mixed
   */
  public function actionDepartmentIndex(): string
  {
    $searchModel = new SupplierSearch();
    $request = Yii::$app->request->queryParams;
    //获取用户的对应的部门id
    $department = Yii::$app->user->identity->department;
    $user_id = Yii::$app->user->identity->id;
    $department_ids = DepartmentAssignment::getByUserId($user_id);
    $department_info = Department::getDepartmentById($department);
    if (!$department_info) {
      throw new NotFoundHttpException("此用户不包含管理部门");
    }
    $sids = SupplierDetail::getSupplierByDepartment($department_ids);
    //$where['department'] = $department;
    $where = ['in', 'department', $department_ids];
    $supplier_ids = 'none';
    $admin_ids = Supplier::find()->select('id')->distinct()->where($where)->asArray()->all();
    if ($sids && $admin_ids) {
      $ids = array_column($admin_ids, 'id');
      $supplier_ids = array_keys(array_flip($sids) + array_flip($ids));
    } else {
      if ($sids) {
        $supplier_ids = $sids;
      }
      if ($admin_ids) {
        $supplier_ids = array_column($admin_ids, 'id');
      }
    }

    $request['SupplierSearch']['id'] = $supplier_ids;
    $request['SupplierSearch']['supplier_status'] = '10';
    $dataProvider = $searchModel->search($request);
    if (isset($request['SupplierSearch']['cate_id1'])) {
      $cate2 = SupplierCategory::getCategoryByParams('id,category_name', 2, $request['SupplierSearch']['cate_id1']);
    } else {
      $cate2 = SupplierCategory::getCategoryByParams('id,category_name', 2);
    }
    if (isset($request['SupplierSearch']['cate_id2'])) {
      $cate3 = SupplierCategory::getCategoryByParams('id,category_name', 3, $request['SupplierSearch']['cate_id2']);
    } else {
      $cate3 = SupplierCategory::getCategoryByParams('id,category_name', 3);
    }
    //var_dump($ids);die;
    return $this->render('department-index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'department_info' => $department_info,
        'cate2' => $cate2,
        'cate3' => $cate3,
    ]);
  }

  /**
   * Displays a single Suppliers model.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDepartmentView($id): string
  {
    $where['sid'] = $id;
    $supplier_detail = SupplierDetail::find()->where($where)->all();
    $fundModel = new SupplierFunds;
    foreach ($supplier_detail as &$detail) {
      $map['detail_id'] = $detail->id;
      $funds = $fundModel->find()->where($map)
          ->andfilterwhere(['in', 'year', [date('Y') - 3, date('Y') - 2, date('Y') - 1]])
          ->orderBy('year asc')->all();
      if ($funds) {
        foreach ($funds as $k => $v) {
          $key = $k + 1;
          $detail->{"coop_fund$key"} = $v->coop_fund ? $v->coop_fund : NULL;
          $detail->{"trade_fund$key"} = $v->trade_fund ? $v->trade_fund : NULL;
        }
      }
    }
    return $this->render('department-view', [
        'supplier' => $this->findModel($id),
        'supplier_detail' => $supplier_detail
    ]);
  }

  /**
   * Lists all Suppliers models.
   * @return mixed
   */
  public function actionAdmin(): string
  {
    $searchModel = new SupplierSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('admin', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Lists all Suppliers models.
   * @return mixed
   */
  public function actionAdminAdd(): string
  {
    $model = new AdminAdd();
    //if (Yii::$app->request->isAjax) {
    return $this->renderAjax('admin-add', [
        'model' => $model,
    ]);
    //}

    // return $this->renderPartial('admin-add', [
    //     'model' => $model,
    // ]);
  }

  /**
   * Lists all Suppliers models.
   * @return mixed
   */
  public function actionAdminSave(): array
  {
    Yii::$app->response->format = Response::FORMAT_JSON;
    $model = new AdminAdd();
    $model->scenario = 'add';
    if ($model->load(Yii::$app->request->post())) {
      if (!$model->name) {
        return ['code' => 'name', 'message' => '供应商全称不能为空!'];
      }
      if (!$model->enterprise_code) {
        return ['code' => 'code', 'message' => '企业代码不能为空!'];
      }
      $supplier = Supplier::getSupplierByName($model->name);
      if ($supplier) {
        $status = [
            '10' => '审核通过',
            'wait' => '待完善',
            'auditing' => '待审核',
            '20' => '审核不通过',
        ];
        //$level = SupplierLevel::getLevelById($supplier->level);
        $type =$status["{$supplier->status}"];
        return ['code' => 'exist', 'id' => $supplier->id, 'type' => $type];
      } else {
        $where['enterprise_code_desc'] = $model->enterprise_code;
        $supplier_o = Supplier::find()->where($where)->one();
        if ($supplier_o) {
          $level = SupplierLevel::getLevelById($supplier_o->level);
          $type = $level ? $level->level_name : '未合作';
          return ['code' => 'exist', 'id' => $supplier_o->id, 'type' => $type];
        } else {
          if ($new = $model->add()) {
            return ['code' => 'new', 'id' => $new->id, 'url' => 'http://gys.aimergroup.com:8090/supplierform/update?id=' . enCrypt($new->id)];
          } else {
            $error = $model->getErrors();
            return ['code' => 'error'];
          }
        }

      }
    } else {
      return ['code' => 'error'];
    }
  }

  /**
   * Displays a single Suppliers model.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id): string
  {
    return $this->render('view', [
        'model' => $this->findModel($id),
    ]);
  }

  /**
   * Displays a single Suppliers model.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionAdminView($id): string
  {
    $where['sid'] = $id;
    $supplier_detail = SupplierDetail::find()->where($where)->all();
    return $this->render('admin-view', [
        'model' => $this->findModel($id),
        'supplier_detail' => $supplier_detail,
    ]);
  }

  /**
   * Lists all Suppliers models.
   * @return mixed
   */
  public function actionBasic(): string
  {
    $searchModel = new SupplierSearch();
    $request = Yii::$app->request->queryParams;
    //获取用户的对应的部门id
    $department = Yii::$app->user->identity->department;
    $department_info = Department::getDepartmentById($department);
    if (!$department_info) {
      throw new NotFoundHttpException("此用户不包含管理部门");
    }
    $user_id = Yii::$app->user->identity->id;
    $department_ids = DepartmentAssignment::getByUserId($user_id);

    if (empty($department_ids)) {
      $request['SupplierSearch']['department'][] = $department;
    } else {
      $request['SupplierSearch']['department'] = $department_ids;
    }
    $request['SupplierSearch']['supplier_status'] = ['10', 'wait', 'auditing'];
    $dataProvider = $searchModel->search($request);
    if (isset($request['SupplierSearch']['cate_id1'])) {
      $cate2 = SupplierCategory::getCategoryByParams('id,category_name', 2, $request['SupplierSearch']['cate_id1']);
    } else {
      $cate2 = SupplierCategory::getCategoryByParams('id,category_name', 2);
    }
    if (isset($request['SupplierSearch']['cate_id2'])) {
      $cate3 = SupplierCategory::getCategoryByParams('id,category_name', 3, $request['SupplierSearch']['cate_id2']);
    } else {
      $cate3 = SupplierCategory::getCategoryByParams('id,category_name', 3);
    }
    //var_dump($ids);die;
    return $this->render('basic', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'department_info' => $department_info,
        'cate2' => $cate2,
        'cate3' => $cate3,
    ]);
  }

  /**
   * Creates a new Suppliers model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new Supplier;
    $model->scenario = 'add';
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      AdminLog::saveLog('supplier', 'create', $model->getByID($model->primaryKey), $model->primaryKey);
      return $this->redirect(['view', 'id' => $model->id]);
    }

    $levelModel = new SupplierLevel;
    $categoryModel = new SupplierCategory;
    $tradeModel = new SupplierTrade;
    $typeModel = new SupplierType;
    $natureModel = new SupplierNature;
    $level = $levelModel::getLevelByParams(); //供应商等级
    //$firm_nature = $categoryModel::getCategoryByParams();
    $firm_nature = $natureModel::getNatureByParams(); //企业性质
    $trade = $tradeModel::getTradeByParams(); //所属行业
    $type = $typeModel::getTypeByParams(); //业务类型
    return $this->render('create', [
        'model' => $model,
        'level' => $level,
        'firm_nature' => $firm_nature,
        'trade' => $trade,
        'type' => $type,
    ]);
  }

  /**
   * Updates an existing Suppliers model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);
    $model->scenario = 'edit';
    $post = Yii::$app->request->post();
    $original = $model->getByID($id);
    if ($model->load($post) && $model->save()) {
      AdminLog::saveLog('supplier', 'update', $model->getByID($model->primaryKey), $model->primaryKey, $original);
      //return $this->redirect(['view', 'id' => $model->id]);
      return $this->redirect(['basic']);

    }
    $attachmentModel = new Attachment();
    $image = $attachmentModel->getImageByID($model->enterprise_code);
    $model->enterprise_code_url = $image ? $image->url : '';
    $image = $attachmentModel->getImageByID($model->enterprise_license);
    $model->enterprise_license_url = $image ? $image->url : '';
    $image = $attachmentModel->getImageByID($model->enterprise_license_relate);
    $model->enterprise_license_relate_url = $image ? $image->url : '';
    $image = $attachmentModel->getImageByID($model->enterprise_certificate);
    $model->enterprise_certificate_url = $image ? $image->url : '';
    $image = $attachmentModel->getImageByID($model->enterprise_certificate_etc);
    $model->enterprise_certificate_etc_url = $image ? $image->url : '';
    $levelModel = new SupplierLevel;
    $categoryModel = new SupplierCategory;
    $tradeModel = new SupplierTrade;
    $typeModel = new SupplierType;
    $natureModel = new SupplierNature;
    $level = $levelModel::getLevelByParams();
    //$firm_nature = $categoryModel::getCategoryByParams();
    $firm_nature = $natureModel::getNatureByParams(); //企业性质
    $trade = $tradeModel::getTradeByParams();
    $type = $typeModel::getTypeByParams(); //业务类型
    return $this->render('update', [
        'model' => $model,
        'level' => $level,
        'firm_nature' => $firm_nature,
        'trade' => $trade,
        'type' => $type,
    ]);
  }

  /**
   * Deletes an existing Suppliers model.
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
   * Finds the Suppliers model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Suppliers the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Supplier::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
  }

  public function actionUploadxls(): string
  {
    $uploadForm = new UploadForm();
    return $this->render('uploadxls',
        [
            'model' => $uploadForm,
        ]
    );
  }

  public function actionUpload(): string
  {
    $uploadForm = new UploadForm();
    $uploadForm->scenario = 'file';
    if (Yii::$app->request->isPost) {
      $uploadForm->excelFile = UploadedFile::getInstance($uploadForm, 'excelFile');
      if ($filePath = $uploadForm->upload('excelFile')) {
        $result = $this->actionImport($filePath);
        if ($result === true) {
          echo Json::encode([
              'filepath' => $filePath,
              'error' => '', //上传的error字段，如果没有错误就返回空字符串，否则返回错误信息，客户端会自动判定该字段来认定是否有错
          ]);
        } else {
          echo Json::encode([
              'filepath' => '',
              'error' => $result,
          ]);
        }

      } else {
        $error = $uploadForm->getErrors();
        echo Json::encode([
            'filepath' => '',
            'error' => $error['excelFile'],
        ]);
      }
    } else {
      echo Json::encode([
          'filepath' => '',
          'error' => '文件上传失败',
      ]);
    }

  }

  /**
   * 供应商导入
   * @return [type] [description]
   */
  public function actionImport($filePath = '')
  {
    try {
      set_time_limit(1800);
      Yii::$app->response->format = Response::FORMAT_JSON;
      $data = Excel::import($filePath, [
          'setFirstRecordAsKeys' => true,
          'setIndexSheetByName' => true,
          'getOnlySheet' => 'Sheet1',
      ]);
      foreach ($data as $vo) {
        $supplierModel = '';
        $supplierModel = new Supplier;
        if (isset($vo['供应商全称'])) {
          if ($vo['供应商全称']) {
            $supplier_o = Supplier::getSupplierByName($vo['供应商全称']);
            if ($supplier_o) {
              $supplierDetailModel = new SupplierDetail();
              $supplierDetailModel->scenario = 'add';
              //供应商id
              $supplierDetailModel->sid = $supplier_o->id;
              //cate_id1
              $supplierDetailModel->cate_id1 = $supplier_o->cate_id1;
              //cate_id2
              $supplierDetailModel->cate_id2 = $supplier_o->cate_id2;
              //cate_id3
              $supplierDetailModel->cate_id3 = $supplier_o->cate_id3;
              //供应商等级
              if ($vo['供应商等级']) {
                $level = SupplierLevel::getLevelByName($vo['供应商等级']);
                if ($level) {
                  $supplierDetailModel->level = $level->id;
                } else {
                  //没有查到对应的供应商等级名称

                }
              } else {
                //没有填写对应的供应商等级名称

              }

              //一级部门（管理部门）
              if ($vo['一级部门（管理部门）']) {
                $department = Department::getDepartmentByName($vo['一级部门（管理部门）'], 1);
                $supplierDetailModel->one_level_department = $department->id;
              } else {
                $supplierDetailModel->one_level_department = $vo['一级部门（管理部门）'];
              }
              //二级部门
              if ($vo['二级部门']) {
                $department = Department::getDepartmentByName($vo['二级部门'], 2);
                $supplierDetailModel->second_level_department = $department->id;
              } else {
                $supplierDetailModel->second_level_department = $vo['二级部门'];
              }
              //开发部门（写二级部门）
              $supplierDetailModel->develop_department = $vo['开发部门（写二级部门）'];
              //合作起始时间（年月）
              //$supplierDetailModel->coop_date = $vo['合作起始时间（年月）'];
              if ($vo['合作起始时间（年月）'] && $vo['合作起始时间（年月）'] != '-') {
                $register_date = date_parse_from_format('Y/m/d', $vo['合作起始时间（年月）']);
                $supplierDetailModel->coop_date = "{$register_date['year']}-{$register_date['month']}-{$register_date['day']}";
              } else {
                $supplierDetailModel->coop_date = $vo['合作起始时间（年月）'];
              }
              //2015年合同金额（万元）
              $supplierDetailModel->coop_fund1 = $vo['2015年合同金额（万元）'];
              //2015年交易金额（万元）
              $supplierDetailModel->trade_fund1 = $vo['2015年交易金额（万元）'];
              //2016年合同金额（万元）
              $supplierDetailModel->coop_fund2 = $vo['2016年合同金额（万元）'];
              //2016年交易金额（万元）
              $supplierDetailModel->trade_fund2 = $vo['2016年交易金额（万元）'];
              //2017年合同金额（万元）
              $supplierDetailModel->coop_fund3 = $vo['2017年合同金额（万元）'];
              //2017年交易金额（万元）
              $supplierDetailModel->trade_fund3 = $vo['2017年交易金额（万元）'];
              //我方对接人
              $supplierDetailModel->name = $vo['我方对接人'];
              //我方对接人手机号
              $supplierDetailModel->mobile = $vo['我方对接人手机号'];
              //爱慕选择合作原因
              $supplierDetailModel->reason = $vo['爱慕选择合作原因'];

              $supplierDetailModel->isNewRecord = true;


              //保存
              $supplierDetailModel->save();
              continue;
            }
          } else {
            throw new BadRequestHttpException("编号为{$vo['编号']}的供应商全称不能为空!");
          }
        } else {
          throw new BadRequestHttpException("供应商全称不存在");
        }

        //供应商全称
        $supplierModel->name = $vo['供应商全称'];
        $supplierModel->scenario = 'add';
        //$supplierModel->department = $vo['一级部门（管理部门）'];
        if ($vo['一级部门（管理部门）']) {
          $department = Department::getDepartmentByName($vo['一级部门（管理部门）'], 1);
          $supplierModel->department = $department->id;
        } else {
          $supplierModel->department = $vo['一级部门（管理部门）'];
        }
        //供应商等级
        if ($vo['供应商等级']) {
          $level = SupplierLevel::getLevelByName($vo['供应商等级']);
          if ($level) {
            $supplierModel->level = $level->id;
          } else {
            //没有查到对应的供应商等级名称

          }
        } else {
          //没有填写对应的供应商等级名称

        }
        //供应商总类
        if (isset($vo['供应商分类一级'])) {
          if ($vo['供应商分类一级']) {
            $category = SupplierCategory::getCategoryByName($vo['供应商分类一级'], 1);
            if ($category) {
              $supplierModel->cate_id1 = $category->id;
            } else {

            }
          } else {
            throw new BadRequestHttpException("编号为{$vo['编号']}的供应商分类一级不能为空!");
          }
        } else {
          throw new BadRequestHttpException("供应商分类一级不存在");
        }

        //供应商大类
        if (isset($vo['供应商分类二级'])) {
          if ($vo['供应商分类二级']) {
            $category = SupplierCategory::getCategoryByName($vo['供应商分类二级'], 2);
            if ($category) {
              $supplierModel->cate_id2 = $category->id;
            } else {

            }
          } else {
            throw new BadRequestHttpException("编号为{$vo['编号']}的供应商分类二级不能为空!");
          }
        } else {
          throw new BadRequestHttpException("供应商分类二级不存在");
        }

        //供应商子类
        if (isset($vo['供应商分类三级'])) {
          if ($vo['供应商分类三级']) {
            $category = SupplierCategory::getCategoryByName($vo['供应商分类三级'], 3);
            if ($category) {
              $supplierModel->cate_id3 = $category->id;
            } else {

            }
          } else {
            throw new BadRequestHttpException("编号为{$vo['编号']}的供应商分类三级不能为空!");
          }
        } else {
          throw new BadRequestHttpException("供应商分类三级不存在");
        }

        //企业性质
        if (isset($vo['企业性质'])) {
          if ($vo['企业性质']) {
            $nature = SupplierNature::getNatureByName($vo['企业性质']);
            if ($nature) {
              $supplierModel->firm_nature = $nature->id;
            } else {
              //没有查到对应的企业性质名称

            }
          } else {
            //没有填写对应的企业性质名称
            throw new BadRequestHttpException("编号为{$vo['编号']}的企业性质不能为空!");
          }
        } else {
          throw new BadRequestHttpException("企业性质不存在");
        }

        //营业范围
        $supplierModel->business_scope = $vo['营业范围'];

        //与爱慕已合作内容
        if ($vo['与爱慕已合作内容']) {
          $supplierModel->coop_content = $vo['与爱慕已合作内容'];
        } else {
          //throw new BadRequestHttpException("编号为{$vo['编号']}的与爱慕已合作内容不能为空!");
        }

        //经营地址
        if ($vo['经营地址']) {
          $supplierModel->business_address = $vo['经营地址'];
        } else {
          //throw new BadRequestHttpException("编号为{$vo['编号']}的经营地址不能为空!");
        }

        //官网
        $supplierModel->url = $vo['官网'];

        //供应商业务类型
        if (isset($vo['供应商合作类型'])) {
          if ($vo['供应商合作类型']) {
            $type = SupplierType::getTypeByName($vo['供应商合作类型']);
            if ($type) {
              $supplierModel->business_type = $type->id;
            } else {
              //没有查到对应的供应商业务类型名称

            }
          } else {
            //没有填写对应的供应商业务类型名称
            throw new BadRequestHttpException("编号为{$vo['编号']}的供应商业务类型不能为空!");
          }
        } else {
          throw new BadRequestHttpException("供应商合作类型不存在");
        }

        //所属行业（参照2017年国民经济行业分类与代码）
        if ($vo['所属行业（参照2017年国民经济行业分类与代码）']) {
          $trade = SupplierTrade::getTradeByName($vo['所属行业（参照2017年国民经济行业分类与代码）']);
          if ($trade) {
            $supplierModel->trade = $trade->id;
          } else {
            //没有查到对应的供应商业务类型名称

          }
        } else {
          //没有填写对应的供应商业务类型名称
          //throw new BadRequestHttpException("编号为{$vo['编号']}的所属行业不能为空!");
        }

        //注册时间
        if ($vo['注册时间'] && $vo['注册时间'] != '-') {
          $register_date = date_parse_from_format('Y/m/d', $vo['注册时间']);
          $supplierModel->register_date = "{$register_date['year']}-{$register_date['month']}-{$register_date['day']}";
        } else {
          $supplierModel->register_date = $vo['注册时间'];
        }

        //注册资金（万元）
        if ((float)$vo['注册资金（万元）']) {
          $supplierModel->register_fund = $vo['注册资金（万元）'];
        } else {
          //throw new BadRequestHttpException("编号为{$vo['编号']}的注册资金（万元）不能为空!");
        }

        //雇员人数
        $supplierModel->headcount = $vo['雇员人数'];
        //工厂概况-概述
        $supplierModel->factory_summary = $vo['工厂概况-概述'];
        //工厂概况-土地面积（㎡）
        $supplierModel->factory_land_area = $vo['工厂概况-土地面积'];
        //工厂概况-厂房面积（㎡）
        $supplierModel->factory_work_area = $vo['工厂概况-厂房面积'];
        //主要服务客户1
        $supplierModel->business_customer1 = $vo['主要服务客户1'];
        //主要服务客户2
        $supplierModel->business_customer2 = $vo['主要服务客户2'];
        //主要服务客户3
        if (isset($vo['主要服务客户3'])) {
          $supplierModel->business_customer3 = $vo['主要服务客户3'];
        } else {
          //throw new BadRequestHttpException("主要服务客户3不存在");
        }
        //主要原材料来源1
        $supplierModel->material_name1 = $vo['主要原材料来源1'];
        //主要原材料来源2
        $supplierModel->material_name2 = $vo['主要原材料来源2'];
        //主要原材料来源3
        $supplierModel->material_name3 = $vo['主要原材料来源3'];
        //重要仪器设备情况1
        $supplierModel->instrument_device1 = $vo['重要仪器设备情况1'];
        //重要仪器设备情况2
        $supplierModel->instrument_device2 = $vo['重要仪器设备情况2'];
        //重要仪器设备情况3
        $supplierModel->instrument_device3 = $vo['重要仪器设备情况3'];
        //重要仪器设备情况4
        $supplierModel->instrument_device4 = $vo['重要仪器设备情况4'];
        //上一年度营业额（万元）
        $supplierModel->sales_latest = $vo['上一年度营业额（万元）'];
        //上一年度纳税额（万元）
        if ($vo['上一年度纳税额（万元）'] == '-') {
          $supplierModel->tax_latest = 0;
        } else {
          $supplierModel->tax_latest = $vo['上一年度纳税额（万元）'];
        }
        //企业近三年履行社会责任情况
        $supplierModel->social_responsibility = $vo['企业近三年履行社会责任情况'];
        //联系人
        if ($vo['联系人']) {
          $supplierModel->business_contact = $vo['联系人'];
        } else {
          //throw new BadRequestHttpException("编号为{$vo['编号']}的联系人不能为空!");
        }

        //联系人职务
        if ($vo['联系人职务']) {
          $supplierModel->business_position = $vo['联系人职务'];
        } else {
          //throw new BadRequestHttpException("编号为{$vo['编号']}的联系人职务不能为空!");
        }

        //联系人座机号
        if ($vo['联系人座机号']) {
          $supplierModel->business_phone = $vo['联系人座机号'];
        } else {
          //throw new BadRequestHttpException("编号为{$vo['编号']}的联系人座机号不能为空!");
        }

        //联系人手机号
        if ($vo['联系人手机号']) {
          $supplierModel->business_mobile = $vo['联系人手机号'];
        } else {
          //throw new BadRequestHttpException("编号为{$vo['编号']}的联系人手机号不能为空!");
        }

        //联系人email
        if ($vo['联系人email']) {
          $supplierModel->business_email = $vo['联系人email'];
        } else {
          //throw new BadRequestHttpException("编号为{$vo['编号']}的联系人email不能为空!");
        }

        //法人代表
        if ($vo['法人代表']) {
          $supplierModel->legal_person = $vo['法人代表'];
        } else {
          //throw new BadRequestHttpException("编号为{$vo['编号']}的法人代表不能为空!");
        }
        //法人职务
        if ($vo['法人职务']) {
          $supplierModel->legal_position = $vo['法人职务'];
        } else {
          //throw new BadRequestHttpException("编号为{$vo['编号']}的法人职务不能为空!");
        }

        //法人电话
        if ($vo['法人电话']) {
          $supplierModel->legal_phone = $vo['法人电话'];
        } else {
          //throw new BadRequestHttpException("编号为{$vo['编号']}的法人电话不能为空!");
        }
        //企业主要部门
        if ($vo['企业主要部门']) {
          $supplierModel->department_name = $vo['企业主要部门'];
        } else {
          //throw new BadRequestHttpException("编号为{$vo['编号']}的企业主要部门不能为空!");
        }
        //主要部门负责人
        if ($vo['主要部门负责人']) {
          $supplierModel->department_manager = $vo['主要部门负责人'];
        } else {
          //throw new BadRequestHttpException("编号为{$vo['编号']}的主要部门负责人不能为空!");
        }

        //主要部门负责人电话
        if ($vo['主要部门负责人电话']) {
          $supplierModel->department_manager_phone = $vo['主要部门负责人电话'];
        } else {
          //throw new BadRequestHttpException("编号为{$vo['编号']}的主要部门负责人电话不能为空!");
        }
        //企业代码
        $supplierModel->enterprise_code_desc = $vo['企业代码（此栏填写代码即可，后期系统上传附件）'];
        //开户许可证
        $supplierModel->enterprise_license_desc = $vo['开户许可证代码（此栏填写代码即可，后期系统上传附件）'];
        //相关资质证明
        $supplierModel->enterprise_license_relate_desc = $vo['相关资质名称'];
        //贸易商（中间商）代理资质
        $supplierModel->enterprise_certificate_desc = $vo['贸易商（中间商）代理资质'];
        //贸易商（中间商）其它相关资质
        $supplierModel->enterprise_certificate_etc_desc = $vo['贸易商（中间商）其它相关资质'];
        //供应商状态
        $supplierModel->status = 10;
        //供应商来源
        $supplierModel->source = 'import';
        //是否共享
        $supplierModel->public_flag = $vo['共享'] == '共享' ? 'y' : 'n';
        $supplierModel->isNewRecord = true;
        //$supplierModel->save() && $supplierModel->id = 0;
        //添加供应商成功
        if ($supplierModel->save()) {
          $supplierDetailModel = '';
          $supplierDetailModel = new SupplierDetail();
          $supplierDetailModel->scenario = 'add';
          //供应商id
          $supplierDetailModel->sid = $supplierModel->id;
          //cate_id1
          $supplierDetailModel->cate_id1 = $supplierModel->cate_id1;
          //cate_id2
          $supplierDetailModel->cate_id2 = $supplierModel->cate_id2;
          //cate_id3
          $supplierDetailModel->cate_id3 = $supplierModel->cate_id3;
          //供应商等级
          if (isset($vo['供应商等级'])) {
            if ($vo['供应商等级']) {
              $level = SupplierLevel::getLevelByName($vo['供应商等级']);
              if ($level) {
                $supplierDetailModel->level = $level->id;
              } else {
                //没有查到对应的供应商等级名称

              }
            } else {
              //没有填写对应的供应商等级名称

            }
          } else {
            throw new BadRequestHttpException("供应商等级不存在");
          }

          //一级部门（管理部门）
          //$supplierDetailModel->one_level_department = $vo['一级部门（管理部门）'];
          //二级部门
          //$supplierDetailModel->second_level_department = $vo['二级部门'];
          if ($vo['一级部门（管理部门）']) {
            $department = Department::getDepartmentByName($vo['一级部门（管理部门）'], 1);
            $supplierDetailModel->one_level_department = $department->id;
          } else {
            $supplierDetailModel->one_level_department = $vo['一级部门（管理部门）'];
          }
          //二级部门
          if ($vo['二级部门']) {
            $department = Department::getDepartmentByName($vo['二级部门'], 2);
            $supplierDetailModel->second_level_department = $department->id;
          } else {
            $supplierDetailModel->second_level_department = $vo['二级部门'];
          }
          //开发部门（写二级部门）
          $supplierDetailModel->develop_department = $vo['开发部门（写二级部门）'];
          //合作起始时间（年月）
          //$supplierDetailModel->coop_date = $vo['合作起始时间（年月）'];
          if ($vo['合作起始时间（年月）'] && $vo['合作起始时间（年月）'] != '-') {
            $register_date = date_parse_from_format('Y/m/d', $vo['合作起始时间（年月）']);
            $supplierDetailModel->coop_date = "{$register_date['year']}-{$register_date['month']}-{$register_date['day']}";
          } else {
            $supplierDetailModel->coop_date = $vo['合作起始时间（年月）'];
          }
          //2015年合同金额（万元）
          $supplierDetailModel->coop_fund1 = $vo['2015年合同金额（万元）'];
          //2015年交易金额（万元）
          $supplierDetailModel->trade_fund1 = $vo['2015年交易金额（万元）'];
          //2016年合同金额（万元）
          $supplierDetailModel->coop_fund2 = $vo['2016年合同金额（万元）'];
          //2016年交易金额（万元）
          $supplierDetailModel->trade_fund2 = $vo['2016年交易金额（万元）'];
          //2017年合同金额（万元）
          $supplierDetailModel->coop_fund3 = $vo['2017年合同金额（万元）'];
          //2017年交易金额（万元）
          $supplierDetailModel->trade_fund3 = $vo['2017年交易金额（万元）'];
          //我方对接人
          $supplierDetailModel->name = $vo['我方对接人'];
          //我方对接人手机号
          $supplierDetailModel->mobile = $vo['我方对接人手机号'];
          //爱慕选择合作原因
          $supplierDetailModel->reason = $vo['爱慕选择合作原因'];

          $supplierDetailModel->isNewRecord = true;


          //保存
          $supplierDetailModel->save();
          $supplierModel->id = 0;
        }
      }
      return true;
    } catch (BadRequestHttpException $ex) {
      return $ex->getMessage();
    }
  }

  /**
   * 上传附件
   * @return [type] [description]
   */
  public function actionUploadAttachment()
  {
    $field = Yii::$app->request->post('field');
    $supplierModel = new Supplier();
    $supplierModel->scenario = 'upload';

    if (Yii::$app->request->isPost) {
      switch ($field) {
        case 'enterprise_code_image_id':
          $supplierModel->enterprise_code = UploadedFile::getInstance($supplierModel, 'enterprise_code_image_id');
          $field = 'enterprise_code';
          break;
        case 'enterprise_license_image_id':
          $supplierModel->enterprise_license = UploadedFile::getInstance($supplierModel, 'enterprise_license_image_id');
          $field = 'enterprise_license';
          break;
        case 'enterprise_certificate_image_id':
          $supplierModel->enterprise_certificate = UploadedFile::getInstance($supplierModel, 'enterprise_certificate_image_id');
          $field = 'enterprise_certificate';
          break;
        case 'enterprise_certificate_etc_image_id':
          $supplierModel->enterprise_certificate_etc = UploadedFile::getInstance($supplierModel, 'enterprise_certificate_etc_image_id');
          $field = 'enterprise_certificate_etc';
          break;
        case 'enterprise_license_relate_image_id':
          $supplierModel->enterprise_license_relate = UploadedFile::getInstance($supplierModel, 'enterprise_license_relate_image_id');
          $field = 'enterprise_license_relate';
          break;
        default:
          # code...
          break;
      }
      if ($uploadInfo = $supplierModel->upload($field)) {
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

  /**
   *
   * 管理员查看供应商列表
   *
   */
  public function actionAdminList()
  {
    $searchModel = new SupplierSearch();
    $request = Yii::$app->request->queryParams;
    $department = Yii::$app->user->identity->department;
    $department_info = Department::getDepartmentById($department);
    if (!$department_info) {
      throw new NotFoundHttpException("此用户不包含管理部门");
    }
    //排除这几个一级部门
    $filter_department = ['大数据信息中心', '总裁办'];
    if (!in_array($department_info->department_name, $filter_department)) {
      throw new NotFoundHttpException("没有访问权限");
    }
    $request['SupplierSearch']['supplier_status'] = '10';
    $dataProvider = $searchModel->search($request);
    if (isset($request['SupplierSearch']['cate_id1'])) {
      $cate2 = SupplierCategory::getCategoryByParams('id,category_name', 2, $request['SupplierSearch']['cate_id1']);
    } else {
      $cate2 = SupplierCategory::getCategoryByParams('id,category_name', 2);
    }
    if (isset($request['SupplierSearch']['cate_id2'])) {
      $cate3 = SupplierCategory::getCategoryByParams('id,category_name', 3, $request['SupplierSearch']['cate_id2']);
    } else {
      $cate3 = SupplierCategory::getCategoryByParams('id,category_name', 3);
    }
    return $this->render('admin-list', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'cate2' => $cate2,
        'cate3' => $cate3,
    ]);
  }

  /**
   * Name: actionForbidden
   * User: aimer
   * Date: 2019/6/4
   * Time: 下午2:55
   * @return string|Response
   * @throws NotFoundHttpException
   */
  public function actionForbidden()
  {
    Yii::$app->response->format = Response::FORMAT_JSON;
    $id = Yii::$app->request->post('id');
    if ($id) {
      $model = $this->findModel($id);
      $model->scenario = 'edit';
      $model->status = 'forbidden';
      if ($model->save()) {
        $response_data['status'] = 'success';
        $response_data['msg'] = '拉黑成功！';
      } else {
        $response_data['status'] = 'fail';
        $response_data['msg'] = '';
      }
    } else {
      $response_data['status'] = 'fail';
      $response_data['msg'] = 'id不能为空！';
    }
    return $response_data;
  }


  public function actionData()
  {
    $category = SupplierCategory::getCategoryByParams('id,category_name', 1, 0);
    $levels = SupplierLevel::getLevels();
    unset($levels[1]);
    $level_arr = array_flip($levels);
    $category_arr = array_flip($category);
    $cate_ids = array_keys($category);
    $data = [];
    foreach ($category_arr as $category_name => $cate_id) {

      $data[$category_name]['total'] = Supplier::getCountByParams('cate_id1', $cate_id);
      foreach ($level_arr as $level_name => $level_id) {
        $where['cate_id1'] = $cate_id;
        $where['level'] = $level_id;
        $data[$category_name][$level_name] = Supplier::getCountByParamsArr($where);
      }
    }
    return $this->render('data', [
        'data' => $data
    ]);
  }

  /**
   * 根据id获取分类键值对
   * @return [type] [description]
   */
  public function actionGetAllCate()
  {
    Yii::$app->response->format = Response::FORMAT_JSON;
    $cate_id = Yii::$app->request->get('cate_id', '');
    //获取对应的大类
    $cate_id1 = Yii::$app->request->get('cate_id1', '');
    //获取对应的子类
    $cate_id2 = Yii::$app->request->get('cate_id2', '');
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
      $cate_id2 = explode('-', $cate_id2);
      $where['pid'] = $cate_id2;
      $where['level'] = 3;
      $where['status'] = 1;
    }
    if (empty($where)) {
      $category = '';
    } else {
      $categoryModel = new SupplierCategory;
      $category = $categoryModel::find()->select('id,category_name')->where($where)->asArray()->all();
      //return $category;
    }
    $out = ['results' => $category];
    return $out;
  }

}
