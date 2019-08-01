<?php

namespace backend\controllers;

use Yii;
use backend\models\AdminAdd;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\helpers\Json;

/**
 *
 *
 */
class AdminAddController extends Controller
{

    /**
     * 上传附件
     * @return [type] [description]
     */
    public function actionUploadAttachment()
    {

        $field = Yii::$app->request->post('field');
        $adminAddModel = new AdminAdd();

        if (Yii::$app->request->isPost) {
            if (empty($_FILES)) {
                echo Json::encode([
                    'filepath' => '',
                    'error' => '请选择要上传文件',
                ]);
            } else {
                switch ($field) {
                    case 'check_id':
                        $adminAddModel->check = UploadedFile::getInstance($adminAddModel, 'check_id');
                        $field = 'check';
                        break;
                    default:
                        break;
                }
                if ($uploadInfo = $adminAddModel->upload($field)) {
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
            }

        } else {
            echo Json::encode([
                'filepath' => '',
                'error' => '请选择要上传文件',
            ]);
        }
    }
}
