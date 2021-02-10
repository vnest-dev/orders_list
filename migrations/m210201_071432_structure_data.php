<?php

use yii\db\Migration;

/**
 * Class m210201_071432_structure_data
 */
class m210201_071432_structure_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute(file_get_contents(__DIR__ . '/dumps/test_db_structure.sql'));
        $this->execute(file_get_contents(__DIR__ . '/dumps/test_db_data.sql'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('orders');
        $this->dropTable('services');
        $this->dropTable('users');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210201_071432_structure_data cannot be reverted.\n";

        return false;
    }
    */
}
