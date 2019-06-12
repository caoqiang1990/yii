<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 *
 *
 */
class QuestionRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id','answer_id','result'], 'required'],

        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%question_record}}';
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
     * Name: addQuestionRecord
     * User: aimer
     * Date: 2019/6/3
     * Time: 上午8:51
     * @param $records
     * @return bool
     */
    public function addQuestionRecord($records)
    {
        if (empty($records)) {
            return false;
        }
        Yii::$app->db->createCommand()->batchInsert(QuestionRecord::tableName(), ['question_id', 'answer_id','result','ratio','created_by','updated_by','created_at','updated_at'], $records)->execute();
    }

    /**
     * Name: getByQuestionId
     * User: aimer
     * Date: 2019/6/3
     * Time: 上午8:51
     * @param $question_id
     * @return bool
     */
    public function getByQuestionId($question_id)
    {
        if (!$question_id) {
            return false;
        }
        $where = ['question_id' => $question_id];
        $list = $this->hasOne(Question::className(), ['id' => 'question_id'])->where($where)->all();
        //->select('id,question_id,answer_id')->where($where)->asArray()->all();
        var_dump($list);die;
    }

    /**
     * Name: getQuestionRecordById
     * User: aimer
     * Date: 2019/6/3
     * Time: 上午8:51
     * @param $question_id
     * @return array|bool|ActiveRecord[]
     */
    public static function getQuestionRecordById($question_id)
    {
        if (!$question_id) {
            return false;
        }
        $where['question_id'] = $question_id;
        $lists = self::find()->where($where)->all();
        return $lists;
    }

    /**
     * Name: hasQuestionRecord
     * User: aimer
     * Date: 2019/6/3
     * Time: 上午9:03
     * @param string $question_id
     * @param string $user_id
     * @return bool
     */
    public function hasQuestionRecord($question_id='',$user_id='')
    {
        if (!$question_id) {
            return false;
        }
        if (!$user_id) {
            return false;
        }
        $where['question_id'] = $question_id;
        $where['created_by'] = $user_id;
        $result = $this->find()->where($where)->all();
        if (empty($result)) {
            return false;
        }
        return true;
    }

}
