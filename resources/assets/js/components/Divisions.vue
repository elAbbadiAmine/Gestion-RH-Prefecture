<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des divisions</h3>                       
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">Ajouter <i class="fas fa-circle-plus fa-fw"></i></button>
                            <button v-if="Object.keys(this.divisions).length != 0 " class="btn btn-success" @click="exportExcel">Exporter <i class="fas fa-file-export fa-fw"></i></button>
                            <button  v-else class="btn btn-success" style="background-color: lightgray; border-color: gray;">Exporter <i class="fas fa-file-export fa-fw"></i></button>                      
                       </div>
                    </div>
                    <div class="navbar navbar-expand-lg bg-light">
                        <div style="margin-left: -420px;" class="container-fluid">
                            <form class="card-tools" role="search" >
                                <input v-model="keyword" class="form-control me-2"  style="width: 315px; margin-left: 600px;" type="search" placeholder="Rechercher par Division" aria-label="Search" id="shearchField">
                            </form>
                            <input class="btn btn-primary" style="width:100px; margin-left:19px ;" type="reset" value="réinitialiser" @click="reset()">
                        </div>
                    </div>
                    

                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>Nom Division</th>
                                    <th>Chef de division</th>
                                    <th>Enregistré à</th>
                                    <th>Outils</th>
                                </tr>
                                <tr v-for="div in divisions" :key="div.id">
                                    <td>{{div.Division | capitalize }}</td>
                                    <td>{{div.Chef_division}}</td>
                                    <td>{{div.created_at | myDate}}</td>
                                    <td>
                                        <a href="#" @click="editModal(div)">
                                            <i class="fa fa-edit blue"></i>
                                        </a>
                                        /
                                        <a href="#" @click="deleteDivision(div.id)">
                                            <i class="fa fa-trash red"></i>
                                        </a>
                                        /
                                        
                                        <router-link
                                        :to="getUrl(div.id)"
                                        v-slot="{href, route, navigate}">
                                            <a :href="href" @click="navigate" >
                                            <i class="fa fa-external-link"></i>
                                            {{ route.name }}
                                            </a>
                                        </router-link>
                        
                                        
                                    </td>
                                 </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
           <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Ajouter une divison</h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Modification de la division</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateDivision() : create_Division()">
            
                <div class="col-sm-6">
                    <div class="form-group">
                        <label style="margin-top: 10px;">Nom de la division :</label>
                        <input v-model="form.Division" type="text" name="Divisions"   placeholder="exp : DSIC " style="width: 470px;"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('Division') }">
                        <has-error :form="form" field="Division"></has-error>
                    </div>
                    
                     <div class="form-group">
                            <label>Chef de division :</label>
                            <select class='form-control' style="width: 470px;" v-model="form.Chef_division">
                                <option disabled selected value> -- Chef de division -- </option>                               
                                <option v-for="user in this.users" :key="user.id" :value="user.id">{{ user.nom+" "+user.prenom }}</option>
                            </select>
                        </div>
                
                    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                    <button v-show="editmode" type="submit" class="btn btn-success">Mise à jour</button>
                    <button v-show="!editmode" type="submit" class="btn btn-primary">Créer</button>
                </div>

                </form>

                </div>
            </div>
            </div>
    </div>
</template>

<script>
import Form from 'vform';
import swal from 'sweetalert2';
import Swal from 'sweetalert2'

import { saveExcel } from '@progress/kendo-vue-excel-export';
import { Grid } from '@progress/kendo-vue-grid';

export default {
        filters: {
                capitalize: function (value) {
                if (!value) return ''
                    return value.toUpperCase()
                }
        },
        watch: {
            keyword(after, before) {           
                if(this.keyword == ""){
                    Fire.$emit('AfterCreate');
                }
                this.getDivsByName();
            }
        },
        data() {
            return {
                keyword: null,
                editmode: false,
                users : {},
                divisions : {},
                form: new Form({
                    id:'',
                    Division : '',
                    Chef_division: '',
                })

            }

        },
        methods: {
            reset(){
                $('#shearchField').val('');
                Fire.$emit('AfterCreate');
                this.keyword="";
            },
            getDivsByName(){
                this.$Progress.start();
                var nom = document.getElementById("shearchField").value;
                axios.get("api/division/getByName/"+nom).then(({ data }) => (this.divisions = data))
                this.$Progress.finish();
            },
            exportExcel(){
                saveExcel({
                data: this.divisions,
                fileName: "Division",
                columns: [
                { field: 'id', title: 'ID' },
                { field: 'Division', title: 'Division' },
                { field: 'Chef_division', title: 'Chef division' }
              ]
            });},
            loadDivisions(){
                axios.get("api/division").then(({ data }) => (this.divisions = data.data))
            },
            UserDivisions(){
                axios.get("api/UserDivisions").then(({ data }) => (this.users=data.data))
            },
            editModal(division){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(division);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteDivision(id){
                swal.fire({
                    title: 'Êtes-vous sûr?',
                    text: "vous ne pourrez pas revenir en arrière !",
                    type: 'Attention',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimez-la !'
                    }).then((result) => {


                        // Send request to the server
                        if (result.value) {
                                this.form.delete('api/division/'+id).then(()=>{
                                        swal.fire(
                                            'Supprimé!',
                                            'Votre fichier a été bien supprimé.',
                                            'Succès'
                                        )
                                    Fire.$emit('AfterCreate');
                                }).catch(()=> {
                                    swal("Manqué!", "Il y avait quelque chose qui n'allait pas.", "Attention");
                                });
                         }
                    })
            },
            create_Division(){
                this.$Progress.start();
               
                this.form.post('api/division')
                .then(()=>{
                    swal.fire(
                        'Succès',
                        'utilisateur créé',
                        'Succès'
                        )
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    toast({
                        type: 'success',
                        title: 'Division créé avec succès'
                        })
                this.$Progress.finish();
                }).catch(()=>{
                    this.$Progress.fail();
                   
                });
            },
            updateDivision(){
                this.$Progress.start();
              //console.log('Editing data');
                this.form.put('api/division/'+this.form.id)
               .then(() => {
              // success
                    $('#addNew').modal('hide');
                    swal.fire(
                        'mise à jour!',
                        'Informations modifier',
                        'Succès'
                    )
                    this.$Progress.finish();
                    Fire.$emit('AfterCreate');
               })
              .catch(() => {
                    this.$Progress.fail();
               });
            },
            getUrl(id){
                return "/Service/"+id;
            }
        },
        created() {
                this.loadDivisions();
                this.UserDivisions();
                Fire.$on('AfterCreate',() => {
                this.loadDivisions();
                this.UserDivisions();

           });
        }
}
</script>

<style>

</style>