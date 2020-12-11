<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BankMovil */

$this->title = 'Create Bank Movil';
$this->params['breadcrumbs'][] = ['label' => 'Bank Movils', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-movil-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
