<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use backend\models\TemplateAnswer;

/**
 * This is the model class for table "{{%answer}}".
 **/
class Answer extends ActiveRecord
{
    public $template_id;

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
            'id' => Yii::t('answer', 'id'),
            'title' => Yii::t('answer', 'title'),
            'desc' => Yii::t('answer', 'desc'),
            'type' => Yii::t('answer', 'type'),
            'answers' => Yii::t('answer', 'answers'),
            'options' => Yii::t('answer', 'options'),
            'created_at' => Yii::t('answer', 'created_at'),
            'updated_at' => Yii::t('answer', 'updated_at'),
            'weight' => Yii::t('answer', 'weight'),
            'answers_1' => Yii::t('answer', 'answers_1'),
            'answers_2' => Yii::t('answer', 'answers_2'),
            'answers_3' => Yii::t('answer', 'answers_3'),
            'options_1' => Yii::t('answer', 'options_1'),
            'options_2' => Yii::t('answer', 'options_2'),
            'options_3' => Yii::t('answer', 'options_3'),

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
            [['title', 'desc', 'weight','options_1', 'options_2', 'options_3'], 'required'],
            [['template_id'], 'safe'],
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
            if ($this->template_id) {
                $model = new TemplateAnswer();
                $model->template_id = $this->template_id;
                $model->answer_id = $this->id;
                $model->save();
            }
        }
    }

    /**
     * Name: getResultByParams
     * User: aimer
     * Date: 2019/5/24
     * Time: 下午3:26
     * @param $answer_id
     * @param $result
     */
    public function getResultByParams($answer_id = '', $result = '')
    {
        if (!$answer_id) {
            return false;
        }
        if (!$result) {
            return false;
        }
        $where['id'] = $answer_id;

    }

    /**
     * 根据id获取选项
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public static function getById($id = '')
    {
        if (!$id) {
            return false;
        }
        $answer = self::find()->where(['id' => $id])->one();
        return $answer ? $answer : false;
    }
}