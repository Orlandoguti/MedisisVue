<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Articulo;

class ArticuloController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','articulos.precio_venta','articulos.precio_compra','articulos.stock','categorias.nombre as nombre_categoria','articulos.descripcion','articulos.condicion','articulos.imagen','articulos.fecha_hora')
            ->orderBy('articulos.id', 'desc')->paginate(5);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.precio_compra','articulos.stock','articulos.descripcion','articulos.condicion','articulos.imagen','articulos.fecha_hora')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'desc')->paginate(5);
        }
        

        return [
            'pagination' => [
                'total'        => $articulos->total(),
                'current_page' => $articulos->currentPage(),
                'per_page'     => $articulos->perPage(),
                'last_page'    => $articulos->lastPage(),
                'from'         => $articulos->firstItem(),
                'to'           => $articulos->lastItem(),
            ],
            'articulos' => $articulos
        ];
    }
    public function listarArticulo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.precio_compra','articulos.stock','articulos.descripcion','articulos.condicion','articulos.imagen')
            ->orderBy('articulos.id', 'desc')->paginate(6);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.precio_compra','articulos.stock','articulos.descripcion','articulos.condicion','articulos.imagen')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'desc')->paginate(6);
        }
        

        return [
            'pagination' => [
                'total'        => $articulos->total(),
                'current_page' => $articulos->currentPage(),
                'per_page'     => $articulos->perPage(),
                'last_page'    => $articulos->lastPage(),
                'from'         => $articulos->firstItem(),
                'to'           => $articulos->lastItem(),
            ],
            'articulos' => $articulos
        ];
    }
    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
         

        $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
        ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.precio_compra','articulos.stock','articulos.descripcion','articulos.condicion','articulos.imagen','articulos.fecha_hora','articulos.fecha_vencimiento')
        ->where('articulos.id','=',$id)
        ->orderBy('articulos.id', 'desc')->take(1)->get();

         
        return [
           
            'articulos' => $articulos
        ];
    }

    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
         
        $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
        ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.precio_compra','articulos.stock','articulos.descripcion','articulos.condicion','articulos.imagen','articulos.fecha_hora','articulos.fecha_vencimiento')
        ->where('articulos.id','=',$id)
        ->orderBy('articulos.id', 'desc')->get();

         
        return [
           
            'articulos' => $articulos
        ];
    }
    public function listarArticuloVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.precio_compra','articulos.stock','articulos.descripcion','articulos.condicion','articulos.imagen')
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.precio_compra','articulos.stock','articulos.descripcion','articulos.condicion','articulos.imagen')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $articulos->total(),
                'current_page' => $articulos->currentPage(),
                'per_page'     => $articulos->perPage(),
                'last_page'    => $articulos->lastPage(),
                'from'         => $articulos->firstItem(),
                'to'           => $articulos->lastItem(),
            ],
            'articulos' => $articulos
        ];
    }
    public function listarPdf(){
        $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
        ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.precio_compra','articulos.stock','articulos.descripcion','articulos.condicion')
        ->orderBy('articulos.nombre', 'desc')->get();

        $cont=Articulo::count();

        $pdf = \PDF::loadView('pdf.articulospdf',['articulos'=>$articulos,'cont'=>$cont]);
        return $pdf->download('articulos.pdf');
    }
    public function buscarArticulo(Request $request ){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo','=', $filtro)
        ->select('id', 'nombre')->orderBy('nombre', 'asc')->take(1)->get();

        return ['articulos' => $articulos];
    }
    public function buscarArticuloVenta(Request $request ){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo','=', $filtro)
        ->select('id', 'nombre','stock','precio_venta')
        ->where('stock','>','0')
        ->orderBy('nombre', 'asc')->take(1)->get();

        return ['articulos' => $articulos];
    }
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $mytime= Carbon::now('America/La_Paz');
        $articulo = new Articulo();
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->precio_compra = $request->precio_compra;
        $articulo->stock = $request->stock;
        $articulo->descripcion = $request->descripcion;
        $articulo->fecha_hora = $mytime->toDateTimeString();
        $articulo->fecha_vencimiento = $request->fecha_vencimiento;
        $fileData = $request->file('imagen');
        if(Input::hasfile('imagen')) {
            $fileName = time()."_".$fileData->getClientOriginalName();
            $fileData->move(public_path().'/img/articulos/', $fileName);
            $articulo->imagen = $fileName;
        }
        $articulo->condicion = '1';
        $articulo->save();
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_compra = $request->precio_compra;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '0';
        $articulo->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '1';
        $articulo->save();
    }

}
