<template>
    <div class="container container-task">
        <div class="row">
            <div class="col-md-6">
                <h2>Lista de Productos</h2>
                <table class="table text-center"><!--Creamos una tabla que mostrará todas las tareas-->
                        <thead>
                            <tr>
                                <th scope="col">Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Category</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in arrayProducts" :key="product.id"> <!--Recorremos el array y cargamos nuestra tabla-->
                                <td v-text="product.code"></td>
                                <td v-text="product.name"></td>
                                <td v-text="product.quantity"></td>
                                <td v-text="product.category_name"></td> 
                                <!-- <td v-text="product.category_id"></td> -->
                                <td>
                                    <!--Botón modificar, que carga los datos del formulario con la tarea seleccionada-->
                                    <button class="btn" @click="loadFieldsUpdate(product)">Update</button>
                                    <!--Botón que borra la tarea que seleccionemos-->
                                    <button class="btn" @click="deleteProducts(product)">Delete</button>
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

                    <label>Quantity</label>
                    <input v-model="quantity" type="text" class="form-control">
                    <div style="padding: 4px"></div>
                    <label>Category</label>
                    <br>
                    <select v-model="category_id" class="form-control">
                        <option v-for="category in arrayCategories"  :key="category.id" v-bind:value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                    <!-- <input v-model="category_id" type="text" class="form-control"> -->

                </div>
                <div class="container-buttons">
                    <!-- Botón que añade los datos del formulario, solo se muestra si la variable update es igual a 0-->
                    <button v-if="update == 0" @click="saveProducts()" class="btn btn-success">Create</button>
                    <!-- Botón que modifica la tarea que anteriormente hemos seleccionado, solo se muestra si la variable update es diferente a 0-->
                    <button v-if="update != 0" @click="updateProducts()" class="btn btn-warning">Update</button>
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
                quantity:0,
                category_id:0,
                update:0, /*Esta variable contrarolará cuando es una nueva tarea o una modificación, si es 0 significará que no hemos seleccionado
                          ninguna tarea, pero si es diferente de 0 entonces tendrá el id de la tarea y no mostrará el boton guardar sino el modificar*/
                arrayProducts:[], //Este array contendrá las tareas de nuestra bd
                arrayCategories:[]
            }
        },
        methods:{
            getProducts(){
                console.log('getProducts');
                let me =this;
                let url = '/product' //Ruta que hemos creado para que nos devuelva todas las tareas
                axios.get(url).then(function (response) {
                    //creamos un array y guardamos el contenido que nos devuelve el response
                    me.arrayProducts = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            getCategories(){
                console.log('getCategories');
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
            getCategoryName(){
                console.log('getCategoryName');
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
            saveProducts(){
                console.log('saveProducts');
                let me =this;
                let url = '/product/store' //Ruta que hemos creado para enviar una tarea y guardarla
                axios.post(url,{ //estas variables son las que enviaremos para que crear la tarea
                    'code':this.code,
                    'name':this.name,
                    'quantity':this.quantity,
                    'category_id':this.category_id,
                }).then(function (response) {
                    me.getProducts();//llamamos al metodo getTask(); para que refresque nuestro array y muestro los nuevos datos
                    me.clearFields();//Limpiamos los campos e inicializamos la variable update a 0
                })
                .catch(function (error) {
                    console.log(error);
                });   

            },
            updateProducts(){/*Esta funcion, es igual que la anterior, solo que tambien envia la variable update que contiene el id de la
                tarea que queremos modificar*/
                console.log('updateProducts');
                let me = this;
                console.log("Update var: " + this.update);
                axios.put('/product/update',{
                    'id':this.update,
                    'code':this.code,
                    'name':this.name,
                    'quantity':this.quantity,
                    'category_id':this.category_id,
                }).then(function (response) {
                   me.getProducts();//llamamos al metodo getTask(); para que refresque nuestro array y muestro los nuevos datos
                   me.clearFields();//Limpiamos los campos e inicializamos la variable update a 0
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(data){ //Esta función rellena los campos y la variable update, con la tarea que queremos modificar
                console.log('loadFieldsUpdate');
                this.update = data.id;
                let me =this;
                console.log("Update var: " + this.update);
                let url = '/product/show?id='+ this.update;
                axios.get(url).then(function (response) {
                    // me.id = this.update;
                    me.code= response.data.code;
                    me.name= response.data.name;
                    me.quantity= response.data.quantity;
                    me.category_id= response.data.category_id;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                }); 
            },
            deleteProducts(data){//Esta nos abrirá un alert de javascript y si aceptamos borrará la tarea que hemos elegido
                console.log('deleteProducts');
                let me =this;
                let product_id = data.id
                if (confirm('¿Seguro que deseas borrar este producto?')) {
                    axios.delete('/product/destroy/'+product_id
                    ).then(function (response) {
                        me.getProducts();
                    })
                    .catch(function (error) {
                        console.log(error);
                    }); 
                }
            },
            clearFields(){/*Limpia los campos e inicializa la variable update a 0*/
                console.log('clearFields');
                this.code = "";
                this.name = "";
                this.quantity = 0;
                this.category_id = 0;
                this.update = 0;
            }
        },
        mounted() {
            console.log('mounted');
           this.getProducts();
           this.getCategories();
        }
    }
</script>
