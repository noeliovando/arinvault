<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Saldo de usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-account-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ingresar Saldo de usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter' => true,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'id_user',
                'filter'=>$searchModel->getUser(),
                'label'=>'Usuario',
                'value'=>'userUsername',
                'footer' =>'Total',
            ],
            [
                'attribute' =>'btc_amount',
                'footer' => $model->getTotal($dataProvider->models, 'btc_amount'),
            ],
            [
                'header' => 'Monto Bs.',
                'value' => function ($model) {
                    return number_format ( $model->btc_amount * $model->getTasaBs(), 2 , "," , "." );
                },
                'footer' => number_format ( $model->getTotal($dataProvider->models, 'btc_amount') * $model->getTasaBs(), 2 , "," , "." ),

            ],
            [
                'header' => 'Monto $.',
                'value' => function ($model) {
                    return number_format ( $model->btc_amount * $model->getTasaDolares(), 2 , "," , "." );
                },
                'footer' => number_format ( $model->getTotal($dataProvider->models, 'btc_amount') * $model->getTasaDolares(), 2 , "," , "." ),

            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
