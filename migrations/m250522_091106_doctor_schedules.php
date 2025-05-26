<?php

use yii\db\Migration;

class m250522_091106_doctor_schedules extends Migration
{
    public function up()
    {
        $this->createTable('doctor_schedules', [
            'id' => $this->primaryKey(),
            'doctor_id' => $this->integer()->notNull(),
            'day_of_week' => $this->integer()->notNull(),
            'start_time' => $this->time()->notNull(),
            'end_time' => $this->time()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('doctor_schedules');
    }
}
