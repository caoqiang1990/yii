<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\Pitch;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 *
 * 比稿记录
 *
 */
class PitchAttachment extends ActiveRecord
{
    /**
     * 返回表名
     * @return [type] [description]
     */
    public static function tableName()
    {
        return '{{%pitch_attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attachment','pitch_id'],'safe']
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
}
