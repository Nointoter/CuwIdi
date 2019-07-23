<?php

use yii\db\Migration;

/**
 * Handles adding date to table `{{%ideas}}`.
 */
class m190723_054309_add_date_column_to_ideas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ideas}}', 'creations_day', $this->string());
        $this->addColumn('{{%ideas}}', 'creations_month', $this->string());
        $this->addColumn('{{%ideas}}', 'creations_year', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%ideas}}', 'creations_day');
        $this->dropColumn('{{%ideas}}', 'creations_month');
        $this->dropColumn('{{%ideas}}', 'creations_year');
    }
}
