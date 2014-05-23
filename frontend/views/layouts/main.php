<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use fourteenmeister\core\CoreAsset;
use frontend\widgets\Alert;
use yii\bootstrap\ButtonDropdown;
use fourteenmeister\users\Module;
use kartik\icons\Icon;

Icon::map($this);

CoreAsset::register($this);

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
        NavBar::begin([
            'options' => [
                'class' => 'navbar-default navbar-fixed-top',
            ],
            'innerContainerOptions' => [
                'class' => 'container-fluid'
            ]
        ]);
        $leftMenu = [
            ['label' => 'Главная', 'url' => ['/site/index']],
            ['label' => 'Информация', 'url' => ['/site/about']],
        ];
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-left'],
            'items' => $leftMenu,
        ]);
        $rightMenu = [];
        if (\Yii::$app->user->can('admin')) {
            $rightMenu[] = [
                'label' => Icon::show('cogs') . '&nbsp;Control panel',
                'url' => Yii::$app->urlManager->createUrl('../../backend/web')
            ];
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $rightMenu,
            'encodeLabels' => false
        ]);
        echo Html::beginTag('span', ['class' => 'pull-right']);
        if (Yii::$app->user->isGuest) {
            echo ButtonDropdown::widget([
                'label' => Icon::show('user') . 'Здравствуйте, Guest',
                'dropdown' => [
                    'items' => [
                        [
                            'label' => Icon::show('pencil-square-o') . 'Регистрация',
                            'url' => ['/users/registration'],
                        ],
                        [
                            'label' => Icon::show('sign-in') . 'Вход',
                            'url' => ['/users/login'],
                        ],
                    ],
                    'encodeLabels' => false
                ],
                'encodeLabel' => false,
                'options' => [
                    'class' => 'navbar-btn'
                ]
            ]);
        } else {
            echo ButtonDropdown::widget([
                'label' => Icon::show('user') . 'Здравствуйте, <span style="font-weight: bold;">' . Yii::$app->user->identity->username . '</span>',
                'dropdown' => [
                    'items' => [
                        [
                            'label' => Icon::show('pencil-square-o') . 'Профиль',
                            'url' => ['/users/profile'],
                        ],
                        [
                            'label' => Icon::show('sign-out') . 'Выйти',
                            'url' => ['/users/logout'],
                            'linkOptions' => [
                                'data-method' => 'post',
                            ]
                        ],
                    ],
                    'encodeLabels' => false
                ],
                'encodeLabel' => false,
                'options' => [
                    'class' => 'navbar-btn btn-primary'
                ]
            ]);
        }
        echo Html::endTag('span');
        NavBar::end();
        ?>

        <div class="container-fluid">
            <?=
            Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],                
                'encodeLabels' => false
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar-default navbar-fixed-bottom',
        ],
        'renderInnerContainer' => false
    ]);
    if (\Yii::$app->user->can('admin')) {
        $dsn = yii::$app->db->dsn;
        preg_match( '/(database=(.*?)(?:\;|$))|(dbname=(.*?)(?:\;|$))/i', $dsn, $match);
        $database = end($match);
        echo "<span class=\"label label-primary navbar-text pull-left\" title=\"<h4>Текущая база данных: <strong>{$database}</strong></h4>\" data-toggle=\"tooltip\" style=\"font-size: 1em; color: white; cursor: pointer;\">Сервер</span>";
    }    
    echo '<p class="navbar-text">Разработчик Андрей Камаев</p>';
    NavBar::end();
    ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>