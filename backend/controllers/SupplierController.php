<?php

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
    public function actionIndex()
    {
        $searchModel = new SupplierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Suppliers model.
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
            return $this->redirect(['view', 'id' => $model->id]);
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

    public function actionUploadxls()
    {
        $uploadForm = new UploadForm();

        if (Yii::$app->request->isPost) {
            $upload = Yii::$app->request->post('UploadForm');
            $filePath = $upload['excelFile'];
            $data = Excel::import($filePath, [
                'setFirstRecordAsKeys' => true,
                'setIndexSheetByName' => true,
                'getOnlySheet' => 'sheet1',
            ]);
            $supplierModel = new Supplier;
            foreach ($data as $vo) {
                $supplierModel->scenario = 'add';
                $supplierModel->name = $vo['编号'];
                $supplierModel->business_address = 'ddd';
                $supplierModel->business_scope = 'ddd';
                $supplierModel->business_type = 1;
                $supplierModel->business_mobile = '33321111';
                $supplierModel->business_phone = '13811643823';
                $a = $supplierModel->save();
            }
            echo Json::encode([
                'data' => '上传成功！',
                'error' => '',
            ]);
        } else {
            return $this->render('uploadxls',
                [
                    'model' => $uploadForm,
                ]
            );
        }

    }

    public function actionUpload()
    {
        $uploadForm = new UploadForm();
        $uploadForm->scenario = 'file';
        if (Yii::$app->request->isPost) {
            $uploadForm->excelFile = UploadedFile::getInstance($uploadForm, 'excelFile');
            if ($filePath = $uploadForm->upload('excelFile')) {
                $this->actionImport($filePath);
                echo Json::encode([
                    'filepath' => $filePath,
                    'error' => '', //上传的error字段，如果没有错误就返回空字符串，否则返回错误信息，客户端会自动判定该字段来认定是否有错
                ]);
            } else {
                echo Json::encode([
                    'filepath' => '',
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
     * 供应商导入
     * @return [type] [description]
     */
    public function actionImport($filePath = '')
    {
        set_time_limit(1800);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = Excel::import($filePath, [
            'setFirstRecordAsKeys' => true,
            'setIndexSheetByName' => true,
            'getOnlySheet' => 'Sheet1',
        ]);

        $supplierModel = new Supplier;
        foreach ($data as $vo) {
            if ($vo['供应商全称']) {
                $supplier = Supplier::getSupplierByName($vo['供应商全称']);
                if ($supplier) {
                    continue;
                }
            }
            //供应商全称
            $supplierModel->name = $vo['供应商全称'];

            $supplierModel->scenario = 'add';
            // //供应商等级
            // if ($vo['供应商等级']) {
            //     $level = SupplierLevel::getLevelByName($vo['供应商等级']);
            //     if ($level) {
            //         $supplierModel->level = $level->id;
            //     } else {
            //         //没有查到对应的供应商等级名称

            //     }
            // } else {
            //     //没有填写对应的供应商等级名称

            // }
            //供应商总类
            if ($vo['供应商类别-总类']) {
                $category = SupplierCategory::getCategoryByName($vo['供应商类别-总类'], 1);
                if ($category) {
                    $supplierModel->cate_id1 = $category->id;
                } else {

                }
            } else {

            }
            //供应商大类
            if ($vo['供应商类别-大类']) {
                $category = SupplierCategory::getCategoryByName($vo['供应商类别-大类'], 2);
                if ($category) {
                    $supplierModel->cate_id2 = $category->id;
                } else {

                }
            } else {

            }
            //供应商子类
            if ($vo['供应商类别-子类']) {
                $category = SupplierCategory::getCategoryByName($vo['供应商类别-子类'], 3);
                if ($category) {
                    $supplierModel->cate_id3 = $category->id;
                } else {

                }
            } else {

            }

            //企业性质
            if ($vo['企业性质']) {
                $nature = SupplierNature::getNatureByName($vo['企业性质']);
                if ($nature) {
                    $supplierModel->firm_nature = $nature->id;
                } else {
                    //没有查到对应的企业性质名称

                }
            } else {
                //没有填写对应的企业性质名称

            }
            //营业范围
            $supplierModel->business_scope = $vo['营业范围'];
            //与爱慕已合作内容
            $supplierModel->coop_content = $vo['与爱慕已合作内容'];
            //经营地址
            $supplierModel->business_address = $vo['经营地址'];
            //官网
            $supplierModel->url = $vo['官网'];
            //供应商业务类型
            if ($vo['供应商业务类型']) {
                $type = SupplierType::getTypeByName($vo['供应商业务类型']);
                if ($type) {
                    $supplierModel->business_type = $type->id;
                } else {
                    //没有查到对应的供应商业务类型名称

                }
            } else {
                //没有填写对应的供应商业务类型名称

            }
            //
            if ($vo['所属行业（参照2017年国民经济行业分类与代码）']) {
                $trade = SupplierTrade::getTradeByName($vo['所属行业（参照2017年国民经济行业分类与代码）']);
                if ($trade) {
                    $supplierModel->trade = $trade->id;
                } else {
                    //没有查到对应的供应商业务类型名称

                }
            } else {
                //没有填写对应的供应商业务类型名称

            }
            //注册时间
            if ($vo['注册时间'] && $vo['注册时间'] != '-') {
                $register_date = date_parse_from_format('m-d-y', $vo['注册时间']);
                $supplierModel->register_date = "{$register_date['year']}-{$register_date['month']}-{$register_date['day']}";
            }else{
                $supplierModel->register_date = $vo['注册时间'];
            }
            //注册资金（万元）
            $supplierModel->register_fund = (float)$vo['注册资金（万元）'];
            //雇员人数
            $supplierModel->headcount = $vo['雇员人数'];
            //工厂概况-概述
            $supplierModel->factory_summary = $vo['工厂概况-概述'];
            //工厂概况-土地面积（㎡）
            $supplierModel->factory_land_area = $vo['工厂概况-土地面积（㎡）'];
            //工厂概况-厂房面积（㎡）
            $supplierModel->factory_work_area = $vo['工厂概况-厂房面积（㎡）'];
            //主要服务客户1
            $supplierModel->business_customer1 = $vo['主要服务客户1'];
            //主要服务客户2
            $supplierModel->business_customer2 = $vo['主要服务客户2'];
            //主要服务客户3
            $supplierModel->business_customer3 = $vo['主要服务客户3'];
            //主要原材料来源1
            $supplierModel->material_name1 = $vo['主要原材料来源1'];
            //主要原材料来源2
            $supplierModel->material_name1 = $vo['主要原材料来源2'];
            //主要原材料来源3
            $supplierModel->material_name1 = $vo['主要原材料来源3'];
            //重要仪器设备情况1
            $supplierModel->instrument_device1 = $vo['重要仪器设备情况1'];
            //重要仪器设备情况2
            $supplierModel->instrument_device2 = $vo['重要仪器设备情况2'];
            //重要仪器设备情况3
            $supplierModel->instrument_device3 = $vo['重要仪器设备情况3'];
            //重要仪器设备情况4
            $supplierModel->instrument_device4 = $vo['重要仪器设备情况4'];
            //上一年度营业额（万元）
            $supplierModel->sales_latest = (float)$vo['上一年度营业额（万元）'];
            //上一年度纳税额（万元）
            if ($vo['上一年度纳税额（万元）'] == '-') {
                $supplierModel->tax_latest = 0;
            } else {
                $supplierModel->tax_latest = (float)$vo['上一年度纳税额（万元）'];
            }
            //企业近三年履行社会责任情况
            $supplierModel->social_responsibility = $vo['企业近三年履行社会责任情况'];
            //联系人
            $supplierModel->business_contact = $vo['联系人'];
            //联系人职务
            $supplierModel->business_position = $vo['联系人职务'];
            //联系人座机号
            $supplierModel->business_phone = $vo['联系人座机号'];
            //联系人手机号
            $supplierModel->business_mobile = $vo['联系人手机号'];
            //联系人email
            $supplierModel->business_email = $vo['联系人email'];
            //法人代表
            $supplierModel->legal_person = $vo['法人代表'];
            //法人职务
            $supplierModel->legal_position = $vo['法人职务'];
            //法人电话
            $supplierModel->legal_phone = $vo['法人电话'];
            //企业主要部门
            $supplierModel->department_name = $vo['企业主要部门'];
            //主要部门负责人
            $supplierModel->department_manager = $vo['主要部门负责人'];
            //主要部门负责人电话
            $supplierModel->department_manager_phone = $vo['主要部门负责人电话'];
            //
            $supplierModel->isNewRecord = true;
            //$supplierModel->save() && $supplierModel->id = 0;
            //添加供应商成功
            if($supplierModel->save()) {
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
                //一级部门
                $supplierDetailModel->one_level_department = $vo['一级部门'];
                //二级部门
                $supplierDetailModel->second_level_department = $vo['二级部门'];
                //开发部门（写二级部门）
                $supplierDetailModel->develop_department = $vo['开发部门（写二级部门）'];
                //合作起始时间（年月）
                $supplierDetailModel->coop_date = $vo['合作起始时间（年月）'];
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
                var_dump($supplierModel->id);
                echo '------';
                var_dump($supplierDetailModel);die;

                $supplierModel->id = 0;
            }
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
}
