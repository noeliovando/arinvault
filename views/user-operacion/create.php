<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserOperacion */

$this->title = 'Create User Operacion';
$this->params['breadcrumbs'][] = ['label' => 'User Operacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-operacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
