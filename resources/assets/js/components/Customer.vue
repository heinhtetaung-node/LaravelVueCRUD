<template>
    <div>
        <h1>Customer</h1>
        <div class="row">
          <div class="col-md-10"></div>
          <div class="col-md-2">
            <button type="button" v-on:click="customer={};errors={}" class="btn btn-success" data-toggle="modal" data-target="#create-customer">
                  Create Customer
                </button>
          </div>change
        </div><br />

        <input type="text" v-on:="fetchDatas()" v-model="filter.name" placeholder="name">
        <input type="text" v-on:change="fetchDatas()" v-model="filter.email" placeholder="email">

        <table class="table table-hover">
            <thead>
            <tr>
                <td>ID</td>
                <td>Customer Name</td>
                <td>Email</td>
                <td>Address</td>
                <td>Phone-No</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody>
                <tr v-for="customer in customers">
                    <td>{{ customer.id }}</td>
                    <td>{{ customer.name }}</td>
                    <td>{{ customer.email }}</td>
                    <td>{{ customer.address}}</td>
                    <td>{{ customer.phone}}</td>
                    <td><button class="btn btn-primary" v-on:click="editCustomer(customer)">Edit</button></td>
                    <td><button class="btn btn-danger" v-on:click="deleteCustomer(customer.id)">Delete</button></td>
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

        <div class="modal fade" id="create-customer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Create Customer</h4>
              </div>
              <div class="modal-body">
                <form v-on:submit.prevent="addCustomer">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Customer Name:</label>
                        <input type="text" class="form-control" v-model="customer.name">
                        <span v-if="errors.name" class="error text-danger">{{ errors.name }}</span> 
                      </div>
                    </div></br>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Customer's Email:</label>
                          <input type="text" class="form-control col-md-6" v-model="customer.email" /> 
                        </div>
                        <span v-if="errors.email" class="error text-danger">{{ errors.email }}</span> 
                      </div>
                    </div></br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Address:</label>
                          <textarea class="form-control col-md-6" v-model="customer.address" ></textarea>
                        </div>
                        <span v-if="errors.address" class="error text-danger">{{ errors.address}}</span>
                      </div>
                    </div></br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Phone-No :</label>
                          <input type="text" class="form-control col-md-6" v-model="customer.phone" />
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
              var action = 'CustomerApi?page='+page+'&'+filterurl;
              RestService.methods.fetchItems(action, this, function(response, obj) {
                  obj.customers = response.customers.data;
                  obj.pagination = response.pagination;
                  // console.log(response
              });
            },
            deleteCustomer(id)
            {
                confirm("are you sure you want to delete");
                var action = `CustomerApi/${id}`;
                RestService.methods.deleteItem(action, this, function(response, obj){
                    obj.fetchDatas();
                });     
            },
            addCustomer(){
                var para = this.customer;
                RestService.methods.saveItems('CustomerApi', para, this, function(response, obj) {
                    if(response.result==false){
                        obj.errors = response.errors;
                        return false;
                    }  
                    obj.fetchDatas();
                    obj.customer = {};
                    obj.errors = {};
                    $("#create-customer").modal('hide');
                    //obj.customers = rescustomers;
                });
            },
            editCustomer(obj){
                this.customer = {
                    name : obj.name,
                    email : obj.email,
                    address :obj.address,
                    phone:obj.phone,
                    id : obj.id
                };
                $("#create-customer").modal('show');
            }
        }
    }
</script>
