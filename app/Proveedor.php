<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = [
        'id', 'contacto', 'telefono_contacto','nombre','tipo_documento','num_documento','direccion','telefono','email','condicion'
    ];

    public $timestamps = false;

}
