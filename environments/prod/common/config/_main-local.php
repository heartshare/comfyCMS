<?php echo "<?php\n"; ?>

return [
    'basePath' => 'C:\OpenServer\domains',
    'language' => '<?php echo $config["language"]; ?>',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => '<?php echo $config["components"]["db"]["dsn"]; ?>',
            'username' => '<?php echo $config["components"]["db"]["username"]; ?>',
            'password' => '<?php echo $config["components"]["db"]["password"]; ?>',
            'charset' => 'utf8',
        ],
        'authManager' => [
            'class' => 'fourteenmeister\core\AuthManager',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'fourteenmeister\users\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => '../../frontend/web/users/login',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '<?php echo $config["components"]["mail"]["transport"]["host"]; ?>',
                'username' => '<?php echo $config["components"]["mail"]["transport"]["username"]; ?>',
                'password' => '<?php echo $config["components"]["mail"]["transport"]["password"]; ?>',
                'port' => '<?php echo $config["components"]["mail"]["transport"]["port"]; ?>',
                'encryption' => 'tls',
            ],
        ],
    ],
    'modules' => [
        'users' => [
            'class' => 'fourteenmeister\users\Module',
            'tableUser' => 'users',
        ],
        'rbac' => [
            'class' => 'fourteenmeister\rbac\Module',
        ],
    ],
    'language' => 'ru',
];