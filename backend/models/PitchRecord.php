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
class PitchRecord extends ActiveRecord
{
    public $attachment_id;
    /**
     * 返回表名
     * @return [type] [description]
     */
    public static function tableName()
    {
        return '{{%pitch_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content','pitch_id'],'safe']
        ];
    }

    /**
     * 对应中文
     * @return [type] [description]
     */
    public function attributeLabels()
    {
        return [
            'content' => '留言'
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

    public static function getPitchRecordByPitchId($id)
    {
        if (!$id) {
            return false;
        }
        $where = ['pitch_id' => $id];
        $records = self::find()->where($where)->asArray()->all();
        return $records;
    }  
}
