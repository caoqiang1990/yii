<?php

namespace backend\models;

use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $excelFile;
    public $filePath;
    const SCENARIO_FILE = 'file';
    const SCENARIO_IMAGE = 'image';

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => '*', 'on' => 'image'],
            [['excelFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx', 'on' => 'file'],
        ];
    }

    /**
     * 场景
     * @return [type] [description]
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_FILE => [
                'excelFile',
            ],
            self::SCENARIO_IMAGE => [
                'imageFile',
            ],

        ];

    }

    public function upload($type)
    {
        if ($this->validate()) {
            $path = \Yii::getAlias('@uploadPath') . '/' . date("Ymd");
            if (!is_dir($path) || !is_writable($path)) {
                FileHelper::createDirectory($path, 0777, true);
            }
            $filePath = $path . '/' . \Yii::$app->request->post('model', '') . '_' . md5(uniqid() . mt_rand(10000, 99999999)) . '.' . $this->{$type}->extension;

            if ($this->{$type}->saveAs($filePath)) {
                //如果上传成功，保存附件信息到数据库。TODO

            }
            return $filePath;
        } else {
            return false;
        }
    }
}
