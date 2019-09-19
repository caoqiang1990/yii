<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use frontend\models\Pitch;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use backend\models\Attachment;
use yii\helpers\FileHelper;
use backend\models\PitchRecord;
use frontend\models\Supplier;

/**
 *
 * 比稿记录
 *
 */
class PitchAttachment extends ActiveRecord
{
    const SCENARIO_UPLOAD = 'upload';
    public $attachment_id;
    public $attachment_url;

    /**
     * 返回表名
     * @return [type] [description]
     */
    public static function tableName()
    {
        return '{{%pitch_attachment}}';
    }

    /**
     * 场景
     * @return [type] [description]
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_UPLOAD => [
                'pitch_id', 'attachment', 'sid'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attachment', 'pitch_id', 'sid'], 'safe']
        ];
    }

    /**
     * 对应中文
     * @return [type] [description]
     */
    public function attributeLabels()
    {
        return [
        ];
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

    public static function getPitchAttachmentByPitchId($id)
    {
        if (!$id) {
            return false;
        }
        $where = ['pitch_id' => $id];
        $attachments = self::find()->where($where)->asArray()->all();
        return $attachments;
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
								$attachmentModel->filename = $this->{$field}->name;
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

    /**
     *
     * 操作
     *
     **/
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) { // 新增操作
                if (is_array($this->attachment)) {
                    $this->attachment = implode(',', $this->attachment);
                    $model = Supplier::getSupplierById($this->sid);
                    //写入日志
                    $pitchModel = new PitchRecord();
                    $pitchModel->content = "$model->name , 上传附件";
                    $pitchModel->pitch_id = $this->pitch_id;
                    $pitchModel->attachment = $this->attachment;
                    $pitchModel->save();
                }
            } else {
                if (is_array($this->attachment)) {
                    $this->attachment = implode(',', $this->attachment);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * 根据条件获取记录
     *
     **/
    public static function getAttachmentByParams($pitch_id, $sid)
    {
        if (!$pitch_id) {
            return false;
        }
        if (!$sid) {
            return false;
        }
        $where['sid'] = $sid;
        $where['pitch_id'] = $pitch_id;
        $result = self::find()->where($where)->asArray()->one();
        if ($result) {
            return $result;
        }
        return false;
    }
}
