<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon2.ico" type="image/x-icon" />
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-blue navbar-fixed-top',
        ],
    ]);
    /*echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            //['label' => 'Home', 'url' => ['/']],
            //['label' => 'About', 'url' => ['/site/about']],
            //['label' => 'Contact', 'url' => ['/site/contact']],
            ['label' => 'Cuenta',
                'url' => ['/request'],
                'visible' => !Yii::$app->user->isGuest &&
                    (Yii::$app->user->identity->id_user_rol=='2')],
            Yii::$app->user->isGuest ? (
            ['label' => 'Sign Up', 'url' => ['/site/signup']]):'',
            Yii::$app->user->isGuest ? (
            ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);*/
    $menuItems = [
        ['label' => 'Inicio', 'url' => ['/']],
        ['label' => "", 'url' => ['/site/index'], 'linkOptions' => ['class' => 'fa fa-home']],
        ['label' => '|'],
        //['label' => 'Sobre', 'url' => ['/site/about']],
        //['label' => 'Contacto', 'url' => ['/site/contact']],
        ['label' => 'Tasa del día', 'url' => ['/tasa-dia'], 'visible' => !Yii::$app->user->isGuest &&Yii::$app->user->identity->id_user_rol=='1'],
        ['label' => 'Transacciones', 'url' => ['/transaction'], 'visible' => !Yii::$app->user->isGuest &&Yii::$app->user->identity->id_user_rol=='1'],



    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Registarse', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => '|'];
        $menuItems[] = ['label' => 'Iniciar Sesión', 'url' => ['/site/login']];
    }
    else {
        if (Yii::$app->user->identity->id_user_rol=='1') {
            $menuItems[] = [
                'label' => 'Admin', 'items' => [
                    ['label' => 'Rol', 'url' => ['/user-rol'], 'visible' => !Yii::$app->user->isGuest &&Yii::$app->user->identity->id_user_rol=='1'],
                    ['label' => 'Operaciones', 'url' => ['/user-operacion'], 'visible' => !Yii::$app->user->isGuest &&Yii::$app->user->identity->id_user_rol=='1'],
                    ['label' => 'Usuarios', 'url' => ['/user'], 'visible' => !Yii::$app->user->isGuest && (Yii::$app->user->identity->id_user_rol=='1')],
                    ['label' => 'Registro de Usuario', 'url' => ['/site/signup'], 'visible' => !Yii::$app->user->isGuest &&Yii::$app->user->identity->id_user_rol=='1'],

                ]
            ];
            $menuItems[] = [
                'label' => 'Cuentas de usuarios', 'items' => [
                    ['label' => 'Saldo', 'url' => ['/summary'], 'visible' => !Yii::$app->user->isGuest &&Yii::$app->user->identity->id_user_rol=='1'],
                    ['label' => 'Cuentas bancarias', 'url' => ['/bank-account'], 'visible' => !Yii::$app->user->isGuest &&Yii::$app->user->identity->id_user_rol=='1'],
                    ['label' => 'Pago Movil de usuarios', 'url' => ['/bank-movil'], 'visible' => !Yii::$app->user->isGuest && (Yii::$app->user->identity->id_user_rol=='1')],

                ]
            ];
        }
        if (Yii::$app->user->identity->id_user_rol=='2') {
            $menuItems[] = ['label' => 'Cuenta', 'url' => ['/transaction'], 'visible' => !Yii::$app->user->isGuest &&Yii::$app->user->identity->id_user_rol=='2'];
            /*$menuItems[] = [
                'label' => 'Admin', 'items' => [
                    ['label' => 'Rol', 'url' => ['/rol'], 'visible' => !Yii::$app->user->isGuest &&Yii::$app->user->identity->id_user_rol=='2'],
                    ['label' => 'Operaciones', 'url' => ['/operacion'], 'visible' => !Yii::$app->user->isGuest &&Yii::$app->user->identity->id_user_rol=='2'],

                ]
            ];*/

        }
        $menuItems[] = [
            'label' => 'Bienvenid@ '. Yii::$app->user->identity->name, 'items' => [
                '<li role="presentation" class="divider"></li>',
                ['label' => 'Opciones de Perfil'],
                ['label' => 'Modificar Contraseña', 'url' => ['/site/reset-password'],'visible' => !Yii::$app->user->isGuest],
                '<li role="presentation" class="divider"></li>',
                ['label' => 'Cerrar Sesión (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']],
            ]
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<!--<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
