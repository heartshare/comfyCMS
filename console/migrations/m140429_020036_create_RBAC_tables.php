<?php

use yii\db\Schema;

class m140429_020036_create_RBAC_tables extends \yii\db\Migration
{

    protected $authManager;

    public function safeUp()
    {
        $itemTable = $this->authManager->itemTable;
        $itemChildTable = $this->authManager->itemChildTable;
        $assignmentTable = $this->authManager->assignmentTable;
        $ruleTable = $this->authManager->ruleTable;
        $this->createTable($ruleTable, [
            'name' => 'varchar(64) NOT NULL PRIMARY KEY',
            'data' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER
        ]);
        $this->createTable($itemTable, [
            'name' => 'varchar(64) NOT NULL PRIMARY KEY',
            'type' => Schema::TYPE_INTEGER . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'rule_name' => 'varchar(64)',
            'data' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER
        ]);
        $this->addForeignKey('FK_AuthItem_AuthRule', $itemTable, 'rule_name', $ruleTable, 'name', 'set null', 'cascade');
        $this->createTable($itemChildTable, [
            'parent' => 'varchar(64) NOT NULL',
            'child' => 'varchar(64) NOT NULL',
            'primary key (parent,child)'
        ]);
        $this->addForeignKey('FK_AuthItemChild_parent_AuthItem', $itemChildTable, 'parent', $itemTable, 'name');
        $this->addForeignKey('FK_AuthItemChild_child_AuthItem', $itemChildTable, 'child', $itemTable, 'name', 'cascade', 'cascade');
        $this->createTable($assignmentTable, [
            'item_name' => 'varchar(64) NOT NULL PRIMARY KEY',
            'user_id' => 'varchar(64) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER
        ]);
        $this->addForeignKey('FK_AuthAssign_AuthItem', $assignmentTable, 'item_name', $itemTable, 'name', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $itemTable = $this->authManager->itemTable;
        $itemChildTable = $this->authManager->itemChildTable;
        $assignmentTable = $this->authManager->assignmentTable;
        $ruleTable = $this->authManager->ruleTable;
        $this->dropForeignKey('FK_AuthItem_AuthRule', $itemTable);
        $this->dropForeignKey('FK_AuthItemChild_parent_AuthItem', $itemChildTable);
        $this->dropForeignKey('FK_AuthItemChild_child_AuthItem', $itemChildTable);
        $this->dropForeignKey('FK_AuthAssign_AuthItem', $assignmentTable);
        $this->dropTable($itemChildTable);
        $this->dropTable($assignmentTable);
        $this->dropTable($itemTable);
        $this->dropTable($ruleTable);
    }

    public function init()
    {
        parent::init();
        $this->authManager = Yii::$app->authManager;
    }
}