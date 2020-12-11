<?php

namespace app\models;

use yii;
use yii\web\Controller;


class AccessHelpers {

    public static function getAcceso($operacion)
    {
        $connection = \Yii::$app->db;
        $sql = "SELECT o.name
                FROM user u
                JOIN user_rol r ON u.id_user_rol = r.id
                JOIN rol_operacion ro ON r.id = ro.id_user_rol
                JOIN user_operacion o ON ro.id_operacion = o.id
                WHERE o.name =:user_operacion
                AND u.id_user_rol =:id_user_rol";
        $command = $connection->createCommand($sql);
        $command->bindValue(":user_operacion", $operacion);
        $command->bindValue(":id_user_rol", Yii::$app->user->identity->id_user_rol);
        $result = $command->queryOne();

        if ($result['name'] != null){
            return true;
        } else {
            return false;
        }
    }

}