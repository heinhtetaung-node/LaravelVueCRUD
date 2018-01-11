<template>
    <div>
        <h1>Employees List</h1>
        <div class="row">
          <div class="col-md-10"></div>
          <div class="col-md-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">
                  Add Employee
                </button>
          </div>
        </div><br>
        <input type="text" v-on:change="fetchDatas()" v-model="filter.name" placeholder="name">
        <input type="text" v-on:change="fetchDatas()" v-model="filter.email" placeholder="email">

        <table class="table table-hover">
            <thead>
            <tr>
                <td>No</td>
                <td>Name</td>
                <td>Email</td>
                <td>Address</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody>
                <tr v-for="employee,count in employees">
                    <td>{{ count+1 }}</td>
                    <td>{{ employee.name }}</td>
                    <td>{{ employee.email }}</td>
                    <td>{{ employee.address}}</td>
                    <td>
						<button class="btn btn-primary" v-on:click="editEmployee(employee)">Edit</button>
                    	<button class="btn btn-danger" v-on:click="deleteEmployee(employee.id)">Delete</button>
                    </td>
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

        <!-- create data form -->
        <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Employee</h4>
              </div>
              <div class="modal-body">
                <form v-on:submit.prevent="addEmployee">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Name:</label>
                        <input type="hidden" v-model="employee.id" />
                        <input type="text" class="form-control" v-model="employee.name">
                      </div>
                    </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Email:</label>
                          <input type="email" class="form-control col-md-6" v-model="employee.email" />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Address:</label>
                          <textarea name="address" id="address"  class="form-control" v-model="employee.address"></textarea>                         
                        </div>
                      </div>
                    </div<br />
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
    import CrudMain from './CrudMain.js';

    export default {
        extends: CrudMain,
        data(){
            return{
            	filter : {'name':'', 'email':''}
            }
        },
        created: function()
        {
            
        },
        methods: {
            fetchDatas(page = 1){
                this.pagination.current_page = page;
                var filterurl = jQuery.param(this.filter);
                var action = 'employee?page='+page+'&'+filterurl;
                RestService.methods.fetchEmployees(action, this, function(response, obj) {
                    obj.employees = response.employees.data;
                    obj.pagination = response.pagination;
  
                });
            },
            addEmployee(){
                var para = this.employee;
                // console.log(para); return false;
                RestService.methods.saveEmployee('employee', para, this, function(response, obj) {
                    obj.fetchDatas();
                    obj.employee = {};
                    $("#create-item").modal('hide');
                });
            },
            editEmployee(obj){
                this.employee = {
                    id : obj.id,
                    name : obj.name,
                    email : obj.email,
                    address:obj.address
                };
                $("#create-item").modal('show');
            },
            deleteEmployee(id){
                confirm("are you sure you want to delete");
                var action = `employee/${id}`;
                RestService.methods.deleteEmployee(action, this, function(response, obj){
                    obj.fetchDatas();
                });                
            },
        }
    }
</script>