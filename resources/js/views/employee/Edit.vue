<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <form @submit.prevent="editEmployeeSubmit()" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">First Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="first_name" class="form-control" v-model="employee.first_name">
                                <span class="help-block m-b-none" v-if="editErrors.first_name">{{ editErrors.first_name[0] }}</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Middle Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="middle_name" class="form-control" v-model="employee.middle_name">
                                <span class="help-block m-b-none" v-if="editErrors.middle_name">{{ editErrors.middle_name[0] }}</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Last Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="last_name" class="form-control" v-model="employee.last_name">
                                <span class="help-block m-b-none" v-if="editErrors.last_name">{{ editErrors.last_name[0] }}</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-8">
                                <input type="text" name="address" class="form-control" v-model="employee.address">
                                <span class="help-block m-b-none" v-if="editErrors.address">{{ editErrors.address[0] }}</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Department</label>
                            <div class="col-sm-8">
                                <select class="form-control" v-model="employee.department_id">
                                    <option>select department</option>
                                    <option v-for="(d,index) in departments" :key="index" :value="d.id">{{ d.name }}</option>
                                </select>
                                <span class="help-block m-b-none" v-if="editErrors.department_id">{{ editErrors.department_id[0] }}</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Country</label>
                            <div class="col-sm-8">
                                <select name="country_id" class="form-control" v-model="employee.country_id" v-on:change="getStates()">
                                    <option>select country</option>
                                    <option v-for="(c,index) in countries" :key="index" :value="c.id">{{ c.name }}</option>
                                </select>
                                <span class="help-block m-b-none" v-if="editErrors.country_id">{{ editErrors.country_id[0] }}</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">State</label>
                            <div class="col-sm-8">
                                <select name="state_id" class="form-control" v-model="employee.state_id" v-on:change="getCities()">
                                    <option>select state</option>
                                    <option v-for="(s,index) in states" :key="index" :value="s.id">{{ s.name }}</option>
                                </select>
                                <span class="help-block m-b-none" v-if="editErrors.state_id">{{ editErrors.state_id[0] }}</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">City</label>
                            <div class="col-sm-8">
                                <select name="city_id" class="form-control" v-model="employee.city_id" >
                                    <option>select city</option>
                                    <option v-for="(city,index) in cities" :key="index" :value="city.id">{{ city.name }}</option>
                                </select>
                                <span class="help-block m-b-none" v-if="editErrors.city_id">{{ editErrors.city_id[0] }}</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Zipcode</label>
                            <div class="col-sm-8">
                                <input type="text" name="zipcode" class="form-control" v-model="employee.zipcode">
                                <span class="help-block m-b-none" v-if="editErrors.zipcode">{{ editErrors.zipcode[0] }}</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Birth Date</label>
                            <div class="col-sm-8">
                                <input type="text" name="birthdate" class="form-control" v-model="employee.birthdate">
                                <span class="help-block m-b-none" v-if="editErrors.birthdate">{{ editErrors.birthdate[0] }}</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-1">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                            <div class="col-sm-4">
                                <router-link :to="{ name: 'EmployeeList'}" class="btn btn-white">Cancel</router-link>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


export default {
    data(){
        return{
            employee:[],
            departments:[],
            countries:[],
            states:[],
            cities:[],
            editErrors:[]
        }
    },
    mounted() {
        this.getEmployee(this.$route.params.id);
    },
    methods:{
        getEmployee(id) {
            axios.get('departments')
            .then(res=>{
                this.departments = res.data.data;
            })
            .catch(err=>{
                console.log(err);
            });

            axios.get('countries')
            .then(res=>{
                this.countries = res.data.data;
            })
            .catch(err=>{
                console.log(err);
            });

            axios.get(`employee/${id}/edit`)
            .then(res=>{
                this.employee = res.data.data;
                this.getStates();
                this.getCities();
            })
            .catch(err=>{
                console.log(err);
            });
        },
        getStates(){
            axios.get(`states/${this.employee.country_id}`)
            .then(res=>{
                this.states = res.data.data;
            })
            .catch(err=>{
                console.log(err);
            });
        },
        getCities(){
            axios.get(`cities/${this.employee.state_id}`)
            .then(res=>{
                this.cities = res.data.data;
            })
            .catch(err=>{
                console.log(err);
            });
        },
        editEmployeeSubmit() {
            axios.put(`employee/${this.employee.id}`,this.employee)
            .then(res=>{
                if(res.data.success == false)
                {
                    this.editErrors = res.data.errors;
                }
                else if(res.data.success == true)
                {
                    console.log(res.data.message);
                    this.$router.push({ name:'EmployeeList' })
                }
            })
            .catch(err=>{
                console.log(err);
            });
        }
    }
}
</script>
