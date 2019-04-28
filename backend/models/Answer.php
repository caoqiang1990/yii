<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use backend\models\QuestionAnswer;
/**
 * This is the model class for table "{{%answer}}".
 **/
class Answer extends ActiveRecord
{
    public $object_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%answer}}';
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
            'id' => Yii::t('answer','id'),
            'title' => Yii::t('answer','title'),
            'desc' => Yii::t('answer','desc'),
            'type' => Yii::t('answer','type'),
            'answers' => Yii::t('answer','answers'),
            'options' => Yii::t('answer','options'),
            'created_at' => Yii::t('answer','created_at'),
            'updated_at' => Yii::t('answer','updated_at'),
            'ratio' => Yii::t('answer','ratio'),
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
            [['title', 'desc','ratio'], 'required'],
            ['object_id','safe'],
            ['ratio','integer'],
        ];
    }

    /**
    * @param bool $insert
    * @param array $changedAttributes
    */
    public function afterSave($insert, $changedAttributes)
    {
        //新增
        if ($insert) {
            if ($this->object_id) {
                $model = new QuestionAnswer();
                $model->question_id = $this->object_id;
                $model->answer_id = $this->id;
                $model->save();
            }
        }
    }

}