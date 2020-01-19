<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use backend\models\Question;

/**
 * Signup form
 */
class QuestionAnswer extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'answer_id'], 'required'],

        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%question_answer}}';
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


    public function getByQuestionId($question_id)
    {
        if (!$question_id) {
            return false;
        }
        $where = ['question_id' => $question_id];
        $list = $this->hasOne(Question::className(), ['id' => 'question_id'])->where($where)->all();
        //->select('id,question_id,answer_id')->where($where)->asArray()->all();
        var_dump($list);
        die;
    }

}
