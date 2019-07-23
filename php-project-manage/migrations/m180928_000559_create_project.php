<?php

use yii\db\Migration;

/**
 * Class m180928_000559_create_project
 */
class m180928_000559_create_project extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("project", [
            "id" => $this->primaryKey()->unsigned(),
            "name" => $this->string(32)->notNull()->comment("项目名称"),
            "status" => $this->integer()->notNull()->comment("状态"),
            "remark" => $this->text()->notNull()->comment("备注"),
            "last_user_id" => $this->integer()->notNull()->comment("上次修改人id"),
            "update_time" => $this->integer()->notNull()->comment("上次修改时间"),
            "create_time" => $this->integer()->notNull()->comment("创建时间")
        ], "CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT = '优先级配置表'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("project");
    }
}
