<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TasaDia */

$this->title = 'Create Tasa Dia';
$this->params['breadcrumbs'][] = ['label' => 'Tasa Dias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasa-dia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
