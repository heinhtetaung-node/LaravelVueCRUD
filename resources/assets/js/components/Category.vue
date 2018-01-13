<template>
    <div>
        <h1>Category</h1>
        <div class="row">
          <div class="col-md-10"></div>
          <div class="col-md-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">
                  Create Category
                </button>
          </div>
        </div><br />
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
                    <td><router-link :to="{name: 'EditItem', params: { id: item.id }}" class="btn btn-primary">Edit</router-link></td>
                    <td><button class="btn btn-danger" v-on:click="deleteItem(item.id)">Delete</button></td>
                </tr>
            </tbody>
        </table>

        <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Create Item</h4>
              </div>
              <div class="modal-body">
                <form v-on:submit.prevent="addItem">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Item Name:</label>
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
                      <button class="btn btn-primary">Add Item</button>
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
    
    export default {
        data(){
            return{
                items: [],
                item:{}
            }
        },
        created: function()
        {
            this.fetchDatas();
        },
        methods: {
            fetchDatas(){
                var resitems = [];
                RestService.methods.fetchItems('items', this, function(response, obj) {
                    resitems = response;
                    obj.items = resitems;
                });
            },
            deleteItem(id)
            {
                RestService.methods.commonfunction(id);
                return false;
                let uri = `http://127.0.0.1:8000/items/${id}`;
                this.items.splice(id, 1);
                this.axios.delete(uri);
            },
            addItem(){
                let uri = 'http://127.0.0.1:8000/items';
                var para = this.item;
                RestService.methods.saveItems('items', para, this, function(response, obj) {
                    obj.fetchDatas();
                    obj.item = {};
                    $("#create-item").modal('hide');
                    //obj.items = resitems;
                });
            }
        }
    }
</script>