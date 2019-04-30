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
            'player' => Yii::t('question','player'),
            'start_date' => Yii::t('question','start_date'),
            'created_at' => Yii::t('question','created_at'),
            'updated_at' => Yii::t('question','updated_at'),
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
            [['title', 'desc','player'], 'required'],
            ['start_date','safe'],
        ];
    }


    public function getAnswers()
    {
         return $this->hasMany(Answer::className(), ['id' => 'answer_id'])
            ->viaTable('question_answer', ['question_id' => 'id'])->asArray();
    }

    /**
     * Name: beforeSave
     * User: aimer
     * Date: 2019/4/30
     * Time: 下午4:25
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) { // 新增操作
                //player 进行操作
                if (is_array($this->player)) {
                    $this->player = implode(',', $this->player);
                }

            } else {
                //player 进行操作
                if (is_array($this->player)) {
                    $this->player = implode(',', $this->player);
                }
            }
            return true;
        } else {
            return false;
        }
    }
}