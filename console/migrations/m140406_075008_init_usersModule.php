<?php

use yii\db\Schema;
use fourteenmeister\users;
use fourteenmeister\users\helpers\ModuleTrait;

class m140406_075008_init_usersModule extends \yii\db\Migration
{

    use ModuleTrait;

    public function safeUp()
    {
        $tableOptions = null;
        if (Yii::$app->db->driverName == 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable($this->module->tableUser, [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . '(25) NOT NULL',
            'email' => Schema::TYPE_STRING . '(255) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . '(60) NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',

            // confirmation
            'confirmation_token' => Schema::TYPE_STRING . '(32)',
            'confirmation_sent_at' => Schema::TYPE_INTEGER,
            'confirmed_at' => Schema::TYPE_INTEGER,
            'unconfirmed_email' => Schema::TYPE_STRING . '(255)',

            // recovery
            'recovery_token' => Schema::TYPE_STRING . '(32)',
            'recovery_sent_at' => Schema::TYPE_INTEGER,

            // block
            'status' => Schema::TYPE_INTEGER,

            // RBAC
            'role' => Schema::TYPE_STRING . '(255)',

            // trackable
            'registered_from' => Schema::TYPE_INTEGER,
            'logged_in_from' => Schema::TYPE_INTEGER,
            'logged_in_at' => Schema::TYPE_INTEGER,

            // timestamps
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->createTable("{{%{$this->module->tableUserProfile}}}", [
            'user_id' => Schema::TYPE_INTEGER . ' PRIMARY KEY',
            'first_name' => Schema::TYPE_STRING . '(255)',
            'second_name' => Schema::TYPE_STRING . '(255)',
            'third_name' => Schema::TYPE_STRING . '(255)',
            'gravatar_email' => Schema::TYPE_STRING . '(255)',
            'gravatar_id' => Schema::TYPE_STRING . '(32)',
            'bio' => Schema::TYPE_TEXT
        ], $tableOptions);
        $this->addForeignKey('fk_user_profile', "{{%{$this->module->tableUserProfile}}}", 'user_id', "{{%{$this->module->tableUser}}}", 'id');
    }

    public function safeDown()
    {
        $this->dropTable("{{%{$this->module->tableUserProfile}}}");
        $this->dropTable("{{%{$this->module->tableUser}}}");
    }

}