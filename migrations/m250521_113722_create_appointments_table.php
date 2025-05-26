<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%appointments}}`.
 */
class m250521_113722_create_appointments_table extends Migration
{
 
    public function up()
    {
        $this->createTable('appointments', [
               'id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'doctor_id' => $this->integer()->notNull(),
                'appointment_date' => $this->dateTime()->notNull(),
                'status' => $this->string()->defaultValue('pending'), // 'pending', 'approved', 'cancelled'
                'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
 
    }

    public function down()
    {
        $this->dropTable('appointments');
    }
}

