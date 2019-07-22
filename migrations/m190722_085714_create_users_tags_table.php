<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_tags}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m190722_085714_create_users_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_tags}}', [
            'id_users_tags' => $this->primaryKey(),
            'tag' => $this->string(),
            'users_id' => $this->integer(),
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-users_tags-users_id}}',
            '{{%users_tags}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users_tags-users_id}}',
            '{{%users_tags}}',
            'users_id',
            '{{%users}}',
            'id_users',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-users_tags-users_id}}',
            '{{%users_tags}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-users_tags-users_id}}',
            '{{%users_tags}}'
        );

        $this->dropTable('{{%users_tags}}');
    }
}
