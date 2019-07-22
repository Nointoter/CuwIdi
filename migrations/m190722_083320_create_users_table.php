<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m190722_083320_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id_users' => $this->primaryKey(),
            'users_name' => $this->string(),
            'login' => $this->string(),
            'password' => $this->string(),
            'users_info' => $this->text(),
            'users_image' => $this->integer(),
            'users_role' => $this->string(),
            'users_tags' => $this->integer(),
            'users_comments' => $this->integer(),
            'users_ideas' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
