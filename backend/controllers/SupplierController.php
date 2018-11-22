<?php

namespace backend\controllers;

use Yii;
use backend\models\Supplier;
use backend\models\SupplierSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\SupplierLevel;
use backend\models\SupplierCategory;
use backend\models\SupplierTrade;
use backend\models\SupplierType;
use moonland\phpexcel\Excel;
use backend\models\SupplierDetail;
use backend\models\SupplierFunds;
use backend\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Json;

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
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $levelModel = new SupplierLevel;
        $categoryModel = new SupplierCategory;
        $tradeModel = new SupplierTrade;
        $typeModel = new SupplierType;
        $level = $levelModel::getLevelByParams();//供应商等级
        //$firm_nature = $categoryModel::getCategoryByParams();
        $firm_nature = [1=>'国有',2=>'合资',3=>'独资'];//企业性质
        $trade = $tradeModel::getTradeByParams();//所属行业
        $type = $typeModel::getTypeByParams();//业务类型
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $levelModel = new SupplierLevel;
        $categoryModel = new SupplierCategory;
        $tradeModel = new SupplierTrade;
        $typeModel = new SupplierType;
        $level = $levelModel::getLevelByParams();
        //$firm_nature = $categoryModel::getCategoryByParams();
        $firm_nature = [1=>'国有',2=>'合资',3=>'独资'];
        $trade = $tradeModel::getTradeByParams();
        $type = $typeModel::getTypeByParams();//业务类型
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

        if(Yii::$app->request->isPost){
            $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');

            if($imageUrl = $uploadForm->upload()){
                echo Json::encode([
                   'imageUrl'    => $imageUrl,
                    'error'   => ''     //上传的error字段，如果没有错误就返回空字符串，否则返回错误信息，客户端会自动判定该字段来认定是否有错
                ]);
            }else{
                echo Json::encode([
                    'imageUrl'    => '',
                    'error'   => '文件上传失败'
                ]);
            }
        }
        return $this->render('uploadxls',
                [
                    'model' => $uploadForm,
                ]
            );
    }

    /**
     * 供应商导入
     * @return [type] [description]
     */
    public function actionImport()
    {
        $data = Excel::import('f:\20181112.xlsx',[              
        'setFirstRecordAsKeys' => true,               
        'setIndexSheetByName' => true,               
        'getOnlySheet' => 'sheet1',               
        ]);
        $supplierModel = new Supplier;
        foreach($data as $vo) {
            $supplierModel->scenario = 'add';
            $supplierModel->name = $vo['编号'];
            $supplierModel->business_address = 'ddd';
            $supplierModel->business_scope = 'ddd';
            $supplierModel->business_type = 1;
            $supplierModel->business_mobile = '33321111';
            $supplierModel->business_phone = '13811643823';
            $a = $supplierModel->save();
            var_dump($a);die;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }    


}
