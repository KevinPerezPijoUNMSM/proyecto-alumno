<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alumno".
 *
 * @property int $id
 * @property string|null $alu_vcnombre
 * @property string|null $alu_vcapellido
 * @property string|null $alu_vccodigo
 * @property string|null $alu_vcsexo
 * @property string|null $alu_vccorreo
 * @property string|null $alu_vcpassword
 * @property string|null $alu_vctelefono
 * @property int|null $id_escuela
 *
 * @property Escuela $escuela
 * @property ProyectoAlumno[] $proyectoAlumnos
 */
class Alumno extends \yii\db\ActiveRecord
{
    public $alu_vcnombre;
    public $alu_vcpassword;

    private static $alumnos = [
        '100' => [
            'id' => '100',
            'alu_vcnombre' => 'admin',
            'alu_vcpassword' => 'admin',
        ],
        '101' => [
            'id' => '101',
            'alu_vcnombre' => 'demo',
            'alu_vcpassword' => 'demo',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alumno';
    }

    public static function findByUsername($alu_vcnombre)
    {
        foreach (self::$alumnos as $alumno) {
            if (strcasecmp($alumno['alu_vcnombre'], $alu_vcnombre) === 0) {
                return new static($alumno);
            }
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_escuela'], 'integer'],
            [['alu_vcnombre', 'alu_vcapellido', 'alu_vccodigo', 'alu_vcsexo', 'alu_vccorreo', 'alu_vcpassword', 'alu_vctelefono'], 'string', 'max' => 45],
            [['id_escuela'], 'exist', 'skipOnError' => true, 'targetClass' => Escuela::class, 'targetAttribute' => ['id_escuela' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alu_vcnombre' => 'Alu Vcnombre',
            'alu_vcapellido' => 'Alu Vcapellido',
            'alu_vccodigo' => 'Alu Vccodigo',
            'alu_vcsexo' => 'Alu Vcsexo',
            'alu_vccorreo' => 'Alu Vccorreo',
            'alu_vcpassword' => 'Alu Vcpassword',
            'alu_vctelefono' => 'Alu Vctelefono',
            'id_escuela' => 'Id Escuela',
        ];
    }

    /**
     * Gets query for [[Escuela]].
     *
     * @return \yii\db\ActiveQuery|EscuelaQuery
     */
    public function getEscuela()
    {
        return $this->hasOne(Escuela::class, ['id' => 'id_escuela']);
    }

    /**
     * Gets query for [[ProyectoAlumnos]].
     *
     * @return \yii\db\ActiveQuery|ProyectoAlumnoQuery
     */
    public function getProyectoAlumnos()
    {
        return $this->hasMany(ProyectoAlumno::class, ['id_alumno' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AlumnoQuery the active query used by this AR class.
     */

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getAlumno(), 3600);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getAlumno()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }


    public static function find()
    {
        return new AlumnoQuery(get_called_class());
    }
    /*
        public function login(){
            if($this->validate()){}
        }*/
}
