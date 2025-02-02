<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TasaDia */

$this->title = 'Update Tasa Dia: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tasa Dias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tasa-dia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
