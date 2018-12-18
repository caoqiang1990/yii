<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace frontend\controllers;

use yii;
use yii\web\Controller;
use frontend\models\Supplier;
use app\models\SupplierExt;
use backend\models\SupplierLevel;
use backend\models\SupplierCategory;
use backend\models\SupplierTrade;
use backend\models\SupplierType;
use backend\models\Attachment;
use moonland\phpexcel\Excel;
use backend\models\SupplierDetail;
use backend\models\SupplierFunds;
use backend\models\UploadForm;
use yii\helpers\Json;
use common\models\AdminLog;
use yii\web\UploadedFile;
use backend\models\SupplierNature;

class SupplierformController extends Controller
{
/**
     * Suppliers Basic forms.
     * @return mixed
     */
    public $sid;
    
    public function actionSupplierinfo()
    {
        $model = new Supplier;
        $model->scenario = 'add';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            AdminLog::saveLog('supplier','create',$model->getByID($model->primaryKey),$model->primaryKey);
            return $this->redirect(['confirm', 'id' => $model->id]);
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
    public function actionConfirm($id)
    {
        
        return $this->render('confirm', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionView($id)
    {
        
        return $this->render('view', [
            'model' => $this->findModel($id),
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
//        var_dump($model);
//        var_dump($post);
//        exit;
        if ($model->load($post) && $model->save()) {
            AdminLog::saveLog('supplier', 'update', $model->getByID($model->primaryKey), $model->primaryKey,$original);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $attachmentModel = new Attachment();
        $image = $attachmentModel->getImageByID($model->enterprise_code);
        
//        //attachment表中增加一个供应商Id防止更新后以前的记录成为死记录
//        $image1Model = $attachmentModel::findOne($model->enterprise_code)->sid = $model->id;
//        $image1Model->sid = $model->id;
//        $image1Model->save();
        $model->enterprise_code_url = $image ? $image->url : '';
        $image = $attachmentModel->getImageByID($model->enterprise_license);
//        $image1Mode2 = $attachmentModel::findOne($model->enterprise_license)->sid = $model->id;
//        $image1Mode2->sid = $model->id;
//        $image1Mode2->save();
        $model->enterprise_license_url = $image ? $image->url : '';
        $image = $attachmentModel->getImageByID($model->enterprise_license_relate);
//        $image1Mode3 = $attachmentModel::findOne($model->enterprise_license_relate)->sid = $model->id;
//        $image1Mode3->sid = $model->id;
//        $image1Mode3->save();
        $model->enterprise_license_relate_url = $image ? $image->url : '';
        $image = $attachmentModel->getImageByID($model->enterprise_certificate);
        $model->enterprise_certificate_url = $image ? $image->url : '';
        $image = $attachmentModel->getImageByID($model->enterprise_certificate_etc);
        $model->enterprise_certificate_etc_url = $image ? $image->url : '';
        $levelModel = new SupplierLevel;
        $categoryModel = new SupplierCategory;
        $tradeModel = new SupplierTrade;
        $typeModel = new SupplierType;
        $level = $levelModel::getLevelByParams();
        //$firm_nature = $categoryModel::getCategoryByParams();
        $firm_nature = [1 => '国有', 2 => '合资', 3 => '独资'];
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
