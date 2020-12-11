<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserRol */

$this->title = 'Update User Rol: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User Rols', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-rol-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipoOperaciones' => $tipoOperaciones
    ]) ?>

</div>
