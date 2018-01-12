<template>
    <div>
        <h1>supplier</h1>
        <div class="row">
          <div class="col-md-10"></div>
          <div class="col-md-2">
            <button type="button" v-on:click="" class="btn btn-success" data-toggle="modal" data-target="#create-supplier">
                  Create supplier
                </button>
          </div>change
        </div><br />

        <input type="text" v-on:="fetchDatas()" v-model="filter.name" placeholder="name">
        <input type="text" v-on:change="fetchDatas()" v-model="filter.email" placeholder="email">

        <table class="table table-hover">
            <thead>
            <tr>
                <td>ID</td>
                <td>supplier Name</td>
                <td>Email</td>
                <td>Address</td>
                <td>Phone-No</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody>
                <tr v-for="supplier in suppliers">
                    <td>{{ supplier.id }}</td>
                    <td>{{ supplier.name }}</td>
                    <td>{{ supplier.email }}</td>
                    <td>{{ supplier.address}}</td>
                    <td>{{ supplier.phone}}</td>
                    <td><button class="btn btn-primary" v-on:click="editSupplier(supplier)">Edit</button></td>
                    <td><button class="btn btn-danger" v-on:click="deleteSupplier(supplier.id)">Delete</button></td>
                </tr>
            </tbody>
        </table>
        <nav>
            <ul class="pagination">
                <li v-if="pagination.current_page > 1">
                    <a href="#" aria-label="Previous"
                       v-on:click="fetchDatas(pagination.current_page - 1)">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
                <li v-for="page in pagesNumber"
                    v-bind:class="[ page == isActived ? 'active' : '']">
                    <a href="#"
                       v-on:click="fetchDatas(page)">{{ page }}</a>
                </li>
                <li v-if="pagination.current_page < pagination.last_page">
                    <a href="#" aria-label="Next"
                       v-on:click="fetchDatas(pagination.current_page + 1)">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="modal fade" id="create-supplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Create supplier</h4>
              </div>
              <div class="modal-body">
                <form v-on:submit.prevent="addSupplier">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>supplier Name:</label>
                        <input type="text" class="form-control" v-model="supplier.name">
                        <span v-if="errors.name" class="error text-danger">{{ errors.name }}</span> 
                      </div>
                    </div></br>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>supplier's Email:</label>
                          <input type="text" class="form-control col-md-6" v-model="supplier.email" /> 
                        </div>
                        <span v-if="errors.email" class="error text-danger">{{ errors.email }}</span> 
                      </div>
                    </div></br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Address:</label>
                          <textarea class="form-control col-md-6" v-model="supplier.address" ></textarea>
                        </div>
                        <span v-if="errors.address" class="error text-danger">{{ errors.address}}</span>
                      </div>
                    </div></br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Phone-No :</label>
                          <input type="text" class="form-control col-md-6" v-model="supplier.phone" />
                        </div>
                         <span v-if="errors.phone" class="error text-danger">{{ errors.phone }}</span> 
                      </div>
                    </div><br />
                    <div class="form-group">
                      <button class="btn btn-primary">Save </button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>
<script>

    import RestService from './RestService.js';
    import CrudMain from './CrudMain.js';
    //var RestService = require('./RestService.js');

    export default {
        extends:CrudMain,
        data(){
            return{
                filter : {'name':'', 'email':''},
                errors : {},
            }
        },
        created: function()
        {

        },
        methods: {
            fetchDatas(page=1){
              this.pagination.current_page = page;
              var filterurl = jQuery.param(this.filter);
              var action = 'supplierApi?page='+page+'&'+filterurl;
              RestService.methods.fetchItems(action, this, function(response, obj) {
                  obj.suppliers = response.suppliers.data;
                  obj.pagination = response.pagination;
                  // console.log(response
              });
            },
            deleteSupplier(id)
            {
                confirm("are you sure you want to delete");
                var action = `supplierApi/${id}`;
                RestService.methods.deleteItem(action, this, function(response, obj){
                    obj.fetchDatas();
                });     
            },
            addSupplier(){
                var para = this.supplier;
                RestService.methods.saveItems('supplierApi', para, this, function(response, obj) {
                    if(response.result==false){
                        obj.errors = response.errors;
                        return false;
                    }  
                    obj.fetchDatas();
                    obj.supplier = {};
                    obj.errors = {};
                    $("#create-supplier").modal('hide');
                    //obj.suppliers = ressuppliers;
                });
            },
            editSupplier(obj){
                this.supplier = {
                    name : obj.name,
                    email : obj.email,
                    address :obj.address,
                    phone:obj.phone,
                    id : obj.id
                };
                $("#create-supplier").modal('show');
            }
        }
    }
</script>
