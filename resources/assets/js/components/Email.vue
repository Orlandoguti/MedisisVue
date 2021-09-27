<template>
   <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Farmacia</a></li>
            </ol>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Recetario Electronico</div>
                    <div class="card-body">
                        <form>
                           <div class="form-group">
                                <label for="exampleInputEmail1">Paciente</label>
                         
                                        <select class="form-control" v-model="email">
                                            <option value="" disabled>Seleccione el Paciente</option>
                                            <option v-for="cliente in arrayCliente" :key="cliente.id" :value="cliente.email" v-text="cliente.nombre"></option>
                                        </select>                                        
                                   
                            </div>
                            <div class="form-group">
                                   <label for="exampleInputEmail1">Email</label>
                                    
                                        <input disabled type="email" v-model="email" class="form-control" placeholder="Email">
                            </div>

                             <div class="form-group">
                                   <label for="exampleInputEmail1">Receta</label>
                                   <br><textarea v-model="text" placeholder="Agregar Receta" style="height: 300px;padding: 10px;width: 100%;"></textarea>
                            </div>                           
                                                  
                            <loader v-show="showloader">                      
                            </loader>
                        </form>
                         <button type="button" class="btn btn-primary" @click="EnviarEmail()" >Enviar Correo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
</template>

<script>
    export default {
        data() {
            return {
                email : '',
                text  : '',
                subject  : '',
                arrayCliente : [],
                idcliente:'',
                showloader:false,
                pedido_id: 0,
                idpedido:'',
            }
        },
        methods: {

             
              EnviarEmail(){

                let me = this;
                var data = new FormData();
                data.append('subject', this.subject ='Farmacia - Modelo Boliviano Japones');
                data.append('email', this.email);
                data.append('text', this.text);
                data.append('producto', this.producto);
                data.append('detallep', this.detallep);
                me.arrayDetalle=[];
                this.showloader = true;

                swal({
                title: 'Esta seguro de Enviar este Recetario?',
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

               
                                    
                axios.post('/sendEmail', data).then((response) => {

                  this.showloader = false;

              swal(
                        'Actualizado!',
                        'El Recetario ha sido Enviado con éxito.',
                        'success'
                        )
                        this.ResetForm();
                    }).catch(function (error) {
                        console.log(error);
                    })
                    }
              })
                    
            },

            ResetForm(){
              this.idcliente='',
              this.subject='';
              this.email='';
              this.text='';
            },
            selectCliente(){
             let me=this;
                
                var url= '/cliente/selectCliente';
                axios.get(url).then(function (response) {                 
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCliente = respuesta.clientes;
                })
                
                .catch(function (error) {
                    console.log(error);
                });
            },
        },
       mounted() {
            this.selectCliente();
        }
    }
</script>
