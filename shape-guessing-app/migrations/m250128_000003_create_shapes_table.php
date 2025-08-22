<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shapes}}`.
 */
class m250128_000003_create_shapes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shapes}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'image_path' => $this->string()->notNull(),
        ]);

        // Insert default shapes
        $this->insert('{{%shapes}}', [
            'id' => 1,
            'name' => 'circle',
            'image_path' => '/images/circle.svg'
        ]);
        
        $this->insert('{{%shapes}}', [
            'id' => 2,
            'name' => 'triangle',
            'image_path' => '/images/triangle.svg'
        ]);
        
        $this->insert('{{%shapes}}', [
            'id' => 3,
            'name' => 'square',
            'image_path' => '/images/square.svg'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shapes}}');
    }
}