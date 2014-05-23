<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use kartik\icons\Icon;
use fourteenmeister\users\Module;

Icon::map($this);

/**
 * @var \yii\web\View $this
 * @var string $content
 */
//AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php

        ?>
        <div class="container-fluid">
            <?=
            Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'encodeLabels' => false
            ]) ?>
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
    echo '<p class="navbar-text pull-left">Разработчик Андрей Камаев</p>';
    NavBar::end();
    ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>