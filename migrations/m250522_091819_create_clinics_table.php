<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clinics}}`.
 */
class m250522_091819_create_clinics_table extends Migration
{
     public function up()
    {
        $this->createTable('{{%clinics}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'address' => $this->string(),
            'contact_number' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%clinics}}');
    }
}
