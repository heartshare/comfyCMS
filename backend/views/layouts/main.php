<?php

use fourteenmeister\core\CoreAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Collapse;
use yii\bootstrap\ButtonDropdown;
use yii\widgets\Breadcrumbs;
use kartik\icons\Icon;
use kartik\widgets\SideNav;

Icon::map($this);

/**
 * @var \yii\web\View $this
 * @var string $content
 */
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
                'class' => 'navbar-inverse navbar-fixed-top',
                'style' => 'background-image: linear-gradient(#04739b, #006196 60%, #04739b);'
            ],
            'innerContainerOptions' => [
                'class' => 'container-fluid'
            ]
        ]);
        $leftMenu = [
            [
                'label' => '<span class="label label-primary">' . Icon::show('cogs') . 'ComfyCMS</span>',
                'url' => ['/'],
                'linkOptions' => ['style' => 'color: white;']
            ],
        ];
        echo Nav::widget([
            'encodeLabels' => false,
            'options' => [
                'class' => 'navbar-nav navbar-left',
                'style' => 'font-size: 150%;'
            ],
            'items' => $leftMenu,
        ]);
        $rightMenu = [];
        $rightMenu[] = [
            'label' => Icon::show('home') . 'Сайт',
            'url' => Yii::$app->urlManagerFrontend->createUrl(''),
            'linkOptions' => [
                'style' => 'color: white;'
            ]
        ];
        echo Nav::widget([
            'encodeLabels' => false,
            'options' => [
                'class' => 'navbar-nav navbar-right',
                'style' => 'font-size: 150%;'
            ],
            'items' => $rightMenu,
        ]);
        echo Html::beginTag('span', ['class' => 'pull-right']);
        echo ButtonDropdown::widget([
            'label' => Icon::show('user') . Yii::$app->user->identity->username,
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
                'class' => 'navbar-btn'
            ]
        ]);
        echo Html::endTag('span');
        NavBar::end();
        ?>

        <div class="container-fluid">
            <div class="row">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'encodeLabels' => false
                ]) ?>
                <div class="col-md-2">
                    <?php
                    echo SideNav::widget([
                        'type' => SideNav::TYPE_PRIMARY,
                        'heading' => 'Menu<span class="opened" title="Развернуть всё" data-container="body" onclick="js: $(\'div.table ul li:has(ul)\').removeClass(\'active\'); $(\'div.table ul li:has(ul)\').toggleClass(\'active\'); $(this).toggle(\'hide\'); $(this).next().toggle(\'hide\'); " data-toggle="tooltip" style="cursor: pointer; display: block; float:right;"><i class="indicator glyphicon glyphicon-chevron-down"></i></span><span class="closed" title="Свернуть всё" data-container="body" onclick="js: $(\'div.table ul li:has(ul)\').addClass(\'active\'); $(\'div.table ul li:has(ul)\').toggleClass(\'active\'); $(this).toggle(\'hide\'); $(this).prev().toggle(\'hide\'); " data-toggle="tooltip" style="float: right; display: none; cursor: pointer;"><i class="indicator glyphicon glyphicon-chevron-right"></i></span>',
                        'encodeLabels' => false,
                        'items' => [
                            [
                                'url' => '#',
                                'label' => Icon::show('key') . 'Роли/разрешения',
                                'items' => [
                                    ['label' => Icon::show('indent') . '&nbsp;Дерево', 'url' => 'rbac'],
                                    ['label' => 'Роли', 'icon' => 'folder-close', 'url' => 'rbac/roles'],
                                    ['label' => Icon::show('unlock-alt') . '&nbsp;Разрешения', 'url' => 'rbac/permissions'],
                                    ['label' => 'Создать', 'icon' => 'edit', 'url' => 'rbac/create'],
                                ],
                                'options' => [
                                    'title' => 'Управление ролями, разрешениями',
                                    'data-toggle' => 'tooltip',
                                    'data-container' => 'body',
                                    'data-placement' => "right",
                                ],
                                'active' => strpos(Yii::$app->request->url, 'rbac') ? true : false
                            ],
                            [
                                'url' => '#',
                                'label' => 'Пользователи',
                                'icon' => 'user',
                                'items' => [
                                    ['label' => 'Просмотр', 'icon' => 'info-sign', 'url' => 'users'],
                                ],
                                'options' => [
                                    'title' => 'Управление пользователями',
                                    'data-toggle' => 'tooltip',
                                    'data-container' => 'body',
                                    'data-placement' => "right",
                                ],
                                'active' => strpos(Yii::$app->request->url, 'users') ? true : false
                            ],
                            [
                                'label' => Icon::show('cog') . '&nbsp;Gii',
                                'url' => ['/gii'],
                                'options' => [
                                    'title' => 'Code generator',
                                    'data-toggle' => 'tooltip',
                                    'data-container' => 'body',
                                    'data-placement' => "right",
                                ]
                            ],
                        ],
                    ]);
                    ?>
                </div>
                <div id="content" class="col-md-10">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>

    <div id="response"></div>

    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar-default navbar-fixed-bottom',
        ],
        'renderInnerContainer' => false
    ]);
    $dsn = yii::$app->db->dsn;
    preg_match('/(database=(.*?)(?:\;|$))|(dbname=(.*?)(?:\;|$))/i', $dsn, $match);
    $database = end($match);
    echo "<span class=\"label label-primary navbar-text pull-left\" title=\"<h4>Текущая база данных: <strong>{$database}</strong></h4>\" data-toggle=\"tooltip\" style=\"font-size: 1em; color: white; cursor: pointer;\">Сервер</span>";
    echo '<p class="navbar-text">Разработчик Андрей Камаев</p>';
    NavBar::end();
    ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>