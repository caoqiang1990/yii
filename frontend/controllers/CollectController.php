<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Pitch;
use frontend\models\Supplier;
use yii\web\UploadedFile;
use yii\helpers\Json;
use backend\models\Attachment;
use yii\helpers\Url;
use yii\web\Response;
use frontend\models\PitchAttachment;
use backend\models\PitchRecord;

class CollectController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['attachment'],
                'rules' => [
                    [
                        'actions' => ['attachment'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new \Exception('没有权限访问相关页面！');
                },
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'attachment' => ['post', 'get'],
                ],
            ],
        ];
    }

    public function actionAttachment($verid)
    {
        //verid 为 pitch_id   //signid为supplier_id
        $id = deCrypt($verid);
        $pitchModel = $this->findModel($id);
        $sid = Yii::$app->request->get('signid');
        $sid = deCrypt($sid);
        //获取
        $exist = PitchAttachment::getAttachmentByParams($id, $sid);
        if ($exist) {
            throw new NotFoundHttpException('请勿重复提交！');
        }
        $supplier = Supplier::getSupplierById($sid);
        if (!$supplier) {
            throw new NotFoundHttpException('找不到相关页面！');
        }
        $model = new PitchAttachment;
        $model->scenario = 'upload';
        $model->pitch_id = $id;
        $model->sid = $sid;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['confirm']);
        }
        $initialPreview = [];
        $initialPreviewConfig = [];
        //初始化
        if ($model->attachment) {
            $attachmentModel = new Attachment();
            $attachArr = explode(',', $model->attachment);
            foreach ($attachArr as $k => $attach) {
                $image = $attachmentModel->getImageByID($attach);
                $initialPreview[$k] = $image->url;
                $initialPreviewConfig[$k] = ['url' => Url::to(['delete-attachment', 'id' => $id]), 'key' => $attach, 'id' => $id];
            }
        }
        return $this->render('attachment', [
            'model' => $model,
            'initialPreview' => $initialPreview,
            'initialPreviewConfig' => $initialPreviewConfig,
            'sid' => $sid,
            'pitchModel' => $pitchModel,
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
        if (($model = Pitch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('找不到相关页面！');
    }

    /**
     * 上传附件
     * @return [type] [description]
     */
    public function actionUploadAttachment()
    {
        $field = Yii::$app->request->post('field');
        $model = new PitchAttachment();
        $model->scenario = 'upload';

        if (Yii::$app->request->isPost) {
            switch ($field) {
                case 'attachment_id':
                    $model->attachment = UploadedFile::getInstance($model, 'attachment_id');
                    $field = 'attachment';
                    break;
                default:
                    # code...
                    break;
            }
            if ($uploadInfo = $model->upload($field)) {
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
     * 删除附件
     * @return [type] [description]
     */
    public function actionDeleteAttachment($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);
        $key = Yii::$app->request->post('key');
        $delArr = explode(',', $key);
        $model->scenario = 'edit';
        $old = $model->attachment;
        $oldArr = explode(',', $old);
        $newArr = array_diff($oldArr, $delArr);
        if (empty($newArr)) {
            $model->attachment = '';
        } else {
            $model->attachment = implode(',', $newArr);
        }
        if ($model->save()) {
            $response_data['status'] = 'success';
            $response_data['msg'] = '删除成功';
        }
        return $response_data;
    }


    public function actionConfirm()
    {
        return $this->render('confirm');
    }
}