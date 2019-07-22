<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ideas_tags}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%ideas}}`
 */
class m190722_085618_create_ideas_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ideas_tags}}', [
            'id_ideas_tags' => $this->primaryKey(),
            'tag' => $this->string(),
            'ideas_id' => $this->integer(),
        ]);

        // creates index for column `ideas_id`
        $this->createIndex(
            '{{%idx-ideas_tags-ideas_id}}',
            '{{%ideas_tags}}',
            'ideas_id'
        );

        // add foreign key for table `{{%ideas}}`
        $this->addForeignKey(
            '{{%fk-ideas_tags-ideas_id}}',
            '{{%ideas_tags}}',
            'ideas_id',
            '{{%ideas}}',
            'id_ideas',
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
            '{{%fk-ideas_tags-ideas_id}}',
            '{{%ideas_tags}}'
        );

        // drops index for column `ideas_id`
        $this->dropIndex(
            '{{%idx-ideas_tags-ideas_id}}',
            '{{%ideas_tags}}'
        );

        $this->dropTable('{{%ideas_tags}}');
    }
}
