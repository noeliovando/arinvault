<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tasa_dia".
 *
 * @property int $id
 * @property double $valor_bolivar
 * @property double $valor_dolar
 * @property string $fecha
 */
class TasaDia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasa_dia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['valor_bolivar', 'valor_dolar', 'fecha'], 'required'],
            [['valor_bolivar', 'valor_dolar'], 'number'],
            [['fecha'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'valor_bolivar' => 'Valor Bolivar',
            'valor_dolar' => 'Valor Dolar',
            'fecha' => 'Fecha',
        ];
    }
}
