<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\RequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $saldo app\models\UserAccount */
/* @var $tasa_bolivar app\models\UserAccount */
/* @var $tasa_dolar app\models\UserAccount */

$this->title = 'Solicitudes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-index">
    <h4> <?php if(Yii::$app->user->identity->id_user_rol != '1') echo
            "Saldo: ".number_format ( Html::encode($saldo), 8 , "," , "." )
            ." ₿ | ~ Bs.".number_format ( Html::encode($saldo)*Html::encode($tasa_bolivar), 2 , "," , "." )
            ." | ~ $".number_format ( Html::encode($saldo)*Html::encode($tasa_dolar), 2 , "," , "." )?></h4>

    <p>
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('Crear solicitud', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
    if(Yii::$app->user->identity->id_user_rol=='1')
        $botones ='{view} {update} {delete} ';
    else
        $botones ='{view} ';
    ?>
    <?php if(Yii::$app->user->identity->id_user_rol != '1') echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'amount',
            'description',
            'date',
            //'id_user',
            [
                'attribute'=>'id_type_request',
                'filter'=>$searchModel->getTypeRequest(),
                'label'=>'Solicitud',
                'value'=>'requestTypeName',
            ],
            //'id_type_request',
            //'id_request_status',

            ['class' => 'yii\grid\ActionColumn',
                'template' => $botones,
            ],
        ],
    ]); ?>
    <?php if(Yii::$app->user->identity->id_user_rol == '1') echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'amount',
            'description',
            'date',
            [
                'attribute'=>'id_user',
                'filter'=>$searchModel->getUser(),
                'label'=>'Cliente',
                'value'=>'userName',
            ],
            [
                'attribute'=>'id_type_request',
                'filter'=>$searchModel->getTypeRequest(),
                'label'=>'Solicitud',
                'value'=>'requestTypeName',
            ],
            //'id_type_request',
            [
                'attribute'=>'id_request_status',
                'filter'=>$searchModel->getRequestStatus(),
                'label'=>'Estatus de la solicitud',
                'value'=>'requestStatusName',
                'contentOptions' => function ($model, $key, $index, $column) {
                    return ['style' => 'background-color:'
                        . (!empty($model->id_request_status) && $model->id_request_status == 1
                            ? '#ff9191' : '#a9ff91')];
                },
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => $botones,
            ],
        ],
    ]); ?>


</div>
