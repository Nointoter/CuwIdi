<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%ideas}}`
 * - `{{%users}}`
 */
class m190722_084306_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id_comments' => $this->primaryKey(),
            'comment' => $this->text(),
            'ideas_id' => $this->integer(),
            'users_id' => $this->integer(),
        ]);

        // creates index for column `ideas_id`
        $this->createIndex(
            '{{%idx-comments-ideas_id}}',
            '{{%comments}}',
            'ideas_id'
        );

        // add foreign key for table `{{%ideas}}`
        $this->addForeignKey(
            '{{%fk-comments-ideas_id}}',
            '{{%comments}}',
            'ideas_id',
            '{{%ideas}}',
            'id_ideas',
            'CASCADE'
        );

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-comments-users_id}}',
            '{{%comments}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-comments-users_id}}',
            '{{%comments}}',
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
            '{{%fk-comments-ideas_id}}',
            '{{%comments}}'
        );

        // drops index for column `ideas_id`
        $this->dropIndex(
            '{{%idx-comments-ideas_id}}',
            '{{%comments}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-comments-users_id}}',
            '{{%comments}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-comments-users_id}}',
            '{{%comments}}'
        );

        $this->dropTable('{{%comments}}');
    }
}
