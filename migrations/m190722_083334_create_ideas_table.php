<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ideas}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m190722_083334_create_ideas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ideas}}', [
            'id_ideas' => $this->primaryKey(),
            'ideas_name' => $this->string(),
            'info_short' => $this->text(),
            'info_long' => $this->text(),
            'creators_id' => $this->integer(),
            'ideas_images' => $this->integer(),
            'ideas_tags' => $this->integer(),
            'ideas_comments' => $this->integer(),
        ]);

        // creates index for column `creators_id`
        $this->createIndex(
            '{{%idx-ideas-creators_id}}',
            '{{%ideas}}',
            'creators_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-ideas-creators_id}}',
            '{{%ideas}}',
            'creators_id',
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
            '{{%fk-ideas-creators_id}}',
            '{{%ideas}}'
        );

        // drops index for column `creators_id`
        $this->dropIndex(
            '{{%idx-ideas-creators_id}}',
            '{{%ideas}}'
        );

        $this->dropTable('{{%ideas}}');
    }
}
