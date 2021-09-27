<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
            <template v-if="listado==1">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Artículos
                        <button type="button" @click="abrirModal('articulo','registrar')" class="btn btn-primary float-right">
                            <i class="icon-plus"></i>&nbsp; Nuevo Articulo
                        </button>
                       
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-13">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarArticulo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarArticulo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                    <div class="table-responsive">
					 <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>Stock</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                    <td  <img class = "img-square" :src="'/img/articulos/' + articulo.imagen" width="70" height="70" @click="verArticulo(articulo.id)"></td>
                                    <td v-text="articulo.codigo"></td>
                                    <td v-text="articulo.nombre"></td>
                                    <td v-text="articulo.nombre_categoria"></td>
                                    <td v-text="articulo.precio_compra"></td>
                                    <td v-text="articulo.precio_venta"></td>
                                    <td>
                                         <div v-if="articulo.stock <= 3">
                                            <span class="badge badge-danger">Stock Bajo</span><br>
                                            <span v-text="articulo.stock"></span>
                                        </div>
                                        <div v-else>
                                            <span v-text="articulo.stock"></span>
                                        </div> 
                                    </td>
                                    <td v-text="articulo.descripcion"></td>
                                    <td>
                                        <div v-if="articulo.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>   
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('articulo','actualizar',articulo)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="articulo.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarArticulo(articulo.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarArticulo(articulo.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                         </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                               <button type="button" @click="cargarPdf()" class="btn btn-info float-right" style=" margin-right: 10px;">
                            <i class="icon-doc"></i>&nbsp; Generar Reporte
                        </button>
                        </nav>
                       
                    </div>
                </div>
             </template>
                <!-- Fin ejemplo de tabla Listado -->
        
                  <template v-else-if="listado==2">
                 <div class="card-header">
                        <i class="fa fa-align-justify"></i> Productos
                    </div>
                <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                    <div class="form-group row border">
                              <div class="table-responsive">
					 <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Nombre del Producto</th>
                                            <th>Categoria</th>
                                            <th>Descripcion</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayArticulo.length">
                                         <tr v-for="articulo in arrayArticulo"  :key="articulo.id">
                                            <td v-text="articulo.nombre"></td>
                                            <td v-text="articulo.nombre_categoria"></td>                                 
                                            <td v-text="articulo.descripcion"></td>                                            
                                        </tr>
                                    </tbody>                                
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row border">
                             <div class="table-responsive">
					 <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Fecha de Vencimiento</th>
                                            <th>Cantidad</th>
                                            <th>Fecha de Registro</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayArticulo.length">
                                         <tr v-for="articulo in arrayArticulo"  :key="articulo.id">
                                            <td v-text="articulo.fecha_vencimiento"></td>
                                            <td v-text="articulo.stock"></td>
                                            <td v-text="articulo.fecha_hora"></td>                                             
                                        </tr>
                                    </tbody>                                
                                </table>
                            </div>
                        </div>
                    </div>
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-2">
                                    <div class="form-group">
                                     </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div v-for="articulo in arrayArticulo" :key="articulo.id">
                                             <img class = "img-square" :src="'/img/articulos/' + articulo.imagen" width="200" height="200">
                                        </div>
                                     </div>
                                </div>
                               <div class="col-md-5">
                                    <label v-if="codigo" placeholder="Código de barras">
                                    <barcode :value="codigo" :options="{ format: 'EAN-13' }">
                                            Generando código de barras.    
                                    </barcode>                                       
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()"  class="btn btn-secondary">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </template>
                </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Categoría :</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idcategoria">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Código :</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="codigo" class="form-control" placeholder="Código de barras"> 
                                        <barcode :value="codigo" :options="{ format: 'EAN-13' }">
                                            Generando código de barras.    
                                        </barcode>                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre :</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de artículo">                                        
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Precio Compra :</label>
                                    <div class="col-md-9">
                                        <input  @keyup="operacion()" type="number" v-model="precio_compra" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Precio Venta :</label>
                                    <div class="col-md-9">
                                        <input disabled type="number" v-model="precio_venta" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Stock :</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="stock" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                     <label class="col-md-3 form-control-label" for="email-input">Fecha de Vencimiento: </label>
                                     <div class="col-md-9">
                                        <input type="date" v-model="fecha_vencimiento" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción :</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                </div>
                                <div class="form-group row">
                                     <label class="col-md-3 form-control-label" for="email-input">Seleccione la Imagen :</label>
                                    <div class="col-md-4">
                                    <input type="file" class="form-control" @change="obtimage">
                                </div>
                                <figure>
                                    <img width="200" height="200" :src="imagenm" alt="Foto del Producto">
                                </figure>
                                
                                </div>
                                <div v-show="errorArticulo" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarArticulo()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarArticulo()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    import VueBarcode from 'vue-barcode';
    export default {
        data (){
            return {
                listado: 1,
                articulo_id: 0,
                idcategoria : 0,
                nombre_categoria : '',
                codigo : '',
                nombre : '',
                precio_venta : 0,
                precio_compra: 0,
                stock : 0,
                descripcion : '',
                fecha_vencimiento:'',
                imagenmin:'',
                imagen:'',
                arrayArticulo : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorArticulo : 0,
                errorMostrarMsjArticulo : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : '',
                arrayCategoria :[]
            }
        },
        components: {
        'barcode': VueBarcode
    },
        computed:{
            imagenm(){
                return this.imagenmin;
            },
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
              ocultarDetalle(){
         
         
                this.listado=1;
            },
            verArticulo(id){
                let me=this;
                me.listado=2;

               var arrayArticulo=[];
                var url= '/articulo/obtenerCabecera?id=' + id;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayArticulo = respuesta.articulos;
                    
                    me.nombre = arrayArticulo[0]['nombre'];
                    me.codigo = arrayArticulo[0]['codigo'];
                    me.nombre_categoria = arrayArticulo[0]['nombre_categoria'];
                    me.nombre_estado = arrayArticulo[0]['nombre_estado'];
                    me.descripcion = arrayArticulo[0]['descripcion'];
                    me.fecha_vencimiento = arrayArticulo[0]['fecha_vencimiento'];

                })
                .catch(function (error) {
                    console.log(error);
                });
                //obtener datos de los detalles
                 var url= '/articulo/obtenerDetalles?id=' + id;

                axios.get(url).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos;

                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            obtimage(e){
                let file = e.target.files[0];
                this.imagen = file;
                this.cargarImagen(file);
            },

            cargarImagen(file){
                let reader = new FileReader();
                reader.onload = (e) =>{
                    this.imagenmin = e.target.result;
                }
                reader.readAsDataURL(file);
            },
            listarArticulo (page,buscar,criterio){
                let me=this;
                var url= '/articulo?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cargarPdf(){
                window.open('/articulo/listarPdf','_blank');
            },
            selectCategoria(){
                let me=this;
                var url= '/categoria/selectCategoria';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCategoria = respuesta.categorias;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarArticulo(page,buscar,criterio);
            },
             registrarArticulo(){
                if (this.validarArticulo()){
                    return;
                }
                swal({
                title: 'Esta seguro de Registrar este Producto?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                let me = this;
                let formData = new FormData();
                formData.append('idcategoria', this.idcategoria);
                formData.append('codigo', this.codigo);
                formData.append('nombre', this.nombre);
                formData.append('stock', this.stock);
                formData.append('precio_compra', this.precio_compra);
                formData.append('precio_venta', this.precio_venta);
                formData.append('descripcion', this.descripcion);
                formData.append('fecha_vencimiento', this.fecha_vencimiento);
                formData.append('imagen', this.imagen);

                axios.post('/articulo/registrar',formData).then(function (response) {
                    me.cerrarModal();
                    me.listarArticulo(1,'','nombre');
                 swal(
                        'Registrado!',
                        'El Producto se ha sido registrado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            operacion() {
            this.precio_venta = parseFloat(this.precio_compra*0.2) +
                parseFloat(this.precio_compra);           
        },
           
            actualizarArticulo(){
               if (this.validarArticulo()){
                    return;
                }
                
                let me = this;

                axios.put('/articulo/actualizar',{
                    'idcategoria': this.idcategoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'stock': this.stock,
                    'precio_venta': this.precio_venta,
                    'precio_compra': this.precio_compra,
                    'fecha_vencimiento': this.fecha_vencimiento,
                    
                    'descripcion': this.descripcion,
                    'id': this.articulo_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarArticulo(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarArticulo(id){
               swal({
                title: 'Esta seguro de desactivar este artículo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/articulo/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarArticulo(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarArticulo(id){
               swal({
                title: 'Esta seguro de activar este artículo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/articulo/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarArticulo(1,'','nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarArticulo(){
                this.errorArticulo=0;
                this.errorMostrarMsjArticulo =[];

                if (this.idcategoria==0) this.errorMostrarMsjArticulo.push("Seleccione una categoría.");
                if (!this.nombre) this.errorMostrarMsjArticulo.push("El nombre del artículo no puede estar vacío.");
                if (!this.stock) this.errorMostrarMsjArticulo.push("El stock del artículo debe ser un número y no puede estar vacío.");
                if (!this.precio_venta) this.errorMostrarMsjArticulo.push("El precio venta del artículo debe ser un número y no puede estar vacío.");

                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;

                return this.errorArticulo;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.idcategoria= 0;
                this.nombre_categoria = '';
                this.codigo = '';
                this.nombre = '';
                this.precio_venta = 0;
                this.stock = 0;
                this.descripcion = '';
                this.fecha_vencimiento = '';
		        this.errorArticulo=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "articulo":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Artículo';
                                this.idcategoria=0;
                                this.nombre_categoria='';
                                this.codigo='';
                                this.nombre= '';
                                this.precio_venta=0;
                                this.precio_compra=0;
                                this.stock=0;
                                this.descripcion = '';                                
                                this.imagen = '';
                                this.imagenmin = '';
                                this.fecha_vencimiento = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Artículo';
                                this.tipoAccion=2;
                                this.articulo_id=data['id'];
                                this.idcategoria=data['idcategoria'];
                                this.codigo=data['codigo'];
                                this.nombre = data['nombre'];
                                this.stock=data['stock'];
                                this.precio_venta=data['precio_venta'];
                                this.precio_compra=data['precio_compra'];
                                this.descripcion= data['descripcion'];
                                this.fecha_vencimiento= data['fecha_vencimiento'];
                                break;
                            }
                        }
                    }
                }
                this.selectCategoria();
            }
        },
        mounted() {
            this.listarArticulo(1,this.buscar,this.criterio);
            this.operacion();
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: rgb(13, 123, 240) !important;
        font-weight: bold;
    }
</style>
