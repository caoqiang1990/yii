<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use backend\models\Answer;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%question}}".
 **/
class Question extends ActiveRecord
{
    const SCENARIO_UPLOAD = 'upload';
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';
    const SCENARIO_FINISH = 'finish';

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
            'id' => Yii::t('question', 'id'),
            'title' => Yii::t('question', 'title'),
            'desc' => Yii::t('question', 'desc'),
            'player' => Yii::t('question', 'player'),
            'sid' => Yii::t('question', 'sid'),
            'status' => Yii::t('question', 'status'),
            'type' => Yii::t('question', 'type'),
            'start_date' => Yii::t('question', 'start_date'),
            'end_date' => Yii::t('question', 'end_date'),
            'created_at' => Yii::t('question', 'created_at'),
            'updated_at' => Yii::t('question', 'updated_at'),
        ];
    }

    /**
     * 场景
     * @return [type] [description]
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => [
                'title', 'desc', 'player', 'sid', 'type', 'start_date', 'end_date', 'template_id'
            ],
            self::SCENARIO_EDIT => [
                'title', 'desc', 'player', 'sid', 'type', 'start_date', 'end_date', 'status', 'template_id'
            ],

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
            [['title', 'desc', 'player', 'sid', 'type', 'template_id'], 'required'],
            [['start_date', 'end_date'], 'safe'],
        ];
    }


    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['id' => 'answer_id'])
            ->viaTable('template_answer', ['template_id' => 'id'])->asArray();
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

    /**
     * 获取key-value键值对
     * @return [type] [description]
     */
    public static function getQuestion()
    {
        $question = self::find()->all();
        $list = ArrayHelper::map($question, 'id', 'title');
        return $list;
    }

    /**
     * Name: getTemplateIdByParams
     * User: aimer
     * Date: 2019/9/29
     * Time: 下午1:43
     * @param array $params
     * @return array|bool
     */
    public function getTemplateIdByParams($params = [])
    {
        if (empty($params)) {
            return false;
        }
        $where['created_by'] = $params['user_id'];
        $list = self::find()->select('id')->where($where)->asArray()->all();
        return $list ? array_column($list, 'id') : false;
    }

    /**
     * 根据id获取评价
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public static function getQuestionById($id = '')
    {
        if (!$id) {
            return false;
        }
        $info = self::find()->where(['id' => $id])->one();
        return $info ? $info : false;
    }
}