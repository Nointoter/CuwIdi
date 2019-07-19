<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%projects}}`.
 */
class m190710_054126_create_projects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%projects}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
            'info' => Schema::TYPE_TEXT,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%projects}}');
    }
}
