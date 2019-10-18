<?php

namespace backend\models;

use Yii;
use backend\models\Attachment;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "document".
 *
 * @property int $id
 * @property int $department 所属部门
 * @property string $doc 文档id
 * @property int $created_by 创建人
 * @property int $updated_by 修改人
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 */
class Document extends \yii\db\ActiveRecord
{
    public $doc_id;
    public $doc_url;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['department', 'cate'], 'integer'],
            ['doc', 'required'],
            ['doc_name', 'string'],
            [['doc_id'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg', 'on' => 'upload'],
        ];
    }


    /**
     * *
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('document', 'ID'),
            'department' => Yii::t('document', 'Department'),
            'doc' => Yii::t('document', 'Doc'),
            'created_by' => Yii::t('document', 'Created By'),
            'updated_by' => Yii::t('document', 'Updated By'),
            'created_at' => Yii::t('document', 'Created At'),
            'updated_at' => Yii::t('document', 'Updated At'),
            'doc_id' => Yii::t('document', 'Doc_id'),
            'save' => Yii::t('document', 'Save'),
            'doc_name' => Yii::t('document', 'Doc_Name'),
            'cate' => Yii::t('document', 'Cate'),
        ];
    }

    /**
     * Name: upload
     * User: aimer
     * Date: 2019/7/23
     * Time: 上午10:12
     * @param $field
     * @return array|bool
     */
    public function upload($field)
    {
        $this->scenario = 'upload';
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
                $attachmentModel->filename = $this->{$field}->name;
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
}
