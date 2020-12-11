<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BankMovilSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pago Movil de usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-movil-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Agregar pago movil', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'telefono',
            'cedula',
            [
                'attribute'=>'id_bank',
                'filter'=>$searchModel->getBanks(),
                'label'=>'Banco',
                'value'=>'bank.name',
            ],
            [
                'attribute'=>'id_user',
                'filter'=>$searchModel->getUsers(),
                'label'=>'Usuario',
                'value'=>'nombreCompleto',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
