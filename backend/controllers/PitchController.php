<?php

namespace backend\controllers;

use Yii;
use backend\models\Pitch;
use backend\models\PitchSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Json;
use backend\models\Supplier;
use backend\models\Attachment;
use backend\models\Department;
use mdm\admin\models\User;
use yii\web\Response;
use backend\models\PitchRecord;
use yii\helpers\Url;
use backend\models\PitchAttachment;
use backend\models\DepartmentAssignment;

/**
 * PitchController implements the CRUD actions for Pitch model.
 */
class PitchController extends Controller
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
     * Lists all Pitch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PitchSearch();

        $request = Yii::$app->request->queryParams;
        //$department = Yii::$app->user->identity->department;
        $user_id = Yii::$app->user->identity->id;
        $department_ids = DepartmentAssignment::getByUserId($user_id);

        $request['PitchSearch']['department'] = $department_ids;
        $dataProvider = $searchModel->search($request);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pitch model.
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
     * Creates a new Pitch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pitch();
        $model->scenario = 'add';
        $department = Yii::$app->user->identity->department;
        $model->department = $department;
        $model->status = 'wait';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //写入日志
            $pitchModel = new PitchRecord();
            $pitchModel->content = '新建比稿项目';
            $pitchModel->pitch_id = $model->id;
            $pitchModel->save();//写入日志
            return $this->redirect(['view', 'id' => $model->id]);
        }
        //供应商集合
        $suppliers = Supplier::getSuppliers();
        $users = User::getUsers();
        $departmentModel = new Department();
        $info = $departmentModel->getDepartmentById($department);
        $model->department = $info->department_name;

        return $this->render('create', [
            'model' => $model,
            'suppliers' => $suppliers,
            'users' => $users,
        ]);
    }

    /**
     * Updates an existing Pitch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'edit';
        $model->sids = explode(',', $model->sids);
        $model->auditor = explode(',',$model->auditor);
        $department = Yii::$app->user->identity->department;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        //供应商集合
        $suppliers = Supplier::getSuppliers();
        $users = User::getUsers();

        $attachmentModel = new Attachment();
        $image = $attachmentModel->getImageByID($model->record);
        $model->record_url = $image ? $image->url : '';   
        $departmentModel = new Department();
        $info = $departmentModel->getDepartmentById($department);
        $model->department = $info->department_name;     
        return $this->render('update', [
            'model' => $model,
            'suppliers' => $suppliers,
            'users' => $users,
        ]);
    }

    /**
     * Deletes an existing Pitch model.
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
     * Finds the Pitch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pitch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pitch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('pitch', 'The requested page does not exist.'));
    }


    /**
     * 上传附件
     * @return [type] [description]
     */
    public function actionUploadAttachment()
    {
        $field = Yii::$app->request->post('field');
        $pitchModel = new Pitch();
        $pitchModel->scenario = 'upload';

        if (Yii::$app->request->isPost) {
            switch ($field) {
                case 'record_id':
                    $pitchModel->record = UploadedFile::getInstance($pitchModel, 'record_id');
                    $field = 'record';
                    break;
                default:
                    # code...
                    break;
            }
            if ($uploadInfo = $pitchModel->upload($field)) {
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
     * Name: actionStart 开始评审
     * User: aimer
     * Date: 2019/3/25
     * Time: 上午10:50
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionStart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        if (!$id) {
            $response_data['status'] = 'fail';
            $response_data['msg'] = 'id不能为空';
        } else {
            $model = $this->findModel($id);
            if ($model->status != 'wait') {
                $response_data['status'] = 'fail';
                $response_data['msg'] = '邮件已经发送过';
            } else {
                //发送邮件到对应供应商
                $pitch = Pitch::getPitchById($id);
                if ($pitch->sids) {
                    $result = Pitch::sendEmail($pitch->id,explode(',',$pitch->sids),'比稿完善信息');
                    if ($result) {
                        //写入日志
                        $pitchModel = new PitchRecord();
                        $pitchModel->content = '邮件发送成功';
                        $pitchModel->pitch_id = $id;
                        $pitchModel->save();//写入日志
                        $model->scenario = 'edit';//编辑
                        $model->status = 'auditor';//审核状态
                        $model->save();//保存状态
                        $response_data['status'] = 'success';
                        $response_data['msg'] = '邮件发送成功';
                    } else {
                        $response_data['status'] = 'fail';
                        $response_data['msg'] = '邮件发送失败';
                    }
                } else {
                    $response_data['status'] = 'fail';
                    $response_data['msg'] = '供应商不能为空';
                }
            }

        }
        return $response_data;
    }

    /**
     * Name: actionCheck 检测邮箱是否有效
     * User: aimer
     * Date: 2019/3/25
     * Time: 上午10:50
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCheck()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $error_msg = '';
        $flag = true;
        if (!$id) {
            $response_data['status'] = 'fail' ;
            $response_data['msg'] = 'id不能为空';
        } else {
            $model = $this->findModel($id);
            $sids = $model->sids;
            if (!$sids) {
                $response_data['status'] = 'fail';
                $response_data['msg'] = '不存在供应商';
            } else {
                $sid_arr = explode(',',$sids);
                foreach ($sid_arr as $id) {
                    try{
                        $supplier = Supplier::getSupplierById($id);
                        $email = $supplier->business_email;
                        if (preg_match("/^[a-z]*[0-9]*([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i",$email)) {
                            
                        } else {
                            throw new \Exception("供应商名：{$supplier->name}，邮箱不存在。");
                        }
                    } catch (\Exception $e) {
                        $flag = false;
                        $error_msg .= $e->getMessage();
                    }
                }
                if ($flag) {
                    $response_data['status'] = 'success';
                    $response_data['msg'] = '供应商邮箱正常';
                } else {
                    $response_data['status'] = 'fail';
                    $response_data['msg'] = $error_msg;
                }
            }
        }
        return $response_data;  
    }

    /**
     * Name: actionReviewList 比稿审核查看
     * User: aimer
     * Date: 2019/3/22
     * Time: 下午1:11
     * @return string
     */
    public function actionReviewList()
    {
        $uid = Yii::$app->user->identity->id;
        $searchModel = new PitchSearch();
        $request['PitchSearch']['auditor'] = $uid;
        $dataProvider = $searchModel->search($request);

        return $this->render('review-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);        
    }

    /**
     * Name: actionTimeLine 比稿时间线
     * User: aimer
     * Date: 2019/3/22
     * Time: 下午1:10
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionTimeLine($id)
    {
        $model = new PitchRecord;

        $model->pitch_id = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Url::to(['time-line','id'=>$id])); 
        }
        //获取对应的附件
        $attachArr = [];
        $initialPreview = [];
        $records = PitchRecord::getPitchRecordByPitchId($id);
        foreach ($records as &$record) {
            if ($record['attachment']) {
                $attachment = explode(',',$record['attachment']);
                if ($attachment) {
                    $attachmentModel = new Attachment();
                    foreach ($attachment as $k => $attach) {
                        $image = $attachmentModel->getImageByID($attach);
                        $initialPreview[$k] = $image->url;
                    }
                }
                $record['url'] = $initialPreview;
            } else {
                $record['url'] = '';
            }
        }
        $pitchModel = $this->findModel($id);
        return $this->render('time-line',[
                'model' => $model,
                'id' => $id,
                'records' => $records,
                'pitchModel' => $pitchModel,
                'initialPreview' => $initialPreview,
            ]);
    }

    /**
     * Name: actionFinish 比稿结束
     * User: aimer
     * Date: 2019/3/22
     * Time: 下午1:10
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionFinish($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'edit';
        $model->status = 10;//项目结束状态
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //写入日志
            $pitchModel = new PitchRecord();
            $pitchModel->content = '项目结束';
            $pitchModel->pitch_id = $model->id;
            $pitchModel->save();//写入日志
            //Yii::$app->session->setFlash('success', '比稿结束!');
            return $this->redirect(['my']);
        }
        $attachmentModel = new Attachment();
        $image = $attachmentModel->getImageByID($model->record);
        $model->record_url = $image ? $image->url : '';   
        return $this->render('finish',['model' => $model]);
    }

    /**
     * Name: actionRecord 比稿记录
     * User: aimer
     * Date: 2019/3/22
     * Time: 下午1:09
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionRecord($id)
    {
        $model = $this->findModel($id);
        $attachmentModel = new Attachment();
        $image = $attachmentModel->getImageByID($model->record);
        $model->record_url = $image ? $image->url : '';
        $records = PitchRecord::getPitchRecordByPitchId($id);
        foreach ($records as &$record) {
            if ($record['attachment']) {
                $attachment = explode(',',$record['attachment']);
                if ($attachment) {
                    $attachmentModel = new Attachment();
                    foreach ($attachment as $k => $attach) {
                        $image = $attachmentModel->getImageByID($attach);
                        $info = pathinfo($image->filepath);
                        if (in_array($info['extension'],['jpg','png'])) {
                            $initialPreview[$k]['filetype'] = 'image';
                            $initialPreview[$k]['filename'] = $info['filename'].'.'.$info['extension'];
                        } else {
                            $initialPreview[$k]['filetype'] = 'file';
                            $initialPreview[$k]['filename'] = $info['filename'].'.'.$info['extension'];
                        }
                        $initialPreview[$k]['url'] = $image->url;
                    }
                }
                $record['url'] = $initialPreview;
            } else {
                $record['url'] = '';
            }
        }
        return $this->render('record',['model' => $model,'records' => $records]);
    }

    /**
     * Name: actionMy 我发起的项目
     * User: aimer
     * Date: 2019/3/22
     * Time: 下午1:09
     * @return string
     */
    public function actionMy()
    {
        $searchModel = new PitchSearch();

        $request = Yii::$app->request->queryParams;
        $uid = Yii::$app->user->identity->id;

        $request['PitchSearch']['created_by'] = $uid;

        $dataProvider = $searchModel->search($request);

        return $this->render('my', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
