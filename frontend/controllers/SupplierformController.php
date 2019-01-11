<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use backend\models\Attachment;
use frontend\models\Supplier;
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
use yii\filters\AccessControl;
use yii\web\Cookie;

class SupplierformController extends Controller
{
/**
     * Suppliers Basic forms.
     * @return mixed
     */
    public $sid;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' =>   [
                'class' => AccessControl::className(),
                'only' => ['supplierinfo'],
                'rules' => [
                    [
                        'actions' => ['supplierinfo'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['supplierinfo'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new \Exception('You are not allowed to access this page');
                },
            ],
            
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'supplierinfo' => ['post','get'],
                ],
            ],
        ];
    }
    public function actionSupplierinfo()
    {
        $model = new Supplier;
        $model->scenario = 'add';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//          $md = $_GET['md'];
//          AdminLog::saveLog('supplier','create',$model->getByID($model->primaryKey),$model->primaryKey);
//          if($md !="save")
//          {
            return $this->redirect(['confirm', 'id' => $model->id]);
//          }
//          else
//          {
//            return $this->redirect(['update', 'id' => $model->id]);
//          }
        }

        $levelModel = new SupplierLevel;
        $categoryModel = new SupplierCategory;
        $tradeModel = new SupplierTrade;
        $typeModel = new SupplierType;
        $natureModel = new SupplierNature;
        $level = $levelModel::getLevelByParams();//供应商等级
        $firm_nature = $natureModel::getNatureByParams(); //企业性质
        $trade = $tradeModel::getTradeByParams();//所属行业
        $type = $typeModel::getTypeByParams();//业务类型
        return $this->render('supplierinfo', [
            'model' => $model,
            'level' => $level,
            'firm_nature' => $firm_nature,
            'trade' => $trade,
            'type' => $type,
        ]);
    }
    public function actionConfirm()
    {
        
        return $this->render('confirm');
    }
    public function actionView($id)
    {
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Updates an existing Suppliers model.
     * If update is successful, the browser will be redirected to the 'confirm' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
//        $cookies = Yii::$app->request->cookies;
//        if (($cookie = $cookies->get('supplier_id')) !== null) {
//            $supplier_id = $cookie->value;
//            if($id != $supplier_id);
//            $id = $supplier_id;
//         }
//         else{
//           $response_cookies = Yii::$app->response->cookies;
//           $response_cookies->add(new \yii\web\Cookie([
//            'name' => 'supplier_id',
//            'value' => $id,
//          ]));
//         }
        $ids = [541,542,543,544,545,546,547,548,549,550];
        if (in_array($id,$ids)) {
            $model = $this->findModel($id);
        } else {
            $id = deCrypt($id);
            $model = $this->findModel($id);
        }
        //非wait状态不可查看
        if ($model->status != 'wait') {
            throw new NotFoundHttpException('无查看权限');
        }
        $model->scenario = 'edit';

        $post = Yii::$app->request->post();
        $original = $model->getByID($id);
        
        if ($model->load($post)) {//
//            AdminLog::saveLog('supplier', 'update', $model->getByID($model->primaryKey), $model->primaryKey,$original);
            if($model->status == 'wait')
            {
              $model->status = 'auditing';//
              $model->save();
              return $this->redirect(['confirm', 'model' => $model]);
            }
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

        throw new NotFoundHttpException(Yii::t('app', 'The requested model does not exist.'));
    }
    public function actionUpload()
    {
        $uploadForm = new UploadForm();

        if(Yii::$app->request->isPost){
            $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');

            if($filePath = $uploadForm->upload()){
                $this->actionImport($filePath);
                echo Json::encode([
                   'filepath'    => $filePath,
                    'error'   => ''     //上传的error字段，如果没有错误就返回空字符串，否则返回错误信息，客户端会自动判定该字段来认定是否有错
                ]);
            }else{
                echo Json::encode([
                    'filepath'    => '',
                    'error'   => '文件上传失败'
                ]);
            }
        }else{
            echo Json::encode([
                    'filepath' => '',
                    'error' => '文件上传失败'
                ]);
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

        if(Yii::$app->request->isPost){
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
            if($uploadInfo = $supplierModel->upload($field)){
                echo Json::encode([
                   'filepath' => $uploadInfo['filepath'],
                   'imageid' => $uploadInfo['imageid'],
                   'error' => ''     //上传的error字段，如果没有错误就返回空字符串，否则返回错误信息，客户端会自动判定该字段来认定是否有错
                ]);
            }else{
                echo Json::encode([
                    'filepath' => '',
                    'imageid' => '',
                    'error' => '文件上传失败'
                ]);
            }
        }else{
            echo Json::encode([
                    'filepath' => '',
                    'error' => '文件上传失败'
                ]);
        }

    }
    public function actionSupplierExt($sid)
    {
      $supplierExtModel = new SupplierExt;
      $supplierExtModel->sid = $sid;
      if ($supplierExtModel->load(Yii::$app->request->post()) && $supplierExtModel->validate()) {
        // 验证 $supplierExtModel 收到的数据
        
        $supplierExtModel->save();
        
        return $this->redirect(['supplier-basic']);
      } else {
          // 无论是初始化显示还是数据验证错误
          return $this->render('supplier-ext', ['model' => $supplierExtModel]);
      }
    }
}
