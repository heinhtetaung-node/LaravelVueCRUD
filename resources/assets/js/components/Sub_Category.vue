<template>
    <div>
        <h1>Items</h1>
        <div class="row">
          <div class="col-md-10"></div>
          <div class="col-md-2">
            <br>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">
                  Create Category
                </button>
          </div>
        </div><br />

        <input type="text" v-on:change="fetchDatas()" v-model="filter.name" placeholder="name">
        <input type="text" v-on:change="fetchDatas()" v-model="filter.price" placeholder="price">

        <table class="table table-hover">
            <thead>
            <tr>
                <td>ID</td>
                <td>Category Name</td>
                <td>Description</td>
                <td>Parent Id</td>
                <td>Sub Parent Id</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
                <tr v-for="sub_category in sub_categories">
                    <td>{{ sub_category.id }}</td>
                    <td>{{ sub_category.name }}</td>
                    <td>{{ sub_category.description }}</td>
                    <td>{{ sub_category.parent_id }}</td>
                    <td>{{ sub_category.sub_parent_id }}</td>
                    <td><button class="btn btn-primary" v-on:click="editItem(sub_category)">Edit</button></td>
                    <td><button class="btn btn-danger" v-on:click="deleteItem(sub_category.id)">Delete</button></td>
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

        <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Item</h4>
              </div>
              <div class="modal-body">
                <form v-on:submit.prevent="addItem">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Name:</label>
                        <input type="hidden" v-model="item.id" />
                        <input type="text" class="form-control" v-model="sub_category.name">
                      </div>
                    </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">f
                        <div class="form-group">
                          <label>Parent:</label>
                          <input type="number" class="form-control col-md-6 qty" v-model="sub_category.parent_id" />
                        </div>
                      </div>
                    </div>
                    <!-- <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Item Price:</label>
                          <input type="text" class="form-control col-md-6" v-model="item.price" />
                        </div>
                      </div>
                    </div> -->
                    <!-- <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Total:</label>
                          <input type="text" disabled class="form-control col-md-6" v-model="settotal" />
                        </div>
                      </div>
                    </div> -->
                    <br />
                    <div class="form-group">
                      <button class="btn btn-primary">Save</button>
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
    //var RestService = require('./RestService.js');
    
    import CrudMain from './CrudMain.js';

    export default {
        extends: CrudMain,
        data(){
            return{
                filter : {'name':'', 'price':''}
            }
        },            

        created: function()
        {
        },
        computed: {
            settotal:function(){
                // confirm("hi");
                this.item.total=this.item.price*this.item.qty;
                return(this.item.price*this.item.qty);
            }
        },
        methods: {
            fetchDatas(page = 1){
                this.pagination.current_page = page;
                var filterurl = jQuery.param(this.filter);
                var action = 'items?page='+page+'&'+filterurl;
                RestService.methods.fetchItems(action, this, function(response, obj) {
                    obj.items = response.items.data;
                    obj.pagination = response.pagination;
                });                
            },
            deleteItem(id){
                confirm("are you sure you want to delete");
                var action = `items/${id}`;
                RestService.methods.deleteItem(action, this, function(response, obj){
                    obj.fetchDatas();
                });                
            },
            addItem(){
                var para = this.item;
                // console.log(para);
                RestService.methods.saveItems('items', para, this, function(response, obj) {
                    obj.fetchDatas();
                    obj.item = {};
                    $("#create-item").modal('hide');
                    //obj.items = resitems;
                });
            },
            editItem(obj){
                this.item = {
                    name : obj.name,
                    price : obj.price,
                    qty :obj.qty,
                    id : obj.id
                };
                $("#create-item").modal('show');
            }
        }
    }
</script>