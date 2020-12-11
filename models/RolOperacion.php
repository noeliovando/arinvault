<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rol_operacion".
 *
 * @property int $id_user_rol
 * @property int $id_operacion
 *
 * @property UserRol $userRol
 * @property UserOperacion $operacion
 */
class RolOperacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rol_operacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user_rol', 'id_operacion'], 'required'],
            [['id_user_rol', 'id_operacion'], 'integer'],
            [['id_user_rol'], 'exist', 'skipOnError' => true, 'targetClass' => UserRol::className(), 'targetAttribute' => ['id_user_rol' => 'id']],
            [['id_operacion'], 'exist', 'skipOnError' => true, 'targetClass' => UserOperacion::className(), 'targetAttribute' => ['id_operacion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user_rol' => 'Id User Rol',
            'id_operacion' => 'Id Operacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRol()
    {
        return $this->hasOne(UserRol::className(), ['id' => 'id_user_rol']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperacion()
    {
        return $this->hasOne(UserOperacion::className(), ['id' => 'id_operacion']);
    }
}
