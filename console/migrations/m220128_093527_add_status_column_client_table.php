<?php

use yii\db\Migration;

/**
 * Class m220128_093527_add_status_column_client_table
 */
class m220128_093527_add_status_column_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%client}}','status',$this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('{{%client}}','status');
    }

}
