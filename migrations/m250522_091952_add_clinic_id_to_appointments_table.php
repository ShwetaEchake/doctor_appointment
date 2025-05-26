<?php

use yii\db\Migration;

class m250522_091952_add_clinic_id_to_appointments_table extends Migration
{
     public function up()
    {
        $this->addColumn('appointments', 'clinic_id', $this->integer()->notNull());

        // Add foreign key constraint
        $this->addForeignKey(
            'fk-appointments-clinic_id',
            'appointments',
            'clinic_id',
            'clinics',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-appointments-clinic_id', 'appointments');
        $this->dropColumn('appointments', 'clinic_id');
    }
}
