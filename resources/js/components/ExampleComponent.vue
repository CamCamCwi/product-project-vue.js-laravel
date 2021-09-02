<template>
    <div class="container container-task">
        <div class="row">
            <div class="col-md-6">
                <h2>Lista de categorias</h2>
                <table class="table text-center"><!--Creamos una tabla que mostrará todas las tareas-->
                        <thead>
                            <tr>
                                <th scope="col">Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="category in arrayCategories" :key="category.id"> <!--Recorremos el array y cargamos nuestra tabla-->
                                <td v-text="category.code"></td>
                                <td v-text="category.name"></td>
                                <td>
                                    <!--Botón modificar, que carga los datos del formulario con la tarea seleccionada-->
                                    <button class="btn" @click="loadFieldsUpdate(category)">Update</button>
                                    <!--Botón que borra la tarea que seleccionemos-->
                                    <button class="btn" @click="deleteCategory(category)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            <div class="col-md-6">
                <div class="form-group"><!-- Formulario para la creación o modificación de nuestras tareas-->
                    <label>Code</label>
                    <input v-model="code" type="text" class="form-control">

                    <label>Name</label>
                    <input v-model="name" type="text" class="form-control">

                </div>
                <div class="container-buttons">
                    <!-- Botón que añade los datos del formulario, solo se muestra si la variable update es igual a 0-->
                    <button v-if="update == 0" @click="saveCategories()" class="btn btn-success">Create</button>
                    <!-- Botón que modifica la tarea que anteriormente hemos seleccionado, solo se muestra si la variable update es diferente a 0-->
                    <button v-if="update != 0" @click="updateCategories()" class="btn btn-warning">Update</button>
                    <!-- Botón que limpia el formulario y inicializa la variable a 0, solo se muestra si la variable update es diferente a 0-->
                    <button v-if="update != 0" @click="clearFields()" class="btn">Back</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                code:"",
                name:"", //Esta variable, mediante v-model esta relacionada con el input del formulario
                update:0, /*Esta variable contrarolará cuando es una nueva tarea o una modificación, si es 0 significará que no hemos seleccionado
                          ninguna tarea, pero si es diferente de 0 entonces tendrá el id de la tarea y no mostrará el boton guardar sino el modificar*/
                arrayCategories:[], //Este array contendrá las tareas de nuestra bd
            }
        },
        methods:{
            getCategories(){
                console.log('2423423');
                let me =this;
                let url = '/category' //Ruta que hemos creado para que nos devuelva todas las tareas
                axios.get(url).then(function (response) {
                    //creamos un array y guardamos el contenido que nos devuelve el response
                    me.arrayCategories = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            saveCategories(){
                let me =this;
                let url = '/category/store' //Ruta que hemos creado para enviar una tarea y guardarla
                axios.post(url,{ //estas variables son las que enviaremos para que crear la tarea
                    'code':this.code,
                    'name':this.name,
                }).then(function (response) {
                    me.getCategories();//llamamos al metodo getTask(); para que refresque nuestro array y muestro los nuevos datos
                    me.clearFields();//Limpiamos los campos e inicializamos la variable update a 0
                })
                .catch(function (error) {
                    console.log(error);
                });   

            },
            updateCategories(){/*Esta funcion, es igual que la anterior, solo que tambien envia la variable update que contiene el id de la
                tarea que queremos modificar*/
                let me = this;
                console.log("Update var: " + this.update);
                axios.put('/category/update',{
                    'id':this.update,
                    'code':this.code,
                    'name':this.name,
                }).then(function (response) {
                   me.getCategories();//llamamos al metodo getTask(); para que refresque nuestro array y muestro los nuevos datos
                   me.clearFields();//Limpiamos los campos e inicializamos la variable update a 0
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(data){ //Esta función rellena los campos y la variable update, con la tarea que queremos modificar

                this.update = data.id;
                let me =this;
                console.log("Update var: " + this.update);
                let url = '/category/show?id='+ this.update;
                axios.get(url).then(function (response) {
                    // me.id = this.update;
                    me.code= response.data.code;
                    me.name= response.data.name;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                }); 
            },
            deleteCategory(data){//Esta nos abrirá un alert de javascript y si aceptamos borrará la tarea que hemos elegido

                let me =this;
                let category_id = data.id
                if (confirm('¿Seguro que deseas borrar esta categoria?')) {
                    axios.delete('/category/destroy/'+category_id
                    ).then(function (response) {
                        me.getCategories();
                    })
                    .catch(function (error) {
                        console.log(error);
                    }); 
                }
            },
            clearFields(){/*Limpia los campos e inicializa la variable update a 0*/

                this.code = "";
                this.name = "";
                this.update = 0;
            }
        },
        mounted() {

           this.getCategories();
        }
    }
</script>
