<?php

use yii\db\Migration;

/**
 * Class m220821_170639_add_date_to_comment
 */
class m220821_170639_add_date_to_comment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('comment', 'date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220821_170639_add_date_to_comment cannot be reverted.\n";

        $this->dropColumn("comment", "date");

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220821_170639_add_date_to_comment cannot be reverted.\n";

        return false;
    }
    */
}
