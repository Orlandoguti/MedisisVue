<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
use App\Proveedor;
 
 
class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $proveedores = Proveedor::select('proveedores.id','proveedores.nombre','proveedores.tipo_documento',
            'proveedores.num_documento','proveedores.direccion','proveedores.telefono',
            'proveedores.email','proveedores.contacto','proveedores.telefono_contacto','proveedores.condicion')
            ->orderBy('proveedores.id', 'desc')->paginate(3);
        }
        else{
            $proveedores = Proveedor::select('proveedores.id','proveedores.nombre','proveedores.tipo_documento',
            'proveedores.num_documento','proveedores.direccion','proveedores.telefono',
            'proveedores.email','proveedores.contacto','proveedores.telefono_contacto','proveedores.condicion')            
            ->where('proveedores.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('proveedores.id', 'desc')->paginate(3);
        }
         
 
        return [
            'pagination' => [
                'total'        => $proveedores->total(),
                'current_page' => $proveedores->currentPage(),
                'per_page'     => $proveedores->perPage(),
                'last_page'    => $proveedores->lastPage(),
                'from'         => $proveedores->firstItem(),
                'to'           => $proveedores->lastItem(),
            ],
            'proveedores' => $proveedores
        ];
    }
 
    public function selectProveedor(Request $request){
      
        if (!$request->ajax()) return redirect('/');
        $proveedores = Proveedor::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['proveedores' => $proveedores];
    }
 
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
         
            $proveedor = new Proveedor();
            $proveedor->contacto = $request->contacto;
            $proveedor->telefono_contacto = $request->telefono_contacto;
            $proveedor->nombre = $request->nombre;
            $proveedor->tipo_documento = $request->tipo_documento;
            $proveedor->num_documento = $request->num_documento;
            $proveedor->direccion = $request->direccion;
            $proveedor->telefono = $request->telefono;
            $proveedor->email = $request->email;
            $categoria->condicion = '1';
            $proveedor->save();         
         
    }
 
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
            //Buscar primero el proveedor a modificar
            $proveedor = Proveedor::findOrFail($request->id);
 
            $proveedor->contacto = $request->contacto;
            $proveedor->telefono_contacto = $request->telefono_contacto;
            $proveedor->nombre = $request->nombre;
            $proveedor->tipo_documento = $request->tipo_documento;
            $proveedor->num_documento = $request->num_documento;
            $proveedor->direccion = $request->direccion;
            $proveedor->telefono = $request->telefono;
            $proveedor->email = $request->email;
            $categoria->condicion = '1';
            $proveedor->save(); 
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $proveedor = Proveedor::findOrFail($request->id);
        $proveedor->condicion = '0';
        $proveedor->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $proveedor = Proveedor::findOrFail($request->id);
        $proveedor->condicion = '1';
        $proveedor->save();
    }
}