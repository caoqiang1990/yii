<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use backend\models\Attachment;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "{{%pitch}}".
 **/
class Pitch extends ActiveRecord
{
    const SCENARIO_UPLOAD = 'upload';
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';
    public $record_id;
    public $record_url;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pitch}}';
    }

    /**
     * 行为
     * @return [type] [description]
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('pitch', 'id'),
            'name' => Yii::t('pitch', 'name'),
            'desc' => Yii::t('pitch', 'desc'),
            'start_date' => Yii::t('pitch', 'start_date'),
            'end_date' => Yii::t('pitch', 'end_date'),
            'sids' => Yii::t('pitch', 'sids'),
            'record' => Yii::t('pitch', 'record'),
            'remark' => Yii::t('pitch', 'remark'),
            'result' => Yii::t('pitch', 'result'),
            'created_at' => Yii::t('pitch', 'created_at'),
            'updated_at' => Yii::t('pitch', 'updated_at'),
            'created_by' => Yii::t('pitch', 'created_by'),
            'updated_by' => Yii::t('pitch', 'updated_by'),
            'record_id' => Yii::t('pitch', 'record_id'),
            'document' => Yii::t('pitch', 'document'),
            'status' => Yii::t('pitch', 'status'),
        ];
    }

    /**
     * 场景
     * @return [type] [description]
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_UPLOAD => [
                'record',
            ],
            self::SCENARIO_ADD => [
                'name', 'desc', 'start_date', 'end_date', 'sids', 'record', 'remark',
                'result', 'department', 'auditor', 'document', 'status'
            ],
            self::SCENARIO_EDIT => [
                'name', 'desc', 'start_date', 'end_date', 'sids', 'record', 'remark',
                'result', 'department', 'auditor', 'document', 'status'
            ],
        ];
    }

    /**
     * 规则
     * @return [type] [description]
     */
    public function rules()
    {
        return [

        ];
    }

    public function upload($field)
    {
        if ($this->validate()) {
            $path = \Yii::getAlias('@uploadPath') . '/' . date("Ymd");
            if (!is_dir($path) || !is_writable($path)) {
                FileHelper::createDirectory($path, 0777, true);
            }
            $filePath = $path . '/' . \Yii::$app->request->post('model', '') . '_' . md5(uniqid() . mt_rand(10000, 99999999)) . '.' . $this->{$field}->extension;
            if ($this->{$field}->saveAs($filePath)) {
                //如果上传成功，保存附件信息到数据库。TODO
                //这里将上传成功后的图片信息保存到数据库
                $imageUrl = $this->parseImageUrl($filePath);
                $attachmentModel = new Attachment;
                $attachmentModel->url = $imageUrl;
                $attachmentModel->filepath = $filePath;
                $attachmentModel->status = 1;
                $attachmentModel->type = 'image';
                $attachmentModel->module = Yii::$app->request->post('model', '');
                $attachmentModel->created_at = time();
                $attachmentModel->updated_at = time();
                $attachmentModel->save(false);
                $imageId = Yii::$app->db->getLastInsertID();
                return ['filepath' => $filePath, 'imageid' => $imageId];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 这里在upload中定义了上传目录根目录别名，以及图片域名
     * 将/var/www/html/advanced/frontend/web/uploads/20160626/file.png 转化为 http://statics.gushanxia.com/uploads/20160626/file.png
     * format:http://domain/path/file.extension
     * @param $filePath
     * @return string
     */
    public function parseImageUrl($filePath)
    {
        if (strpos($filePath, Yii::getAlias('@uploadPath')) !== false) {
            $url = Yii::$app->params['assetDomain'] . str_replace(Yii::getAlias('@uploadPath'), '', $filePath);
            return $url;
        } else {
            return $filePath;
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) { // 新增操作
                //对sids 进行操作
                if (is_array($this->sids)) {
                    $this->sids = implode(',', $this->sids);
                }
                if (is_array($this->auditor)) {
                    $this->auditor = implode(',', $this->auditor);
                }
            } else {
                //sids 进行操作
                if (is_array($this->sids)) {
                    $this->sids = implode(',', $this->sids);
                }
                if (is_array($this->auditor)) {
                    $this->auditor = implode(',', $this->auditor);
                }
            }
            return true;
        } else {
            return false;
        }
    }


    public static function sendEmail($pitch_id, $sids = [], $subject = '')
    {
        if (!$pitch_id) {
            return false;
        }
        $model = self::getPitchById($pitch_id);
        if (!$sids) {
            return false;
        }
//        $attachModel = new Attachment();
//        $image = $attachModel->getImageByID($model->attachment);
//        $attachFile = $image->filepath;
        $messages = [];
        foreach ($sids as $sid) {
            $supplier = Supplier::getSupplierById($sid);
            if ($supplier) {
                $messages[] = Yii::$app->mailer->compose(['html' => 'uploadAttachment-html', 'text' => 'uploadAttachment-text'], ['supplier' => $supplier, 'pitch_id' => $model->id])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                    ->setTo($supplier->business_email)
//                    ->attach($attachFile)
                    ->setSubject($subject . Yii::$app->name);;
            }
        }
        $count = Yii::$app->mailer->sendMultiple($messages);
        if (!$count) {
            return false;
        }
        return true;
    }

    /**
     * 根据id获取比稿
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public static function getPitchById($id = '')
    {
        if (!$id) {
            return false;
        }
        $info = self::find()->where(['id' => $id])->one();
        return $info ? $info : false;
    }

    /**
     *
     * 关联表获取数据
     *
     **/
    public function getAttachments()
    {
        return $this->hasMany(PitchAttachment::className(), ['pitch_id' => 'id']);
    }
}