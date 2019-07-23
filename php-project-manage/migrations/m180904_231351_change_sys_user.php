<?php

use yii\db\Migration;

/**
 * Class m180904_231351_change_sys_user
 */
class m180904_231351_change_sys_user extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->renameColumn("sys_user", "charset", "language");
        $this->addColumn("sys_user", "real_name", $this->string(20)->notNull()->defaultValue("")->comment("真实姓名")->after("password"));
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->renameColumn("sys_user", "language", "charset");
        $this->dropColumn("sys_user", "real_name");
    }
}
