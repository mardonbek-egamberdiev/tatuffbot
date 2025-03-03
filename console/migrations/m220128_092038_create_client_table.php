<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client}}`.
 */
class m220128_092038_create_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'street_id' => $this->string(),
            'full_name' => $this->string(),
            'username' => $this->string(),
            'data' => $this->string(),
            'step' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client}}');
    }
}
