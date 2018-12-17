<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Isocodecontainer extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'tipo_cont';
  /**
   * Fields that can be mass assigned.
   *
   * @var array
   */
  protected $fillable = ['tamano','tipo','codiso','descripcion'];
}
