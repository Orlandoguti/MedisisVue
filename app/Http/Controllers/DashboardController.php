<?php
 
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
 
use Illuminate\Http\Request;
 
class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {

        $articulos=DB::table('articulos as a')
        ->join('categorias as c','a.idcategoria','=','c.id')
        ->select('a.idcategoria','a.nombre','a.stock','c.nombre as cat')
        ->groupBy('a.idcategoria','a.nombre','a.stock','c.nombre')
        ->get();

        $productos_cliente = DB::select('SELECT v.idcliente, u.nombre as nombre, COUNT(v.estado) AS totalventas
        FROM ventas as v
        JOIN personas as u
        WHERE u.id = v.idcliente
        GROUP BY v.idcliente
        ORDER BY COUNT(v.estado) DESC 
        LIMIT 0 , 10');

    $productos_area = DB::select('SELECT a.idcategoria, ca.nombre, SUM(a.condicion) AS totalproductos 
            FROM articulos as a 
            JOIN categorias as ca 
            WHERE ca.id = a.idcategoria 
            GROUP BY a.idcategoria
            ORDER BY SUM(a.condicion) DESC 
            LIMIT 0 , 10');
        $mas_ingresados = DB::select('SELECT di.idarticulo, a.nombre, SUM(di.cantidad) AS TotalIngresos 
                    FROM detalle_ingresos as di 
                    JOIN articulos as a 
                    WHERE a.id = di.idarticulo 
                    GROUP BY di.idarticulo 
                    ORDER BY SUM(di.cantidad) DESC 
                    LIMIT 0 , 10');

            $mas_vendidos = DB::select('SELECT v.idarticulo, a.nombre, SUM(v.cantidad) AS TotalVentas 
                    FROM detalle_ventas as v 
                    JOIN articulos as a 
                    WHERE a.id = v.idarticulo 
                    GROUP BY v.idarticulo 
                    ORDER BY SUM(v.cantidad) DESC 
                    LIMIT 0 , 10');

            $articulos_prov = DB::select('SELECT pr.id, pr.nombre as nombre, COUNT(i.condicion) AS totalingreso
            FROM ingresos as i
            JOIN proveedores as pr
            WHERE pr.id = i.idproveedor
            GROUP BY i.idproveedor
            ORDER BY COUNT(i.condicion) DESC 
            LIMIT 0 , 10');

 
        return ['articulos_prov'=>$articulos_prov,'productos_cliente'=>$productos_cliente,'mas_vendidos'=>$mas_vendidos,'mas_ingresados'=>$mas_ingresados,'productos_area' => $productos_area,'articulos'=>$articulos];      
 
    }
}