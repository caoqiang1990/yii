<?php

namespace mdm\admin\models\form;

use Yii;
use mdm\admin\models\User;
use yii\base\Model;

/**
 * Description of ChangePassword
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ModifyUser extends Model
{

    //public $mobile;
    public $truename;
    public $email;
    public $department;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['truename','required'],
            //['mobile','safe'],
            ['email','required'],
            ['department','required'],

        ];
    }

    /**
     * Change password.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function change($id)
    {
        if ($this->validate()) {
            /* @var $user User */
            $user = User::findOne($id);
            $user->truename = $this->truename;
            //$user->mobile = $this->mobile;
            $user->department = $this->department;
            if ($user->save()) {
                return true;
            }
        }

        return false;
    }

    /**
     * 对应中文
     * @return [type] [description]
     */
    public function attributeLabels()
    {
        return [

        ];
    }    
}
