<template>
    <b-card>
        <b-card-header>
            <div>
                <div class="col-sm-8">
                    <input type="text" name="search" class="form-control" v-model="searchstr" v-on:keyup="searchEmployee()" />
                </div>
                <div class="col-sm-8">
                    <select class="form-control" v-model="selectedDepartment" v-on:change="searchEmployee()">
                        <option value="">select department</option>
                        <option v-for="(d,index) in departments" :key="index" :value="d.id">{{ d.name }}</option>
                    </select>
                </div>
            </div>
            <div class="card-tools">
                <div class="input-group input-group-sm">
                    <router-link :to="{ name: 'EmployeeAdd'}" class="btn btn-primary btn-block">Add New Employee</router-link>
                </div>
            </div>
        </b-card-header>
        <b-table striped bordered :items="employeeList" :fields="fields">

            <template #cell(options)="row">
                <b-button variant="primary" size="sm" @click="editEmployee(row.item.id)" class="mr-2">Edit</b-button>
                <b-button variant="danger" size="sm" @click="deleteEmployee(row.item.id)" class="mr-2">Delete</b-button>
            </template>

        </b-table>

        <b-card-footer>
            <ul class="pagination pagination-sm m-0 float-right">
                <li class="page-item" :class="[ p == page ? 'active' : '' ]" v-for="p in totalPages"><span class="page-link" v-on:click="getEmployeeListWithPage(p)">{{ p }}</span></li>
            </ul>
        </b-card-footer>
    </b-card>
</template>

<script>


export default {
    data(){
        return{
            searchstr:"",
            selectedDepartment:"",
            page:1,
            totalPages:1,
            departments:[],
            fields: ['id','first_name', 'last_name','date_hired',{ key: 'department.name', label: 'Department name' },'options'],
            employeeList:[]
        }
    },
    mounted() {
        this.getDepartment();
        this.getEmployeeList();
    },
    methods:{
        getDepartment() {
            axios.get('departments')
            .then(res=>{
                this.departments = res.data.data;
            })
            .catch(err=>{
                console.log(err);
            });
        },
        getEmployeeList() {
            axios.get('employee',{
                params:{
                    searchstr: this.searchstr,
                    department: this.selectedDepartment,
                    page: this.page,
                }
            })
            .then(res=>{
                this.employeeList = res.data.data.data;
                var total = res.data.data.total;
                var perPage = res.data.data.per_page;
                this.totalPages = Math.ceil((total/perPage));
            })
            .catch(err=>{
                console.log(err);
            });
        },
        deleteEmployee(id){
            Swal.fire({
                title: 'Are you sure delete this employee?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`employee/destroy/${id}`)
                    .then(res => {
                        console.log(res)
                    })
                    .catch(err => {
                        console.log(err);
                    });
                }
            })
        },
        editEmployee(id){
            this.$router.push({
                name:'EmployeeEdit',
                params:{id:id}
            })
        },
        searchEmployee() {
            this.getEmployeeList();
        },
        getEmployeeListWithPage(page){
            this.page = page;
            this.getEmployeeList();
        }
    }
}
</script>
