<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viaje extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'viajes';
  protected $guarded = ['id'];
  /**
   * Fields that can be mass assigned.
   *
   * @var array
   */
  protected $fillable = ['viaje','buque','eta','ad'];

  /**
   * Viaje belongs to Buque.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function buque()
  {
    // belongsTo(RelatedModel, foreignKey = buque_id, keyOnRelatedModel = id)
    return $this->belongsTo(Buque::class,'buque');
  }
}
