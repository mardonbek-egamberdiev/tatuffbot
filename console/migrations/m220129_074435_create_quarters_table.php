<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quarters}}`.
 */
class m220129_074435_create_quarters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quarters}}', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(),
            'status'=>$this->integer(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer(),
            'created_by'=>$this->integer(),
            'updated_by'=>$this->integer(),
        ]);
        $this->createIndex('quarters_created_by_index','{{%quarters}}','created_by');
        $this->createIndex('quarters_updated_by_index','{{%quarters}}','updated_by');
        $this->addForeignKey('quarters_created_by','{{%quarters}}','created_by','{{%user}}','id','CASCADE','CASCADE');
        $this->addForeignKey('quarters_updated_by','{{%quarters}}','updated_by','{{%user}}','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('quarters_created_by','{{%quarters}}');
        $this->dropForeignKey('quarters_updated_by','{{%quarters}}');
        $this->dropTable('{{%quarters}}');
    }
}
