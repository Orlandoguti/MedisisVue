<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $fillable =[
        'idcategoria','codigo','nombre','precio_venta','precio_compra','stock','descripcion','condicion','imagen','fecha_hora','fecha_vencimiento'
    ];
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
}
