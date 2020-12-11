<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SummarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Resumen';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter' => true,
        'columns' => [
            [
                'attribute'=>'id',
                'label'=>'Usuario',
                'filter'=>$searchModel->getUsers(),
                'value'=>'username',
                'footer' =>'Total',
            ],
            [
                'label' => 'BTC', 'format' => 'html',
                'value' => function($data){
                    return number_format ( $data::getBalance($data->id), 8 , "," , "." );
                },
                'footer' => number_format ( $model->getTotalBalance(), 8 , "," , "." ),
            ],
            [
                'header' => 'Monto Bs.',
                'value' => function ($data) {
                    return number_format ($data::getBalance($data->id) * $data::getTasaBs(), 2 , "," , "." );
                },
                'footer' => number_format ( $model->getTotalBalance() * $model->getTasaBs(), 2 , "," , "." ),

            ],
            [
                'header' => 'Monto $.',
                'value' => function ($data, $model) {
                    return number_format ( $data::getBalance($data->id) * $data::getTasaDolares(), 2 , "," , "." );
                },
                'footer' => number_format ( $model->getTotalBalance() * $model->getTasaDolares(), 2 , "," , "." ),

            ],
        ],
    ]); ?>


</div>
