<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%article}}".
 **/
class AdminLog extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_log}}';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'=>'操作记录ID',
            'title'=>'操作记录描述',
            'addtime'=>'记录时间',
            'admin_name'=>'操作人姓名',
            'admin_ip'=>'操作人IP地址',
            'admin_agent'=>'操作人浏览器代理商',
            'controller'=>'操作控制器名称',
            'action'=>'操作类型',
            'objId'=>'操作数据编号',
            'result'=>'操作结果',
        ];
    }



    public static function saveLog($controller,$action,$result,$objId,$original=''){

        $model = new self;
        $model->admin_ip = Yii::$app->request->userIP;
        $headers = Yii::$app->request->headers;
        $model->addtime = time();
        if ($headers->has('User-Agent')) {
            $model->admin_agent =  $headers->get('User-Agent');
        }
        $model->admin_id = Yii::$app->user->identity->id;
        $model->admin_name = Yii::$app->user->identity->email;

        $controllers = ['suppliertrade','suppliertype','suppliercategory','supplierlevel','category','banner','exchange','user','admin','supplier','pitch'];
        if(!in_array(strtolower($controller),$controllers)) $controller = '';
        $actions = ['create','update','delete','login','logout'];
        if(!in_array(strtolower($action),$actions))$action = '';

        $model->controller = $controller;
        $model->action = $action;
        $model->result = $result;
        $model->objId = $objId;
        $model->title =  $model->admin_name.' '.$model->action.' '.$model->controller;
        $model->original = $original;
        $model->save(false);

    }
}