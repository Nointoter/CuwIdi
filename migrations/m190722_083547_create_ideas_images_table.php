<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ideas_images}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%ideas}}`
 */
class m190722_083547_create_ideas_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ideas_images}}', [
            'id_ideas_images' => $this->primaryKey(),
            'images_name' => $this->string(),
            'ideas_id' => $this->integer(),
        ]);

        // creates index for column `ideas_id`
        $this->createIndex(
            '{{%idx-ideas_images-ideas_id}}',
            '{{%ideas_images}}',
            'ideas_id'
        );

        // add foreign key for table `{{%ideas}}`
        $this->addForeignKey(
            '{{%fk-ideas_images-ideas_id}}',
            '{{%ideas_images}}',
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
            '{{%fk-ideas_images-ideas_id}}',
            '{{%ideas_images}}'
        );

        // drops index for column `ideas_id`
        $this->dropIndex(
            '{{%idx-ideas_images-ideas_id}}',
            '{{%ideas_images}}'
        );

        $this->dropTable('{{%ideas_images}}');
    }
}
