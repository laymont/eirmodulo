<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transporte extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'transportes';
  protected $guarded = ['id'];
  protected $dates = ['created_at','updated_at','deleted_at'];
  /**
   * Fields that can be mass assigned.
   *
   * @var array
   */
  protected $fillable = ['rif','nombre','direccion','created_by'];
}
