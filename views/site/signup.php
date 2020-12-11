<?php
/**
 * created by: Noeli Ovando
 * Date: 19/08/2019
 * Time: 04:11 PM
 */


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Registro de usuario';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Por favor, llene los siguientes campos para registrarse en ArinVault.com:</p>
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'name') ->textInput() ?>
            <?= $form->field($model, 'surname') ->textInput() ?>
            <?= $form->field($model, 'cedula') ->textInput() ?>
            <?= $form->field($model, 'telefono') ->textInput() ?>
            <div class="form-group">
                <?= Html::submitButton('Registrarse', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>