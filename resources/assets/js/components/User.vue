<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Usuarios
                        <button type="button" @click="abrirModal('user','registrar')" class="btn btn-primary float-right">
                            <i class="icon-plus"></i>&nbsp;Nuevo Usuario
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-13">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="num_documento">Documento</option>
                                      <option value="email">Email</option>
                                      <option value="telefono">Teléfono</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarUser(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarUser(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                    <div class="table-responsive">
					 <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tipo Documento</th>
                                    <th>Número de Documento</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in arrayUser" :key="user.id">
                                    <td v-text="user.nombre"></td>
                                    <td v-text="user.tipo_documento"></td>
                                    <td v-text="user.num_documento"></td>
                                    <td v-text="user.direccion"></td>
                                    <td v-text="user.telefono"></td>
                                    <td v-text="user.email"></td>
                                    <td v-text="user.rol"></td>                                    
                                    <td>
                                        <button type="button" @click="abrirModal('user','actualizar',user)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="user.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarUsuario(user.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarUsuario(user.id)">
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
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
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
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre(*)</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del Usuario">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo documento</label>
                                    <div class="col-md-9">
                                        <select v-model="tipo_documento" class="form-control">
                                            <option value="CI">CI</option>
                                            <option value="PASAPORTE">PASAPORTE</option>
                                            <option value="RUC">RUC</option>
                                        </select>                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Número documento</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="num_documento" class="form-control" placeholder="Número de documento">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Dirección</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="direccion" class="form-control" placeholder="Dirección">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Teléfono</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="telefono" class="form-control" placeholder="Teléfono">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Role</label>
                                    <div class="col-md-9">
                                        <select v-model="idrol" class="form-control">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="role in arrayRol" :key="role.id" :value="role.id" v-text="role.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Usuario</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="usuario" class="form-control" placeholder="Nombre del usuario">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">password</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" class="form-control" placeholder="password del usuario">
                                    </div>
                                </div>
                                <div v-show="errorUser" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjUser" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarUser()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarUser()">Actualizar</button>
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
    export default {
        data (){
            return {
                user_id: 0,
                nombre : '',
                tipo_documento : '',
                num_documento : '',
                direccion : '',
                telefono : '',
                email : '',
                usuario: '',
                password:'',
                idrol: '',
                arrayUser : [],
                arrayRol : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorUser : 0,
                errorMostrarMsjUser : [],
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
                buscar : ''
            }
        },
        computed:{
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
            listarUser (page,buscar,criterio){
                let me=this;
                var url= '/user?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayUser = respuesta.users.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectRol(){
                let me=this;
                var url= '/rol/selectRol';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayRol = respuesta.roles;
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
                me.listarUser(page,buscar,criterio);
            },
               registrarUser(){
                if (this.validarUser()){
                    return;
                }
                
                let me = this;

                let formData = new FormData();

               
                if(me.idrol==1){
                formData.append('nombre', this.nombre);
                formData.append('tipo_documento', this.tipo_documento);
                formData.append('num_documento', this.num_documento);
                formData.append('direccion', this.direccion);
                formData.append('telefono', this.telefono);
                formData.append('email', this.email);
                formData.append('idrol', this.idrol);
                formData.append('usuario', this.usuario);
                formData.append('password', this.password);
                formData.append('rolnombre', this.rolnombre='Administrador');
                formData.append('nombreuser', this.nombreuser = this.nombre);

                swal({
                title: 'Esta seguro de Registrar a este Usuario?',
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

                axios.post('/user/registrar',formData).then(function (response) {
                    me.cerrarModal();
                    me.listarUser(1,'','nombre');
               swal(
                        'Registrado!',
                        'El Usuario ha sido Registrado con éxito.',
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
             }else{
                 if(me.idrol==2){
                      formData.append('nombre', this.nombre);
                formData.append('tipo_documento', this.tipo_documento);
                formData.append('num_documento', this.num_documento);
                formData.append('direccion', this.direccion);
                formData.append('telefono', this.telefono);
                formData.append('email', this.email);
                formData.append('idrol', this.idrol);
                formData.append('usuario', this.usuario);
                formData.append('password', this.password);
                formData.append('rolnombre', this.rolnombre='Almacenero');
                formData.append('nombreuser', this.nombreuser = this.nombre);

                 swal({
                title: 'Esta seguro de Registrar a este Usuario?',
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

                axios.post('/user/registrar',formData).then(function (response) {
                    me.cerrarModal();
                    me.listarUser(1,'','nombre');
              swal(
                        'Registrado!',
                        'El Usuario ha sido Registrado con éxito.',
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

           }else{
               if(me.idrol==3){
                          formData.append('nombre', this.nombre);
                formData.append('tipo_documento', this.tipo_documento);
                formData.append('num_documento', this.num_documento);
                formData.append('direccion', this.direccion);
                formData.append('telefono', this.telefono);
                formData.append('email', this.email);
                formData.append('idrol', this.idrol);
                formData.append('usuario', this.usuario);
                formData.append('password', this.password);
                formData.append('rolnombre', this.rolnombre='Administrador de Area');
                 formData.append('nombreuser', this.nombreuser = this.nombre);

                 swal({
                title: 'Esta seguro de Registrar a este Usuario?',
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


                axios.post('/user/registrar',formData).then(function (response) {
                    me.cerrarModal();
                    me.listarUser(1,'','nombre');
               swal(
                        'Registrado!',
                        'El Usuario ha sido Registrado con éxito.',
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


               }
           }
             }
            },
     actualizarUser(){
               if (this.validarUser()){
                    return;
                }
                
            let me = this;
            let formData = new FormData();
            if(me.idrol==1){
              
                formData.append('nombre', this.nombre);
                formData.append('tipo_documento', this.tipo_documento);
                formData.append('num_documento', this.num_documento);
                formData.append('direccion', this.direccion);
                formData.append('telefono', this.telefono);
                formData.append('email', this.email);
                formData.append('idrol', this.idrol);
                formData.append('usuario', this.usuario);
                formData.append('password', this.password);
                formData.append('id', this.user_id);
                formData.append('rolnombre', this.rolnombre='Administrador');
                formData.append('nombreuser', this.nombreuser = this.nombre);
                
                 swal({
                title: 'Esta seguro de Actualizar a este Usuario?',
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
                axios.post('/user/actualizar',formData).then(function (response) {
                    me.cerrarModal();
                    me.listarUser(1,'','nombre');
                  swal(
                        'Actualizado!',
                        'El Usuario ha sido Actualizado con éxito.',
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
                }else{
                    if(me.idrol==2){
                formData.append('nombre', this.nombre);
                formData.append('tipo_documento', this.tipo_documento);
                formData.append('num_documento', this.num_documento);
                formData.append('direccion', this.direccion);
                formData.append('telefono', this.telefono);
                formData.append('email', this.email);
                formData.append('idrol', this.idrol);
                formData.append('usuario', this.usuario);
                formData.append('password', this.password);
                formData.append('id', this.user_id);
                formData.append('rolnombre', this.rolnombre='Vendedor');
                formData.append('nombreuser', this.nombreuser = this.nombre);
                swal({
                title: 'Esta seguro de Actualizar a este Usuario?',
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

                axios.post('/user/actualizar',formData).then(function (response) {
                    me.cerrarModal();
                    me.listarUser(1,'','nombre');
                  swal(
                        'Actualizado!',
                        'El Usuario ha sido Actualizado con éxito.',
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
                }else{
                    if(me.idrol==3){
                formData.append('nombre', this.nombre);
                formData.append('tipo_documento', this.tipo_documento);
                formData.append('num_documento', this.num_documento);
                formData.append('direccion', this.direccion);
                formData.append('telefono', this.telefono);
                formData.append('email', this.email);
                formData.append('idrol', this.idrol);
                formData.append('usuario', this.usuario);
                formData.append('password', this.password);
                formData.append('id', this.user_id);
                formData.append('rolnombre', this.rolnombre='Almacenero');
                formData.append('nombreuser', this.nombreuser = this.nombre);
                swal({
                title: 'Esta seguro de Actualizar a este Usuario?',
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
                  axios.post('/user/actualizar',formData).then(function (response) {
                    me.cerrarModal();
                    me.listarUser(1,'','nombre');
                swal(
                        'Actualizado!',
                        'El Usuario ha sido Actualizado con éxito.',
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
                    }
                }
                }
            },
          validarUser(){
                this.errorUser=0;
                this.errorMostrarMsjUser =[];
                if (!this.nombre) {
                    swal ( " ¡El Nombre no puede estar Vacio! " );
                }else{
                    if (!this.usuario){
                        swal ( " ¡El Nombre de Usuario no puede estar Vacio! " );
                    }else{
                          if (!this.password) {
                              swal ( " ¡El Password del Usuario no puede estar Vacio! " );
                          }else{
                               if (this.idrol==0) {
                                   swal ( " ¡Seleccione un Rol! " );
                               }else{
                                   if(this.tipo_documento==0){
                                       swal ( " ¡Seleccione un El tipo de Documento! " );
                                   }else{
                                       if(this.num_documento==0){
                                            swal ( " ¡Ingrese el numero de Documento! " );
                                       }else{
                                           if(this.direccion==0){
                                            swal ( " ¡Ingrese Una Direccion! " );
                                           }else{
                                               if(this.telefono==0){
                                                swal ( " ¡Ingrese Un Numero de Telefono! " );
                                               }else{
                                                   if(this.email==0){
                                                       swal ( " ¡Ingrese el Email del Usuario! " );
                                                   }
                                               }
                                           }
                                       }
                                   }
                               }
                          }
                    }
                } 
                
                if (!this.nombre) this.errorMostrarMsjUser.push("");
                if (!this.usuario) this.errorMostrarMsjUser.push("");
                if (!this.password) this.errorMostrarMsjUser.push("");
                if (this.idrol==0) this.errorMostrarMsjUser.push("");
                if (this.tipo_documento==0) this.errorMostrarMsjUser.push("");
                if (this.num_documento==0) this.errorMostrarMsjUser.push("");
                if (this.direccion==0) this.errorMostrarMsjUser.push("");
                if (this.telefono==0) this.errorMostrarMsjUser.push("");
                if (this.email==0) this.errorMostrarMsjUser.push("");
                
                if (this.errorMostrarMsjUser.length) this.errorUser = 1;

                return this.errorUser;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.tipo_documento='CI';
                this.num_documento='';
                this.direccion='';
                this.telefono='';
                this.email='';
                this.usuario='';
                this.password='';
                this.idrol=0;
                this.errorUser=0;
            },
            abrirModal(modelo, accion, data = []){
                this.selectRol();
                switch(modelo){
                    case "user":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Usuario';
                                this.nombre= '';
                                this.tipo_documento='CI';
                                this.num_documento='';
                                this.direccion='';
                                this.telefono='';
                                this.email='';
                                this.usuario='';
                                this.password='';
                                this.idrol=0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Usuario';
                                this.tipoAccion=2;
                                this.user_id=data['id'];
                                this.nombre = data['nombre'];
                                this.tipo_documento = data['tipo_documento'];
                                this.num_documento = data['num_documento'];
                                this.direccion = data['direccion'];
                                this.telefono = data['telefono'];
                                this.email = data['email'];
                                this.usuario = data['usuario'];
                                this.password=data['password'];
                                this.idrol=data['idrol'];
                                break;
                            }
                        }
                    }
                }
            },
            desactivarUsuario(id){
               swal({
                title: 'Esta seguro de desactivar este usuario?',
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

                    axios.put('/user/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarUser(1,'','nombre');
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
            activarUsuario(id){
               swal({
                title: 'Esta seguro de activar este usuario?',
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

                    axios.put('/user/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarUser(1,'','nombre');
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
        },
        mounted() {
            this.listarUser(1,this.buscar,this.criterio);
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
