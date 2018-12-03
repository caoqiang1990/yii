<?php

use yii\db\Migration;

use yii\db\Schema;
/**
 * Class m181203_052519_admin_log
 */
class m181203_052519_admin_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="后台操作记录"';
        }

        $this->createTable('{{%admin_log}}', [
            //'name'=>Schema::TYPE_STRING.'(200) PRIMARY KEY NOT NULL',
            'id'=>Schema::TYPE_PK,
            'admin_id'=>Schema::TYPE_INTEGER.'(10) UNSIGNED NOT NULL COMMENT "操作用户ID"',
            'admin_name'=>Schema::TYPE_STRING.'(200) NOT NULL COMMENT "操作用户名"',
            'addtime'=>Schema::TYPE_INTEGER.'(10) NOT NULL COMMENT "记录时间"',
            'admin_ip'=>Schema::TYPE_STRING.'(200) NOT NULL COMMENT "操作用户IP"',
            'admin_agent'=>Schema::TYPE_STRING.'(200) NOT NULL COMMENT "操作用户浏览器代理商"',
            'title'=>Schema::TYPE_STRING.'(200) NOT NULL COMMENT "记录描述"',
            'model'=>Schema::TYPE_STRING.'(200) NOT NULL COMMENT "操作模块（例：文章）"',
            'type'=>Schema::TYPE_STRING.'(200) NOT NULL COMMENT "操作类型（例：添加）"',
            'handle_id'=>Schema::TYPE_INTEGER.'(10) NOT NULL COMMENT "操作对象ID"',
            'result'=>Schema::TYPE_TEXT.' NOT NULL COMMENT "操作结果"',
            'describe'=>Schema::TYPE_TEXT.' NOT NULL COMMENT "备注"',

        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181203_052519_admin_log cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181203_052519_admin_log cannot be reverted.\n";

        return false;
    }
    */
}
