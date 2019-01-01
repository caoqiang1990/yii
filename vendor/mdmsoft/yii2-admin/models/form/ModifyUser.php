<?php

namespace mdm\admin\models\form;

use Yii;
use mdm\admin\models\User;
use yii\base\Model;
use yii\helpers\FileHelper;

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
    public $head_url;
    public $imageFile;

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
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => '*', 'on' => 'image'],
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
            $user->head_url = $this->head_url;
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

    public function upload($type)
    {
        if ($this->validate()) {
            $path = \Yii::getAlias('@uploadPath') . '/' . date("Ymd");
            if (!is_dir($path) || !is_writable($path)) {
                FileHelper::createDirectory($path, 0777, true);
            }
            $filePath = $path . '/' . \Yii::$app->request->post('model', '') . '_' . md5(uniqid() . mt_rand(10000, 99999999)) . '.' . $this->{$type}->extension;

            if ($this->{$type}->saveAs($filePath)) {
                //如果上传成功，保存附件信息到数据库。TODO
            }
            return $filePath;
        } else {
            return false;
        }
    }    

    public function parseImageUrl($filePath)
    {
        if (strpos($filePath, Yii::getAlias('@uploadPath')) !== false) {
            $url =  Yii::$app->params['assetDomain'] . str_replace(Yii::getAlias('@uploadPath'), '', $filePath);
            return $url;
        } else {
            return $filePath;
        }
    }    
}
