<?php

use yii\db\Migration;

/**
 * Class m181010_000655_change_mission
 */
class m181010_000655_change_mission extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("mission", "project_id", $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("所属项目id")->after("id"));
        $this->createIndex("project_id", "mission", "project_id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("mission", "project_id");
    }
}
