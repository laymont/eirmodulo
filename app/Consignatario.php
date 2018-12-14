<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consignatario extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'consignatario';
  protected $guarded = ['id'];
  /**
   * Fields that can be mass assigned.
   *
   * @var array
   */
  protected $fillable = ['rif','libre','pcontacto','email','telf','auditoria'];
}
