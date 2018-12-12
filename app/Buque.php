<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buque extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'buques';
  protected $guarded = ['id'];
  /**
   * Fields that can be mass assigned.
   *
   * @var array
   */
  protected $fillable = ['linea','nombre','obs'];

  /**
   * Buque belongs to Linea.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function linea()
  {
    // belongsTo(RelatedModel, foreignKey = linea_id, keyOnRelatedModel = id)
    return $this->belongsTo(Linea::class,'linea');
  }
}
