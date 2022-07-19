<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Demande de congé</div>
                    <form @submit.prevent=" create_demande()">

                        <div class="card-body">
                            <div class="form-group" >
                                 <strong>Du:</strong>
                            <input type="Date" name="date_debut" v-model="form.date_debut" id="date_debut" class="form-control" :class="{ 'is-invalid': form.errors.has('date_debut') }" style="width: 200px;">
                            <has-error :form="form" field="Date_debut"></has-error>
                             <strong>Au:</strong>
                             <input type="Date" name="date_fin" v-model="form.date_fin" id="date_fin" class="form-control" :class="{ 'is-invalid': form.errors.has('date_fin') }" style="width: 200px;">
                            <has-error :form="form" field="date_fin"></has-error>
                        </div>
                        <div>
                          <div class="form-group">
                                <label>Type de congé : </label>
                                <select class='form-control' v-model="form.type" @change="showCerti($event)" >
                                 <!--click to show-->
                                    <option  value="Congé de Maladie">Congé de Maladie</option>
                                    <option  value="Congé de Maternité" >Congé de Maternité</option>
                                    <option  value="Congé Normal">Congé Normal</option>
                                </select>
                            </div>
                            <!--show Upload button-->
                            <div id="showcerti" v-show="active">
                              <strong>Certificat:</strong>
                            <input type="file" class="form-control" v-on:change="onFileChange">
                            </div>
                              </div>
                            <form @submit="formSubmit" enctype="multipart/form-data">
                            <div class="form-group mt-4">
                            <textarea v-model="form.Commentaire" name="Commentaire" id="Commentaire"
                            placeholder="Commentaire pour les utilisateurs (Optionnel)"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('Commentaire') }"></textarea>
                            <has-error :form="form" field="Commentaire"></has-error>
                        </div>
                            </form>
                            <button class="btn btn-success mt-2" >Valider</button>
                    </div>
                    </form>
                        
                </div>
            </div>
        </div>
    </div>
</template>
   
<script>
import { exit } from 'process';
    export default {
        data() {
            return {             
                active: false,
                users: '',
                form: new Form({
                    utilisateur : ''  , 
                    date_debut:'',
                    date_fin:'',
                    type:'',
                    durée: '',
                    Commentaire:''
                    })
            };
        },
        methods: {
            onFileChange(e){
                console.log(e.target.files[0]);
                this.file = e.target.files[0];
            },
            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;
   
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
    
                let formData = new FormData();
                formData.append('file', this.file);
   
                axios.post('/formSubmit', formData, config)
                .then(function (response) {
                    currentObj.success = response.data.success;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
            },
            showCerti(event) {
                   if(event.target.value == "Congé de Maladie"){
                   this.active=true;
                   }else{
                   this.active=false; 
                }    
            },
            create_demande(){
                this.$Progress.start();
                this.form.post('api/demande_conge')
                .then(()=>{
                    swal.fire(
                        'Success',
                        'demande created',
                        'success'
                        )
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    toast({
                        type: 'success',
                        title: 'demande Created in successfully'
                        })
                this.$Progress.finish();
                })
                .catch(()=>{
                    
                });
                
            },
            postUser(){

            }
            // getUser(){
            //     var id = this.$route.params.id;
                
            //     this.form.utilisateur = id;
            //     axios.get('api/utilisateur/'+id).then(({ data }) => (this.users = data))
            // },
            
        },
        
        //    setInterval(() => this.loadServices(), 3000);
            }
    
</script>