<?php

use yii\db\Migration;

/**
 * Handles dropping ideas_images from table `{{%ideas}}`.
 */
class m190726_060818_drop_ideas_images_column_from_ideas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%ideas}}', 'ideas_images');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%ideas}}', 'ideas_images', $this->string());
    }
}
