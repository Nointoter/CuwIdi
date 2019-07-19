<?php

use yii\db\Migration;

/**
 * Handles adding images_name to table `{{%projects}}`.
 */
class m190716_103213_add_images_name_column_to_projects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%projects}}', 'images_name', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%projects}}', 'images_name');
    }
}
