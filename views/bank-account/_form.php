<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BankAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'number')->textInput() ?>

    <?= $form->field($model, 'id_bank')->dropDownList($model->getBanks()) ?>

    <?= $form->field($model, 'person_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_person_name')->textInput() ?>

    <?= $form->field($model, 'id_type_bank_account')->dropDownList($model->getTypeBankAccounts()) ?>

    <?php if(Yii::$app->user->identity->id_user_rol == '1') echo $form->field($model, 'id_user')->dropDownList($model->getUsers()) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
