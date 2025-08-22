<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%experiments}}`.
 */
class m250128_000002_create_experiments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%experiments}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'correct_sequence' => $this->text()->notNull(), // JSON array of 20 shape IDs
            'user_sequence' => $this->text(), // JSON array of user's guesses
            'correct_count' => $this->integer()->defaultValue(0),
            'current_trial' => $this->integer()->defaultValue(1),
            'is_completed' => $this->boolean()->defaultValue(false),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'completed_at' => $this->timestamp()->null(),
        ]);

        // Add foreign key for user_id
        $this->addForeignKey(
            'fk-experiments-user_id',
            'experiments',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-experiments-user_id', 'experiments');
        $this->dropTable('{{%experiments}}');
    }
}