<?php

use yii\db\Schema;

class m140602_010209_configuring_Administrator extends \yii\db\Migration
{

    const EVENT_BEFORE_REGISTER = 'before_register';
    const EVENT_AFTER_REGISTER = 'after_register';

    public function up()
    {

        $class = Yii::$app->user->identityClass;
        $user = new $class(['scenario' => 'register']);
        echo "\n  Enter administrator name: ";
        while (true) {
            $user->username = $this->read_stdin();
            if ($user->validate(['username'])) {
                break;
            }
            $error = $user->firstErrors['username'];
            echo '  ' . $error;
            echo "\n  Enter administrator name: ";
        }
        while (true) {
            $user->password = $this->prompt_silent();
            if ($user->validate(['password'])) {
                break;
            }
            $error = $user->firstErrors['password'];
            echo '  ' . $error . "\n";
        }
        echo "  Enter administrator email: ";
        while (true) {
            $user->email = $this->read_stdin();
            if ($user->validate(['email'])) {
                break;
            }
            $error = $user->firstErrors['email'];
            echo '  ' . $error;
            echo "\n  Enter administrator email: ";
        }
        $user->trigger(self::EVENT_BEFORE_REGISTER);
        $user->setAttribute('registered_from', ip2long('127.0.0.1'));
        $user->trigger(self::EVENT_AFTER_REGISTER);
        $user->confirm(false);
        if ($user->save(false)) {
            $auth = Yii::$app->authManager;
            $admin = $auth->createRole('admin');
            $admin->description = 'administrator';
            $auth->add($admin);
            $auth->assign($admin, $user->id);
            return true;
        }
        else {
            throw new Exception("Error while creating administrator account");            
        }
    }

    public function down()
    {
        $class = Yii::$app->user->identityClass;
        $users = $class::find()->all();
        foreach ($users as $index => $user) {
            $user->delete();
        };
        $user = new $class();
        $table = $user->tableName();
        $this->execute("DBCC CHECKIDENT ({{%$table}}, RESEED, 0)");        
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }

    protected function read_stdin()
    {
        $fr = fopen("php://stdin", "r");
        $input = fgets($fr, 128);
        $input = trim($input);
        fclose($fr);
        return $input; // return the text entered
    }

    protected function prompt_silent()
    {
        if (preg_match('/^win/i', PHP_OS)) {
            $pwd = exec('powershell -c "$pw = read-host \"  Enter administrator password\" -AsSecureString; $password = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto([System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($pw)); echo \"\"; $password;"');
        } else {
            echo '  Enter password: ';
            $pwd = exec('
                #!/bin/bash
                stty -echo
                printf "Enter password: "
                read PASSWORD
                stty echo
                printf "\n"
                echo $PASSWORD
            ');
            echo "\n";
        }
        return $pwd;
    }
}