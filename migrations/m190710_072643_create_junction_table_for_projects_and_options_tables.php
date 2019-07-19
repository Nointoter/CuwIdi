<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%projects_options}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%projects}}`
 * - `{{%options}}`
 */
class m190710_072643_create_junction_table_for_projects_and_options_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%projects_options}}', [
            'options_id' => Schema::TYPE_PK,
            'projects_id' => Schema::TYPE_INTEGER,
            'options_name' => Schema::TYPE_STRING,
            'options_value' => Schema::TYPE_TEXT,
        ]);

        // creates index for column `projects_id`
        $this->createIndex(
            '{{%idx-projects_options-projects_id}}',
            '{{%projects_options}}',
            'projects_id'
        );

        // add foreign key for table `{{%projects}}`
        $this->addForeignKey(
            '{{%fk-projects_options-projects_id}}',
            '{{%projects_options}}',
            'projects_id',
            '{{%projects}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%options}}`
        $this->dropForeignKey(
            '{{%fk-projects_options-options_id}}',
            '{{%projects_options}}'
        );

        // drops index for column `options_id`
        $this->dropIndex(
            '{{%idx-projects_options-options_id}}',
            '{{%projects_options}}'
        );

        $this->dropTable('{{%projects_options}}');
    }
}
