<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BankAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cuentas bancarias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-account-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear cuenta de banco', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'number',
            [
                'attribute'=>'id_bank',
                'filter'=>$searchModel->getBanks(),
                'label'=>'Banco',
                'value'=>'bank.name',
            ],
            'person_name',
            'id_person_name',
            [
                'attribute'=>'id_user',
                'filter'=>$searchModel->getUsers(),
                'label'=>'Usuario',
                'value'=>'nombreCompleto',
            ],
            //'id_type_bank_account',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
