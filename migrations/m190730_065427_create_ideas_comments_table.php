<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ideas_comments}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%ideas}}`
 * - `{{%users}}`
 */
class m190730_065427_create_ideas_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ideas_comments}}', [
            'id_comments' => $this->primaryKey(),
            'comment' => $this->string(),
            'ideas_id' => $this->integer(),
            'users_id' => $this->integer(),
        ]);

        // creates index for column `ideas_id`
        $this->createIndex(
            '{{%idx-ideas_comments-ideas_id}}',
            '{{%ideas_comments}}',
            'ideas_id'
        );

        // add foreign key for table `{{%ideas}}`
        $this->addForeignKey(
            '{{%fk-ideas_comments-ideas_id}}',
            '{{%ideas_comments}}',
            'ideas_id',
            '{{%ideas}}',
            'id_ideas',
            'CASCADE'
        );

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-ideas_comments-users_id}}',
            '{{%ideas_comments}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-ideas_comments-users_id}}',
            '{{%ideas_comments}}',
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
        // drops foreign key for table `{{%ideas}}`
        $this->dropForeignKey(
            '{{%fk-ideas_comments-ideas_id}}',
            '{{%ideas_comments}}'
        );

        // drops index for column `ideas_id`
        $this->dropIndex(
            '{{%idx-ideas_comments-ideas_id}}',
            '{{%ideas_comments}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-ideas_comments-users_id}}',
            '{{%ideas_comments}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-ideas_comments-users_id}}',
            '{{%ideas_comments}}'
        );

        $this->dropTable('{{%ideas_comments}}');
    }
}
