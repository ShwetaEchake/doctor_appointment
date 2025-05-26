<?php

use yii\db\Migration;

class m250522_090954_doctor_holidays extends Migration
{
   public function up()
    {
        $this->createTable('doctor_holidays', [
            'id' => $this->primaryKey(),
            'doctor_id' => $this->integer()->notNull(),
            'holiday_date' => $this->date()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('doctor_holidays');
    }
}
