<?php

use yii\db\Migration;

/**
 * Class m180825_014010_create_sys_user_and_sys_group
 */
class m180825_014010_create_sys_user_and_sys_group extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable("sys_group", [
            "id" => $this->primaryKey()->unsigned(),
            "name" => $this->string("32")->notNull()->comment("组名"),
            "create_time" => $this->integer()->unsigned()->notNull()->comment("创建时间")
        ], "CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT = '系统用户表'");

        $this->createTable("sys_user", [
            "id" => $this->primaryKey()->unsigned(),
            "group_id" => $this->integer()->unsigned()->notNull()->comment("组id"),
            "account" => $this->string(32)->notNull()->comment("登录账号"),
            "password" => $this->char(32)->notNull()->comment("登录密码的md5值"),
            "nickname" => $this->string(20)->notNull()->defaultValue('')->comment("用户昵称"),
            "create_time" => $this->integer()->unsigned()->notNull()->comment("创建时间")
        ], "CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT = '系统用户表'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable("sys_group");
        $this->dropTable("sys_user");
    }
}
