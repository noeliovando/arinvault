<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BankMovil */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-movil-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cedula')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_bank')->dropDownList($model->getBanks()) ?>

    <?php if(Yii::$app->user->identity->id_user_rol == '1') echo $form->field($model, 'id_user')->dropDownList($model->getUsers()) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
