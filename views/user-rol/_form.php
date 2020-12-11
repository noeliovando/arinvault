<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserRol */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-rol-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?php
    $opciones = \yii\helpers\ArrayHelper::map($tipoOperaciones, 'id', 'name');
    echo $form->field($model, 'operaciones')->checkboxList($opciones,['separator' => '<br>'], ['unselect'=>NULL]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
