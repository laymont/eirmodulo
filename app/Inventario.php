<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'inventario';
  protected $guarded = ['id'];
  protected $dates = ['fdb','fdm','frd','fdespims','mod'];
  /**
   * Fields that can be mass assigned.
   *
   * @var array
   */
  protected $fillable = ['acta','pase','linea','buque','viaje','tcont','isocode','contenedor','lote','fdb','fdm','frd','eir_r','fact','paset','rep_dano','status','condicion','precinto','bl','patio','ubicacion','consignatario','obs','mrep','fdespims','vaciado','eir_d','status_d','buqued','viajed','precintodesp','expo','booking','auditoria','c','delete','mod','codigo_b_actas','codigo_b_pases'];

  /**
   * Inventario belongs to Linea.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function lineas()
  {
    // belongsTo(RelatedModel, foreignKey = linea_id, keyOnRelatedModel = id)
    return $this->belongsTo(Linea::class,'linea');
  }
  /**
   * Inventario belongs to Buque.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function buques()
  {
    // belongsTo(RelatedModel, foreignKey = buque_id, keyOnRelatedModel = id)
    return $this->belongsTo(Buque::class,'buque');
  }
  /**
   * Inventario belongs to Viaje.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function viajes()
  {
    // belongsTo(RelatedModel, foreignKey = viaje_id, keyOnRelatedModel = id)
    return $this->belongsTo(Viaje::class,'viaje');
  }
  /**
   * Inventario belongs to Tipo.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function tipos()
  {
    // belongsTo(RelatedModel, foreignKey = tipo_id, keyOnRelatedModel = id)
    return $this->belongsTo(Tequipo::class,'tcont');
  }
  /**
   * Inventario belongs to Eirr.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function eirr()
  {
    // belongsTo(RelatedModel, foreignKey = eirr_id, keyOnRelatedModel = id)
    return $this->belongsTo(Eir::class,'eir_r');
  }
  /**
   * Inventario belongs to Consignatarios.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function consignatarios()
  {
    // belongsTo(RelatedModel, foreignKey = consignatarios_id, keyOnRelatedModel = id)
    return $this->belongsTo(Consignatario::class,'consignatario');
  }
}
