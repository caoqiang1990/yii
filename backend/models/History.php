<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%history}}".
 **/
class History extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%history}}';
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
            'id'=>'记录ID',
            'object_id'=>'关联id',
            'desc'=>'记录描述',
            'original'=>'修改前',
            'result'=>'修改后',
            'field'=>'字段',
            'created_by'=>'添加操作人员',
            'updated_by'=>'修改操作人员',
            'created_at'=>'添加时间',
            'updated_at'=>'修改时间',
        ];
    }

    /**
     * 历史记录
     * @param  [type] $object_id [description]
     * @param  [type] $field     [description]
     * @param  [type] $original  [description]
     * @param  [type] $result    [description]
     * @param  string $desc      [description]
     * @return [type]            [description]
     */
    public static function history($object_id ,$field,$original,$result,$desc=''){
        $model = new self;
        $model->object_id = $object_id;
        $model->field = $field;
        $model->original = $original;
        $model->result = $result;
        $model->desc = $desc;
        $model->save(false);
    }

}