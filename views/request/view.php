<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Request */


$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Solicitudes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
\yii\web\YiiAsset::register($this);
?>
<div class="request-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?php
        if(Yii::$app->user->identity->id_user_rol=='1'){
            echo Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            echo Html::a('Borrar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Estás seguro de borrar ésta solicitud?',
                    'method' => 'post',
                ],
            ]);
        }
         ?>
    </p>

    <?php if(Yii::$app->user->identity->id_user_rol != '1') echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'amount',
            'description',
            'date',
            //'id_user',
            //'id_type_request',
            //'id_request_status',
            [
                'label' => 'Rapidez',
                'value' => $model->requestSpeed->name,
            ],
            [
                'label' => 'Tipo de solicitud',
                'value' => $model->typeRequest->name,
            ],
        ],
    ]) ?>
    <?php if(Yii::$app->user->identity->id_user_rol == '1') echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'amount',
            'description',
            'date',
            [
                'label' => 'Usuario',
                'value' => $model->user->name,
            ],
            //'id_type_request',
            //'id_request_status',
            [
                'label' => 'Rapidez',
                'value' => $model->requestSpeed->name,
            ],
            [
                'label' => 'Tipo de solicitud',
                'value' => $model->typeRequest->name,
            ],
        ],
    ]) ?>

</div>
