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
            'username' => $this->string(),
            'password' => $this->string(),
            'users_info' => $this->string(),
            'users_image' => $this->string(),
            'users_role' => $this->string(),
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
