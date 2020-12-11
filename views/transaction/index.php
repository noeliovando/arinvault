<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transacciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">
    <h4><?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php
        echo "Saldo: ".$searchModel->getBalance()." ₿ | ~ Bs.".number_format ( $searchModel->getBalance()*Html::encode($tasa_bolivar), 2 , "," , "." )
            ." | ~ $".number_format ( $searchModel->getBalance()*Html::encode($tasa_dolar), 2 , "," , "." )?></h4>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(Yii::$app->user->identity->id_user_rol == '1') echo Html::a('Crear Transacción', ['create'], ['class' => 'btn btn-success']) ?>
    </p>



    <?php if(Yii::$app->user->identity->id_user_rol != '1') echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            'description',
            'date',
            'amount',
            [
                'attribute'=>'id_trans_type',
                //'filter'=>$searchModel->getTransType(),
                'label'=>'Tipo de solicitud',
                'value'=>'transTypeName',
                'contentOptions' => function ($model, $key, $index, $column) {
                    return ['style' => 'background-color:'
                        . (!empty($model->id_trans_type) && $model->id_trans_type == 2
                            ? '#ff9191' : '#a9ff91')];
                },
            ],
        ],
    ]); ?>
    <?php if(Yii::$app->user->identity->id_user_rol == '1') echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'id_user',
                'filter'=>$searchModel->getUser(),
                'label'=>'Cliente',
                'value'=>'userName',
            ],
            'description',
            'date',
            'amount',
            [
                'attribute'=>'id_trans_type',
                //'filter'=>$searchModel->getTransType(),
                'label'=>'Tipo de solicitud',
                'value'=>'transTypeName',
                'contentOptions' => function ($model, $key, $index, $column) {
                    return ['style' => 'background-color:'
                        . (!empty($model->id_trans_type) && $model->id_trans_type == 2
                            ? '#ff9191' : '#a9ff91')];
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
