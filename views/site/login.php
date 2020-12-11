<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar Sesión';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="row" align="center">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="row" align="center">
        <p>Por favor llene los siguientes campos para iniciar sesión:</p>
    </div>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                //'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                //'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>
    <div class="row" align="center">
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
    </div>
    <div class="row" align="center">
        <?= $form->field($model, 'password')->passwordInput() ?>
    </div>
    <div class="row" align="center">
        <?= $form->field($model, 'rememberMe')->checkbox([
            //'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>
    </div>
    <div class="row" align="center">
        <div class="form-group">
            <div>
                <?= Html::submitButton('Iniciar sesión', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
    </div>
        <?php ActiveForm::end(); ?>
    
</div>
