<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m250521_113300_create_users_table extends Migration
{
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
             'role' => $this->string()->defaultValue('user'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);


    }

    public function down()
    {
        $this->dropTable('users');
    }
}
