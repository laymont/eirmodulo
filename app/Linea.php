<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'lineas';
  protected $guarded = ['id'];
  // protected $dates = ['created_at','updated_at','deleted_at'];
  /**
   * Fields that can be mass assigned.
   *
   * @var array
   */
  protected $fillable = ['rif','nombre','auditoria','agencia','dlibres','activo'];
}
