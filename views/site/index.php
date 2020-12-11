<?php
use app\assets\AdminAsset;
use yii\helpers\Html;

AdminAsset::register($this);

/* @var $this yii\web\View */
/* @var $tasa_bolivar app\models\UserAccount */
/* @var $tasa_dolar app\models\UserAccount */

$this->title = Yii::$app->name;
?>
<!--<div class="video-background">
    <div class="video-foreground">
        <iframe src="https://www.youtube.com/embed/7JW6MMa8B00?controls=0&showinfo=0&rel=0&autoplay=1&loop=1&mute=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
  </div>-->

<div class="site-index">
    <div class="body-content">
        <div class="jumbotron" style="padding:5px;margin:0px;">
            <img src="img/ArinVault_Logo_1000x10002.png" height="100" width="100">
        </div>
        <div class="row">
            <div align="center">
                <h2>Importante</h2>
                <p>Los valores aquí mostrados son referenciales. La tasa para los retiros y depositos se toman al
                    momento de cada transacción.</p>
            </div>

        </div>
    </div>
    <div class="jumbotron" style="padding-top:10px;">


        <h1>¡Tasa del día!</h1>
        <h3> <?php echo "1 BTC ~ Bs.".number_format ( Html::encode($tasa_bolivar), 2 , "," , "." )?></h3>
        <h3><?php echo "1 BTC ~ $".number_format ( Html::encode($tasa_dolar), 2 , "," , "." )?></h3>

        <?php echo Yii::$app->user->identity?  '<p><a class="btn btn-lg btn-success" href="http://arinvault.com/areacliente/web/request">Consultar saldo</a></p>':'';?>
    </div>


</div>
