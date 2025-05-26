<?php

use yii\db\Migration;

class m250522_091304_add_charge_to_appointments extends Migration
{
    public function up()
    {
        $this->addColumn('appointments', 'charge', $this->decimal(10, 2)->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('appointments', 'charge');
    }
}
