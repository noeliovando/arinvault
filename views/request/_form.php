<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Request */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_type_request')->dropDownList($model->getTypeRequests()) ?>

    <?php if(Yii::$app->user->identity->id_user_rol == '1') echo $form->field($model, 'id_user')->dropDownList($model->getUsers()) ?>

    <?= $form->field($model, 'id_request_speed')->dropDownList($model->getRequestsSpeeds()) ?>

    <?php if(Yii::$app->user->identity->id_user_rol == '1') echo $form->field($model, 'id_request_status')->dropDownList($model->getRequestsStatus()) ?>

    <div class="form-group">
        <?= Html::submitButton('Crear solicitud', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
