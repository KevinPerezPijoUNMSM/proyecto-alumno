<?php

namespace app\models;

use app\models\Tablas\Alumno;

/**
 * This is the ActiveQuery class for [[Alumno]].
 *
 * @see Alumno
 */
class AlumnoQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * {@inheritdoc}
     * @return Alumno[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Alumno|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
