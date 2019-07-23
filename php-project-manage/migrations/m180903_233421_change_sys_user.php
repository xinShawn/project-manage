<?php

use yii\db\Migration;

/**
 * Class m180903_233421_change_sys_user
 */
class m180903_233421_change_sys_user extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn("sys_user", "last_login_time", $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("上次登录时间")->after("nickname"));
        
        $this->addColumn("sys_user", "last_login_ip", $this->string(24)->notNull()->defaultValue("")->comment("上次登录id")->after("nickname"));
        
        $this->addColumn("sys_user", "auth_code", $this->string(64)->notNull()->defaultValue("")->comment("登录授权码。cookie 保存，用于快速登录")->after("nickname"));
        
        $this->addColumn("sys_user", "auth_code_dead_time", $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("登录授权码有效期")->after("auth_code"));
        
        $this->addColumn("sys_user", "charset", $this->string("8")->notNull()->defaultValue("")->comment("语言。如：zh-CN,en-US")->after("nickname"));
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn("sys_user", "last_login_time");
        $this->dropColumn("sys_user", "last_login_ip");
        $this->dropColumn("sys_user", "auth_code");
        $this->dropColumn("sys_user", "auth_code_dead_time");
        $this->dropColumn("sys_user", "charset");
    }
}
