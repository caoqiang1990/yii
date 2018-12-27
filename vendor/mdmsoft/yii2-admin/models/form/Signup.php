<?php
namespace mdm\admin\models\form;

use Yii;
use mdm\admin\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class Signup extends Model
{
    public $username;
    public $email;
    public $password;
    public $truename;
    public $department;
    public $mobile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['mobile','required'],
            ['mobile','match','pattern'=>'/^1[345678]\d{9}$/','message'=>'联系人手机号格式不正确！'],
            ['department','required'],
            ['truename', 'required'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->mobile = $this->mobile;
            $user->department = $this->department;
            $user->truename = $this->truename;
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
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
            'id' => Yii::t('rbac-admin','ID'),
            'username' => Yii::t('rbac-admin','Username'),
            'created_at' => Yii::t('rbac-admin','Created At'),
            'email' => Yii::t('rbac-admin','Email'),
            'status' => Yii::t('rbac-admin','Status'),
            'mobile' => Yii::t('rbac-admin','mobile'),
            'department' => Yii::t('rbac-admin','department'),
            'truename' => Yii::t('rbac-admin','truename'),
        ];
    }    
}
