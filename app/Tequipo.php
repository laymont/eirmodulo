<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tequipo extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'tequipos';
  protected $guarded = ['id'];
  /**
   * Fields that can be mass assigned.
   *
   * @var array
   */
  protected $fillable = ['tipo','descripcion','teus'];
}
