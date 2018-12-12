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
  protected $dates = ['fecha'];
  /**
   * Fields that can be mass assigned.
   *
   * @var array
   */
  protected $fillable = ['fecha','hora','transporte_id','inventario_id'];

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
}
