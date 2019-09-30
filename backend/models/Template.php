<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "template".
 *
 * @property int $id
 * @property string $name 模板名称
 * @property string $intro 模板描述
 * @property int $created_by 添加人
 * @property int $updated_by 修改人
 * @property int $created_at 添加时间
 * @property int $updated_at 修改时间
 */
class Template extends \yii\db\ActiveRecord
{
    public $count;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template';
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['intro'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('template', 'ID'),
            'name' => Yii::t('template', 'Name'),
            'intro' => Yii::t('template', 'Intro'),
            'created_by' => Yii::t('template', 'Created_By'),
            'updated_by' => Yii::t('template', 'Updated_By'),
            'created_at' => Yii::t('template', 'Created_At'),
            'updated_at' => Yii::t('template', 'Updated_At'),
        ];
    }

    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['id' => 'answer_id'])
            ->viaTable('template_answer', ['template_id' => 'id'])->asArray();
    }


    /**
     * 获取key-value键值对
     * @return [type] [description]
     */
    public static function getTemplates()
    {
        $templates = self::find()->all();
        $template = ArrayHelper::map($templates, 'id', 'name');
        return $template;
    }
}
