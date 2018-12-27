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
            ['enterprise_code', 'required'],
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
     
            $supplier->scenario = 'admin-add';
            $supplier->name = $this->name;
            $supplier->enterprise_code_desc = $this->enterprise_code;
            if ($supplier->save()) {
                return $supplier;
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
