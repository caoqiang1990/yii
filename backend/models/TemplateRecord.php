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
class TemplateRecord extends ActiveRecord
{
    public $result_1;
    public $result_2;
    public $result_3;
    public $result_4;
    public $result_5;
    public $count;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'question_id', 'result_1', 'result_2', 'result_3', 'result_4', 'result_5', 'result', 'count'], 'safe'],
            [['reason', 'total', 'operator', 'is_satisfy','department'], 'required'],

        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%template_record}}';
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
     * Name: beforeSave
     * User: aimer
     * Date: 2019/9/27
     * Time: 上午10:52
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                if ($this->count) {
                    $result = [];
                    for ($i = 1; $i <= $this->count; $i++) {
                        $result["result_$i"] = $this->{"result_$i"};
                    }
                    $this->result = serialize($result);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        $result = unserialize($this->result);
        $count = count($result);
        for ($i=1;$i<=$count;$i++) {
            $this->{"result_$i"} = $result["result_$i"];
        }
    }

    /**
     * Name: getByQuestionId
     * User: aimer
     * Date: 2019/6/3
     * Time: 上午8:51
     * @param $question_id
     * @return bool
     */
    public static function getByTemplateId($template_id)
    {
        if (!$template_id) {
            return false;
        }
        $where['template_id'] = $template_id;
        $where['created_by'] = Yii::$app->user->identity->id;
        $one = self::find()->where($where)->one();
        return $one;
    }

    /**
     * Name: getQuestionRecordById
     * User: aimer
     * Date: 2019/6/3
     * Time: 上午8:51
     * @param $question_id
     * @return array|bool|ActiveRecord[]
     */
    public static function getQuestionRecordById($template_id)
    {
        if (!$template_id) {
            return false;
        }
        $where['template_id'] = $template_id;
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
    public function hasTemplateRecord($template_id = '', $user_id = '')
    {
        if (!$template_id) {
            return false;
        }
        if (!$user_id) {
            return false;
        }
        $where['template_id'] = $template_id;
        $where['created_by'] = $user_id;
        $result = $this->find()->where($where)->all();
        if (empty($result)) {
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'operator' => Yii::t('template', 'operator'),
            'total' => Yii::t('template', 'total'),
            'is_satisfy' => Yii::t('template', 'is_satisfy'),
            'reason' => Yii::t('template', 'reason'),
            'department' => Yii::t('template', 'department'),
            'template_id' => Yii::t('template','template_id'),
            'question_id' => Yii::t('template','question_id'),
            'created_at' => Yii::t('template','created_at'),
            'updated_at' => Yii::t('template','updated_at'),
        ];
    }

    /**
     * Name: getTemplateRecordByParams
     * User: aimer
     * Date: 2019/9/29
     * Time: 下午2:08
     * @param array $params
     * @return array|bool|ActiveRecord[]
     */
    public function getTemplateRecordByParams($params = [])
    {
        if (empty($params)) {
            return false;
        }
        $records = self::find()->where($params)->asArray()->all();
        return $records;
    }
}