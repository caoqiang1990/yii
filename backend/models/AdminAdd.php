<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\Supplier;

/**
 * Signup form
 */
class AdminAdd extends Model
{
    public $name;
    public $enterprise_code;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            [
                'name','unique','targetClass'=>'backend\models\Supplier','message'=>'供应商名称已经存在'
            ],
            ['enterprise_code', 'required'],
            ['enterprise_code','string','length'=>[18,18],'message'=>'营业执照长度为18位']
        ];
    }

    /**
     * 
     *
     * @return 
     */
    public function add()
    {
        if ($this->validate()) {
            $supplierModel = new Supplier();
     
            $supplierModel->scenario = 'admin-add';
            $supplierModel->name = $this->name;
            $supplierModel->public_flag = 'y';
            $supplierModel->department = Yii::$app->user->identity->department;
            $supplierModel->source = 'add';
            $supplierModel->enterprise_code_desc = $this->enterprise_code;
            $supplierModel->status = 'wait';
            if ($supplierModel->save()) {
                return $supplierModel;
            }
        }
        return null;
    }

    /**
     * 对应中文
     * @return [type] [description]
     */
    public function attributeLabels()
    {
        return [
            'name' => '供应商全称',
            'enterprise_code' => '企业代码',
        ];
    }    
}
