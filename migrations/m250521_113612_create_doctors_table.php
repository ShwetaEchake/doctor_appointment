<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%doctors}}`.
 */
class m250521_113612_create_doctors_table extends Migration
{
   
    public function up()
    {
        $this->createTable('doctors', [
             'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'specialization' => $this->string()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('doctors');
    }
}
