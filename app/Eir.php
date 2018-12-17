<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eir extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'eirs';
  protected $guarded = ['id'];
  protected $casts = [
    'fecha' => 'datetime'
  ];
  protected $dates = ['fecha','created_at','updated_at','deleted_at'];
  /**
   * Fields that can be mass assigned.
   *
   * @var array
   */
  protected $fillable = ['fecha','inventario_id','movimiento','precintos','imo','dmgs','transporte_id','placa','chofer','indentificacion','created_by'];

  /**
   * Eir belongs to Inventario.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function inventario()
  {
    // belongsTo(RelatedModel, foreignKey = inventario_id, keyOnRelatedModel = id)
    return $this->belongsTo(Inventario::class);
  }

  /**
   * Eir belongs to Transporte.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function transporte()
  {
    // belongsTo(RelatedModel, foreignKey = transporte_id, keyOnRelatedModel = id)
    return $this->belongsTo(Transporte::class);
  }
}
