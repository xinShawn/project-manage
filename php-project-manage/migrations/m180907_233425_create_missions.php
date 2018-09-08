<?php

use yii\db\Migration;

/**
 * Class m180907_233425_create_missions
 */
class m180907_233425_create_missions extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable("cfg_priority", [
            "id" => $this->primaryKey()->unsigned(),
            "name" => $this->string(4)->notNull()->comment("优先级名称：如：高级、中级、低级"),
            "order" => $this->tinyInteger()->unsigned()->notNull()->comment("排序优先级。越小越优先"),
            "last_user_id" => $this->integer()->unsigned()->notNull()->comment("上次修改人id"),
            "update_time" => $this->integer()->unsigned()->notNull()->comment("上次更新的时间戳"),
            "create_time" => $this->integer()->unsigned()->notNull()->comment("创建时间")
        ], "CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT = '优先级配置表'");
        $this->createIndex("order", "cfg_priority", "order");
        
        $this->createTable("mission", [
            "id" => $this->primaryKey()->unsigned(),
            "priority_id" => $this->integer()->unsigned()->notNull()->comment("优先级id"),
            "title" => $this->string(255)->notNull()->comment("任务标题"),
            "content" => $this->text()->notNull()->comment("任务详情"),
            "status" => $this->tinyInteger()->notNull()->defaultValue(0)->comment("任务状态。0:未开始 10:进行中 20:暂停 30:已完成 40:已关闭 -10:已取消"),
            "end_time" => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("截止时间戳"),
            "finish_user_id" => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("完成人id"),
            "create_user_id" => $this->integer()->unsigned()->notNull()->comment("创建人id"),
            "last_user_id" => $this->integer()->unsigned()->notNull()->comment("上次修改人id"),
            "update_time" => $this->integer()->unsigned()->notNull()->comment("上次更新的时间戳"),
            "create_time" => $this->integer()->unsigned()->notNull()->comment("创建时间"),
        ], "CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT = '任务记录表'");
        $this->createIndex("priority_id", "mission", "priority_id");
        $this->createIndex("status", "mission", "status");
        $this->createIndex("end_time", "mission", "end_time");
        $this->createIndex("finish_user_id", "mission", "finish_user_id");
        $this->createIndex("create_user_id", "mission", "create_user_id");
        $this->createIndex("update_time", "mission", "update_time");
        $this->createIndex("create_time", "mission", "create_time");
        
        $this->createTable("rel_mission_user", [
            "id" => $this->primaryKey()->unsigned(),
            "mission_id" => $this->integer()->unsigned()->notNull()->comment("任务id"),
            "user_id" => $this->integer()->unsigned()->notNull()->comment("用户id"),
        ], "CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT = '指派关系表'");
        $this->createIndex("mission_id", "rel_mission_user", "mission_id");
        $this->createIndex("user_id", "rel_mission_user", "user_id");
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable("cfg_priority");
        $this->dropTable("mission");
        $this->dropTable("rel_mission_user");
    }
}
