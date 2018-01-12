<template>
    <div>
        <h1>Category</h1>
        <div class="row">
          <div class="col-md-10"></div>
          <div class="col-md-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-category">
                Create Category
                </button>
          </div>
        </div><br />
        <table class="table table-hover">
            <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Description</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody>
                <tr v-for="category in categories">
                    <td>{{ category.id }}</td>
                    <td>{{ category.name }}</td>
                    <td>{{ category.description }}</td>
                    <td><button class="btn btn-primary" v-on:click="editCategory(category)">Edit</button></td>
                    <td><button class="btn btn-danger" v-on:click="deleteCategory(category.id)">Delete</button></td>
                </tr>
            </tbody>
        </table>
        <!-- for pagination -->
        <nav>
            <ul class="pagination">
                <li v-if="pagination.current_page > 1">
                    <a href="#" aria-label="Previous"
                       v-on:click="fetchCategories(pagination.current_page - 1)">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
                <li v-for="page in pagesNumber"
                    v-bind:class="[ page == isActived ? 'active' : '']">
                    <a href="#"
                       v-on:click="fetchCategories(page)">{{ page }}</a>
                </li>
                <li v-if="pagination.current_page < pagination.last_page">
                    <a href="#" aria-label="Next"
                       v-on:click="fetchCategories(pagination.current_page + 1)">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- for create_category form -->
        <div class="modal fade" id="create-category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Create Category</h4>
              </div>
              <div class="modal-body">
                <form v-on:submit.prevent="addCategory">
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Category Name:</label>
                            <input type="text" class="form-control" v-model="category.name">
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" v-model="category.description">
                          </div>
                        </div>
                    </div>
                    <br />
                    <div class="form-group">
                      <button class="btn btn-primary">Add Category</button>
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
               
            } 
        },
        created: function()
        {
              this.fetchCategories();
        },
        methods: {
            fetchCategories(page = 1){
                this.pagination.current_page = page;
                var action = 'categories?page='+page;
                RestService.methods.fetchCategories(action, this, function(response, obj) {        
                 obj.categories = response.categories.data; 
                 obj.pagination = response.pagination;                   
                });                
            },
            addCategory(){
                    var para = this.category;
                    RestService.methods.saveItems('categories', para, this, function(response, obj) {
                        obj.fetchCategories();
                        obj.category = {};
                        $("#create-category").modal('hide');
                        //obj.items = resitems;
                    });
            },
            editCategory(obj){
                this.category = {
                    name : obj.name,
                    description : obj.description,
                     id : obj.id
                };
                $("#create-category").modal('show');
            },
            deleteCategory(id){
                confirm("Are you sure you want to delete?");
                var action = `categories/${id}`;
                RestService.methods.deleteCategory(action, this, function(response, obj){
                    obj.fetchCategories();
                });                
            },
        }        
    }
</script>