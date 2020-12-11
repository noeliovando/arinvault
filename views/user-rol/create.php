<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserRol */

$this->title = 'Create User Rol';
$this->params['breadcrumbs'][] = ['label' => 'User Rols', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-rol-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipoOperaciones' => $tipoOperaciones
    ]) ?>

</div>
