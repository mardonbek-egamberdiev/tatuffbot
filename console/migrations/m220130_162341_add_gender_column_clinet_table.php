<?php

use yii\db\Migration;

/**
 * Class m220130_162341_add_gender_column_clinet_table
 */
class m220130_162341_add_gender_column_clinet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%client}}','gender',$this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%client}}','gender');
    }
}
