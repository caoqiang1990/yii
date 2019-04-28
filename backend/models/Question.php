<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use backend\models\Answer;
/**
 * This is the model class for table "{{%question}}".
 **/
class Question extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%question}}';
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
            'id' => Yii::t('question','id'),
            'title' => Yii::t('question','title'),
            'desc' => Yii::t('question','desc'),
            'type' => Yii::t('question','type'),
            'answers' => Yii::t('question','answers'),
            'options' => Yii::t('question','options'),
            'created_at' => Yii::t('question','created_at'),
            'updated_at' => Yii::t('question','updated_at'),
            'start_date' => Yii::t('question','start_date'),
            'type' => Yii::t('question','type'),

        ];
    }

    /**
     *
     * 验证规则
     *
     */
    public function rules()
    {
        return [
            [['title', 'desc'], 'required'],
            ['start_date','safe'],
        ];
    }


    public function getAnswers()
    {
         return $this->hasMany(Answer::className(), ['id' => 'answer_id'])
            ->viaTable('question_answer', ['question_id' => 'id'])->asArray();
    }
}