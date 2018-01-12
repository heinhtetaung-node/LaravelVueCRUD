<template>
    <div>
        <h1>Items Transition</h1>
        <div class="row">
          <div class="col-md-10"></div>
          <div class="col-md-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">
                  Create Item
                </button>
          </div>
        </div><br />

        <input type="text" v-on:change="fetchDatas()" v-model="filter.name" placeholder="name">
        <input type="text" v-on:change="fetchDatas()" v-model="filter.price" placeholder="price">

        <table class="table table-hover">
            <thead>
            <tr>
                <td>ID</td>
                <td>Item Name</td>
                <td>Item Price</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody>
                <tr v-for="item in items">
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.price }}</td>
                    <td><button class="btn btn-primary" v-on:click="editItem(item)">Edit</button></td>
                    <td><button class="btn btn-danger" v-on:click="deleteItem(item.id)">Delete</button></td>
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
                        <label>Item Name:</label>
                        <input type="hidden" v-model="item.id" />
                        <input type="text" class="form-control" v-model="item.name">
                      </div>
                    </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Item Price:</label>
                          <input type="text" class="form-control col-md-6" v-model="item.price" />
                        </div>
                      </div>
                    </div><br />
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
                
            }
        },
        created: function()
        {
            
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
                    id : obj.id
                };
                $("#create-item").modal('show');
            }
        }
    }
</script>