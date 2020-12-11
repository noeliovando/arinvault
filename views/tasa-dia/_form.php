<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TasaDia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasa-dia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'valor_bolivar')->textInput() ?>

    <?= $form->field($model, 'valor_dolar')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
