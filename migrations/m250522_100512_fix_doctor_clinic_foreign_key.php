<?php

use yii\db\Migration;

class m250522_100512_fix_doctor_clinic_foreign_key extends Migration
{
   
   public function up()
{
    $this->dropForeignKey('fk-doctor_clinic-doctor_id', 'doctor_clinic');

    $this->addForeignKey(
        'fk-doctor_clinic-doctor_id',
        'doctor_clinic',
        'doctor_id',
        'users', 
        'id',
        'CASCADE',
        'CASCADE'
    );
}
   
    public function down()
    {
        echo "m250522_100512_fix_doctor_clinic_foreign_key cannot be reverted.\n";

        return false;
    }
    
}
