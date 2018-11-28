<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%images}}".
 *
 * @property integer $id
 * @property string $url
 * @property integer $create_time
 * @property string $module
 * @property integer $status
 */
class Images extends ActiveRecord
{
    // public $imageFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%images}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'create_time'], 'required'],
            [['created_at', 'status'], 'integer'],
            [['url'], 'string', 'max' => 255],
            [['module'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => '图片路径',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'module' => '模块',
            'status' => '状态',
        ];
    }


    public function getImageByID($id)
    {
        if (!$id) {
            return false;
        }
        $where['id'] = $id;
        $info = self::find()->where($where)->one();
        return $info;
    }

}