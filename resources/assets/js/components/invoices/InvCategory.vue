<template>
    <div>
        <h1>category</h1>
        <div class="row">
          <div class="col-md-10"></div>
          <div class="col-md-2">
            <button type="button" v-on:click="category={};errors={}" class="btn btn-success" data-toggle="modal" data-target="#create-category">
                  Create category
                </button>
          </div>change
        </div><br />

        <input type="text" v-on:="fetchDatas()" v-model="filter.name" placeholder="name">

        <table class="table table-hover">
            <thead>
            <tr>
                <td>ID</td>
                <td>Category Name</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody>
                <tr v-for="category in categorys">
                    <td>{{ category.id }}</td>
                    <td>{{ category.name }}</td>
                    <td><button class="btn btn-primary" v-on:click="editCategory(category)">Edit</button></td>
                    <td><button class="btn btn-danger" v-on:click="deleteCategory(category.id)">Delete</button></td>
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

        <div class="modal fade" id="create-category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Create category</h4>
              </div>
              <div class="modal-body">
                <form v-on:submit.prevent="addcategory">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>category Name:</label>
                        <input type="text" class="form-control" v-model="category.name">
                        <span v-if="errors.name" class="error text-danger">{{ errors.name }}</span> 
                      </div>
                    </div></br>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>category's Email:</label>
                          <select class="form-control col-md-6" v-model="category.parent_id">
                               <option>A</option>
                               <option>B</option>
                          </select>
                        </div>
                        <span v-if="errors.parent_id" class="error text-danger">{{ errors.parent_id }}</span> 
                      </div>
                    </div></br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Description :</label>
                          <textarea class="form-control col-md-6" v-model="category.description" ></textarea>
                        </div>
                        <span v-if="errors.description" class="error text-danger">{{ errors.description}}</span>
                      </div>
                    </div></br>
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

    import RestService from '../RestService.js';
    import CrudMain from '../CrudMain.js';
    //var RestService = require('./RestService.js');

    export default {
        extends:CrudMain,
        data(){
            return{
                filter : {'name':''},
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
              var action = 'InvCategoryApi?page='+page+'&'+filterurl;
              RestService.methods.fetchItems(action, this, function(response, obj) {
                  obj.categorys = response.categorys.data;
                  obj.pagination = response.pagination;
                  // console.log(response
              });
            },
            deletecategory(id)
            {
                confirm("are you sure you want to delete");
                var action = `InvCategoryApi/${id}`;
                RestService.methods.deleteItem(action, this, function(response, obj){
                    obj.fetchDatas();
                });     
            },
            addcategory(){
                var para = this.category;
                RestService.methods.saveItems('InvCategoryApi', para, this, function(response, obj) {
                    if(response.result==false){
                        obj.errors = response.errors;
                        return false;
                    }  
                    obj.fetchDatas();
                    obj.category = {};
                    obj.errors = {};
                    $("#create-category").modal('hide');
                    //obj.categorys = rescategorys;
                });
            },
            editcategory(obj){
                this.category = {
                    name : obj.name,
                    email : obj.email,
                    address :obj.address,
                    phone:obj.phone,
                    id : obj.id
                };
                $("#create-category").modal('show');
            }
        }
    }
</script>
