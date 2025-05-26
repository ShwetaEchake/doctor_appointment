<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%doctor_clinic}}`.
 */
class m250522_091904_create_doctor_clinic_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%doctor_clinic}}', [
            'doctor_id' => $this->integer()->notNull(),
            'clinic_id' => $this->integer()->notNull(),
            'PRIMARY KEY(doctor_id, clinic_id)',
        ]);

       $this->addForeignKey(
            'fk-doctor_clinic-doctor_id',
            '{{%doctor_clinic}}',
            'doctor_id',
            '{{%users}}',   // <-- change from doctors to users
            'id',
            'CASCADE',
            'CASCADE'
        );


        $this->addForeignKey(
            'fk-doctor_clinic-clinic_id',
            '{{%doctor_clinic}}',
            'clinic_id',
            '{{%clinics}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%doctor_clinic}}');
    }
}
