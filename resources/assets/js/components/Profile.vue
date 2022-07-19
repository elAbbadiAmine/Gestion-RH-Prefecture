<style>
.widget-user-header{
    background-position: center center;
    background-size: cover;
    height: 250px !important;
}
.widget-user .card-footer{
    padding: 0;
}

</style>


<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header text-white" style="background-image:url('./img/user-cover.jpg')">
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" :src="getProfilePhoto()" alt="photo de profile">
                </div>
                
                </div>
            </div>

            <!-- tab -->

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Parametre</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Setting Tab -->
                            <div class="tab-pane active show" id="settings">
                                <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Nom</label>

                                    <div class="col-sm-12">
                                    <input type="" v-model="form.nom" class="form-control" id="inputnom" placeholder="nom" :class="{ 'is-invalid': form.errors.has('nom') }">
                                     <has-error :form="form" field="nom"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPrenom" class="col-sm-2 control-label">Prenom</label>

                                    <div class="col-sm-12">
                                    <input type="" v-model="form.prenom" class="form-control" id="inputprenom" placeholder="prenom" :class="{ 'is-invalid': form.errors.has('prenom') }">
                                     <has-error :form="form" field="prenom"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputCNE" class="col-sm-2 control-label">CNE</label>

                                    <div class="col-sm-12">
                                    <input type="" v-model="form.CNE" class="form-control" id="inputCNE" placeholder="CNE" :class="{ 'is-invalid': form.errors.has('CNE') }">
                                     <has-error :form="form" field="CNE"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputDivision" class="col-sm-2 control-label">Division</label>

                                    <div class="col-sm-12">
                                    <input type="" v-model="form.Division" class="form-control" id="inputDivision" placeholder="Division"  :class="{ 'is-invalid': form.errors.has('Division') }">
                                     <has-error :form="form" field="Division"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputMatricule" class="col-sm-2 control-label">Matricule</label>

                                    <div class="col-sm-12">
                                    <input type="" v-model="form.Matricule" class="form-control" id="inputMatricule" placeholder="Matricule"  :class="{ 'is-invalid': form.errors.has('Matricule') }">
                                     <has-error :form="form" field="Matricule"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputTelephone" class="col-sm-2 control-label">Telephone</label>
    
                                    <div class="col-sm-12">
                                    <input type="" v-model="form.Telephone" class="form-control" id="inputTelephone" placeholder="Telephone"  :class="{ 'is-invalid': form.errors.has('Telephone') }">
                                     <has-error :form="form" field="Telephone"></has-error>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label for="inputSex" class="col-sm-2 control-label">Sex</label>

                                    <div class="col-sm-12">
                                    <input type="" v-model="form.Sex" class="form-control" id="inputSex" placeholder="Sex"  :class="{ 'is-invalid': form.errors.has('Sex') }">
                                     <has-error :form="form" field="Sex"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputDate_naissance" class="col-sm-2 control-label">Date_naissance</label>

                                    <div class="col-sm-12">
                                    <input type="Date" v-model="form.Date_naissance" class="form-control" id="inputDate_naissance" placeholder="Date_naissance"  :class="{ 'is-invalid': form.errors.has('Date_naissance') }">
                                     <has-error :form="form" field="Date_naissance"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label for="inputAdresse" class="col-sm-2 control-label">Adresse</label>
                                        <div class="col-sm-12">
                                        <textarea  v-model="form.Adresse" class="form-control" id="inputAdresse" placeholder="Adresse" :class="{ 'is-invalid': form.errors.has('Adresse') }"></textarea>
                                         <has-error :form="form" field="Adresse"></has-error>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-12">
                                    <input type="email" v-model="form.email" class="form-control" id="inputEmail" placeholder="Email"  :class="{ 'is-invalid': form.errors.has('email') }">
                                     <has-error :form="form" field="email"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputDate_recrutement" class="col-sm-2 control-label">Date_recrutement</label>
                                    <div class="col-sm-12">
                                    <input type="Date" v-model="form.Date_recrutement" class="form-control" id="inputDate_recrutement" placeholder="Date_recrutement"  :class="{ 'is-invalid': form.errors.has('Date_recrutement') }">
                                     <has-error :form="form" field="Date_recrutement"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputIntitule" class="col-sm-2 control-label">Intitule</label>
    
                                    <div class="col-sm-12">
                                    <input type="" v-model="form.Intitule" class="form-control" id="inputIntitule" placeholder="Intitule"  :class="{ 'is-invalid': form.errors.has('Intitule') }">
                                     <has-error :form="form" field="Intitule"></has-error>
                                    </div>
                                </div>  

                                <div class="form-group">
                                    <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                                    <div class="col-sm-12">
                                    <textarea  v-model="form.bio" class="form-control" id="inputExperience" placeholder="Experience" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                                     <has-error :form="form" field="bio"></has-error>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="photo" class="col-sm-2 control-label">Profile Photo</label>
                                    <div class="col-sm-12">
                                        <input type="file" @change="updateProfile" name="photo" class="form-input">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-sm-12 control-label">Passport (leave empty if not changing)</label>

                                    <div class="col-sm-12">
                                    <input type="password"
                                        v-model="form.password"
                                        class="form-control"
                                        id="password"
                                        placeholder="Passport"
                                        :class="{ 'is-invalid': form.errors.has('password') }"
                                    >
                                     <has-error :form="form" field="password"></has-error>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-12">
                                    <button @click.prevent="updateInfo" type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
          </div>
          <!-- end tabs -->
        </div>
    </div>
</template>



<script>
    export default {
        data(){
            return {
                 form: new Form({
                    id:'',
                    nom : '',
                    prenom : '',
                    CNE : '',
                    Division : '',
                    Matricule : '',
                    Telephone : '',
                    Sex : '',
                    Date_naissance : '',
                    Adresse : '',
                    email: '',
                    Date_recrutement: '',
                    Intitule: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                })
            }
        },
        mounted() {

            console.log('Component mounted.')
        },

        methods:{

            getProfilePhoto(){

                let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+ this.form.photo ;
                return photo;
            },

            updateInfo(){
                this.$Progress.start();
                if(this.form.password == ''){
                    this.form.password = undefined;
                }
                this.form.put('api/profile')
                .then(()=>{
                     Fire.$emit('AfterCreate');
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
            updateProfile(e){
                // console.log('uploading');
                    let file = e.target.files[0];
                    console.log(file);
                    let reader = new FileReader();
                    // let vm = this;
                    if(file['size'] < 2111775){
                        reader.onloadend = (file) => {
                            // console.log('RESULT', reader.result)
                            this.form.photo = reader.result;
                        }
                        reader.readAsDataURL(file);
                    }else{
                         swal({
                            type: 'error',
                            title: 'Oops...',
                            text: 'You are uploading a large file',
                        })
                    }
            }
        },

        created() {
            axios.get("api/profile")
            .then(({ data }) => (this.form.fill(data)));
        }
    }
</script>
