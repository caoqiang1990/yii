<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use backend\models\Template;

/**
 * Signup form
 */
class TemplateAnswer extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id','answer_id'], 'required'],

        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%template_answer}}';
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


    public function getByQuestionId($template_id)
    {
        if (!$template_id) {
            return false;
        }
        $where = ['template_id' => $template_id];
        $list = $this->hasOne(Template::className(), ['id' => 'template_id'])->where($where)->all();
        //->select('id,question_id,answer_id')->where($where)->asArray()->all();
        var_dump($list);die;
    }

}
