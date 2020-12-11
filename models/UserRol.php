<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_rol".
 *
 * @property int $id
 * @property string $name
 *
 * @property RolOperacion[] $rolOperacions
 * @property User[] $users
 */
class UserRol extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_rol';
    }

    public $operaciones;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
            ['operaciones', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
    public function afterSave($insert, $changedAttributes){
        \Yii::$app->db->createCommand()->delete('rol_operacion', 'id_user_rol = '.(int) $this->id)->execute();
        foreach ($this->operaciones as $id) {

            $ro = new RolOperacion();
            $ro->id_user_rol = $this->id;
            $ro->id_operacion = $id;
            $ro->save();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolOperacions()
    {
        return $this->hasMany(RolOperacion::className(), ['id_user_rol' => 'id']);
    }
    public function getOperacionesPermitidas()
    {
        return $this->hasMany(UserOperacion::className(), ['id' => 'id_operacion'])
            ->viaTable('rol_operacion', ['id_user_rol' => 'id']);
    }
    public function getOperacionesPermitidasList()
    {
        return $this->getOperacionesPermitidas()->asArray();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id_user_rol' => 'id']);
    }
}
