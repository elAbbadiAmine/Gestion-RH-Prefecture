<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h2 class="card-title" style="margin-top: 10px;margin-left: 10px; width: 200px;">Liste des utilisateurs</h2>
                <form class="card-tools" role="search" ref="#">
                    <input v-model="keyword"  @click="reset('search')" class="form-control me-2"  style="width: 280px; margin-right: 210px;margin-top: 8px;" type="search" placeholder="Rechercher par Nom" aria-label="Search" id="shearchField">
                </form>
                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal" style="margin-top: 8px;">Ajouter <i class="fas fa-user-plus fa-fw"></i></button>
                    <button  v-if="Object.keys(this.users).length != 0 "  class="btn btn-success" @click="exportExcel" style="margin-top: 8px;">Exporter <i class="fas fa-file-export fa-fw"></i></button>
                    <button :disabled="isDisabled"   v-else class="btn btn-success" style="margin-top: 8px; background-color: lightgray; border-color: gray;">Exporter <i class="fas fa-file-export fa-fw"></i></button>
                </div>
                </div>
                <div class="navbar navbar-expand-lg bg-light">
                    <div class="container-fluid">

                <select  id="selectDiv" class='form-control '  style="width: 140px;" @focus="reset('div')" @change="getUsersByDivs();" >
                    <option disabled selected value> -- Division -- </option>
                    <option value='0'> - </option>
                    <option v-for="div in this.divisions" :key="div.id" :value="div.id">{{ div.Division }}</option>
                </select>

                <span>|</span>

                <select name="type" style="width: 180px;"  id="selectType" class="form-control" @focus="reset('type')" @change="getUsersByType();">
                    <option disabled selected value> -- Type -- </option>
                    <option value="admin">Admin</option>
                    <option value="Utilisateur">Utilisateur standard</option>
                    <option value="Chef de division">Chef de division</option>
                </select>

                <span>|</span>
                <label style="margin-top: 5px;">Du</label>
                <div class="form-group">
                    <input @click="reset('date_from')" type="Date" id="search_date_from" style="width: 160px; margin-top: 15px;"  class="form-control" :class="{ 'is-invalid': form.errors.has('Date_naissance') }">
                    <has-error :form="form" ></has-error>
                </div>
                <label style="margin-top: 5px;">Au</label>
                <div class="form-group">
                    <input  type="Date" id="search_date_to" style="width: 160px; margin-top: 15px;"   class="form-control" :class="{ 'is-invalid': form.errors.has('Date_naissance') }">
                    <has-error :form="form" ></has-error>
                </div>
                <button @click="getUsersByDate()" class="btn btn-navbar" >
                    <i class="fa fa-search"></i>
                </button>
                <span>|</span>
                
                <input class="btn btn-primary" style="width:100px;" type="reset" value="réinitialiser" @click="reset('all')">

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Division</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Recrutement</th>
                        <th>Outils</th>
                    </tr>

                    <tr v-for="user in users" :key="user.id">
                    <td>{{user.nom | capitalizeFirst }}</td>
                    <td>{{user.prenom | capitalizeFirst }}</td>
                    <td>{{user.Division | capitalize }}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.type | capitalizeFirst}}</td>
                    <td v-if="user.Date_recrutement">{{ moment(user.Date_recrutement).format("DD/MM/YYYY") }}</td>
                    <td v-else>-</td>

                    <td>
                        <a href="#" @click="viewUser(user) , hideMenu()">
                            <i class="fa fa-eye green"></i>
                        </a>
                        
                        <a v-if="user.type != 'admin'" href="#" @click="editModal(user) , hideMenu()">
                            /
                            <i class="fa fa-edit blue"></i>
                            /
                        </a>
                        
                        <a v-if="user.type != 'admin'" href="#" @click="deleteUser(user.id) , hideMenu()">
                            <i class="fa fa-trash red"></i>
                        </a>
                    </td>

                    </tr>
                </tbody></table>
                </div>
            </div>
          </div>
        </div>
        <!-- ajouter/modifer Modal-->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" v-show="!editmode" id="addNewLabel">Nouveau utilisateur</h2>
                <h2 class="modal-title" v-show="editmode" id="addNewLabel">Mettre à jour</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="editmode ? updateUser() : createUser()">
              <div class="modal-body" id="addNew">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col">
                        <h3>Infos Perso</h3> 
                      </div>
                      <div class="col">
                        <h3>Infos Pro</h3> 
                      </div>
                    </div>
                    <div class="row">
                        <div class="col"><!-- Perso-->
                          <div class="form-group">
                              <input v-model="form.nom" type="text" name="nom"
                                  placeholder="nom"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('nom') }">
                              <has-error :form="form" field="nom"></has-error>
                          </div>
                          <div class="form-group">
                              <input v-model="form.prenom" name="prenom" id="prenom"
                              placeholder="prénom"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('prenom') }">
                              <has-error :form="form" field="prenom"></has-error>
                          </div>
                          <div class="form-group">
                              <input type="" v-model="form.CNE" name="CNE" id="CNE"
                              placeholder="CNE"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('CNE') }">
                              <has-error :form="form" field="CNE"></has-error>
                          </div>
                          <div class="form-group">
                              <input v-model="form.Telephone" name="Telephone" id="Telephone"
                              placeholder="Telephone"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('Telephone') }">
                              <has-error :form="form" field="Telephone"></has-error>
                          </div>
                          <div class="form-group">
                              <select name="Sex" v-model="form.Sex" id="Sex"  class="form-control" :class="{ 'is-invalid': form.errors.has('Sex') }">
                                 <option disabled selected value> -- Sexe -- </option>
                                 <option value="Homme">Homme</option>
                                 <option value="Femme">Femme</option>
                              </select>
                              <has-error :form="form" field="Sex"></has-error>
                          </div>
                          <div class="form-group">
                              <input type="text" name="Date_naissance"  placeholder="Date de Naissance" onfocus="(this.type='date')" v-model="form.Date_naissance" id="Date_naissance" class="form-control" :class="{ 'is-invalid': form.errors.has('Date_naissance') }">
                              <has-error :form="form" field="Date_naissance"></has-error>
                          </div>
                          <div class="form-group">
                              <textarea v-model="form.Adresse" name="Adresse" id="Adresse"
                              placeholder="Adresse"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('Adresse') }"></textarea>
                              <has-error :form="form" field="Adresse"></has-error>
                          </div>
                          <div class="form-group">
                              <input placeholder="Mot de passe" v-model="form.password" type="password" name="password" id="password"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                              <has-error :form="form" field="password"></has-error>
                          </div>
                        </div>
                    <div class="col"><!-- Pro-->
                          <div class="form-group">
                                  <input v-model="form.Matricule" name="Matricule" id="Matricule"
                                  placeholder="Matricule"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('Matricule') }">
                                  <has-error :form="form" field="Matricule"></has-error>
                          </div>
                          <div class="form-group">
                              <select class='form-control' style="width: 150px;" v-model="form.Division">
                                <option disabled selected value> -- Division -- </option>
                                <option v-for="div in this.divisions" :key="div.id" :value="div.id">{{ div.Division }}</option>
                              </select>
                          </div>
                          <div class="form-group">
                                  <input v-model="form.email" type="email" name="email"
                                      placeholder="Email Address"
                                      class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                  <has-error :form="form" field="email"></has-error>
                          </div>
                          <div class="form-group">
                              <input type="text" onfocus="(this.type='date')" placeholder="Date de Recrutement" name="Date_recrutement" v-model="form.Date_recrutement" id="Date_recrutement" class="form-control" :class="{ 'is-invalid': form.errors.has('Date_recrutement') }">
                              <has-error :form="form" field="Date_recrutement"></has-error>
                          </div>
                          <div class="form-group">
                              <input v-model="form.Intitule" name="Intitule" id="Intitule"
                              placeholder="Intitule"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('Intitule') }">
                              <has-error :form="form" field="Intitule"></has-error>
                          </div>
                          <div class="form-group">
                                  <textarea v-model="form.bio" name="bio" id="bio"
                                  placeholder="Commentaire"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                                  <has-error :form="form" field="bio"></has-error>
                          </div>
                          <div class="form-group">
                                  <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                      <option disabled selected value> -- Type -- </option>
                                      <option value="Utilisateur">Utilisateur standard</option>
                                      <option value="Chef de division">Chef de division</option>
                                  </select>
                                  <has-error :form="form" field="type"></has-error>
                          </div>

                        </div>
                    </div>
                  </div>
              </div> 
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                  <button v-show="editmode" type="submit" class="btn btn-success">Mettre à jour</button>
                  <button v-show="!editmode" type="submit" class="btn btn-primary">Créer</button>
              </div>
            </form>
          </div>
        </div>
        </div>
        <!-- Afficher info Modal-->
        <div class="modal fade" id="viewUser" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" v-show="editmode" id="addNewLabel">Détails</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
              <div class="modal-body" id="addNew">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col">
                        <h3>Infos Perso</h3> 
                      </div>
                      <div class="col">
                        <h3>Infos Pro</h3> 
                      </div>
                    </div>
                    <div class="row">
                        <div class="col"><!-- Perso-->
                          <div class="form-group">
                              <input disabled={!isEditMode}/ v-model="form.nom" type="text"  placeholder="nom"
                                  class="form-control" >
                          </div>
                          <div class="form-group">
                              <input disabled={!isEditMode}/ v-model="form.prenom" name="prenom" id="prenom"
                              placeholder="prénom"
                              class="form-control" >
                          </div>
                          <div class="form-group">
                              <input disabled={!isEditMode}/ type="" v-model="form.CNE" name="CNE" id="CNE"
                              placeholder="CNE"
                              class="form-control">
                          </div>
                          <div class="form-group">
                              <input disabled={!isEditMode}/ v-model="form.Telephone" name="Telephone" id="Telephone"
                              placeholder="Telephone"
                              class="form-control" >
                          </div>
                          <div class="form-group">
                            <input disabled={!isEditMode}/ v-model="form.Sex" name="Sex" id="Sex"
                             
                              class="form-control" >
                          </div>
                          <div class="form-group">
                              <input disabled={!isEditMode}/ type="Date" name="Date_naissance" v-model="form.Date_naissance" id="Date_naissance" class="form-control" :class="{ 'is-invalid': form.errors.has('Date_naissance') }">
                          </div>
                          <div class="form-group">
                              <textarea disabled={!isEditMode}/ v-model="form.Adresse" name="Adresse" id="Adresse"
                              placeholder="Adresse"
                              class="form-control" ></textarea>
                          </div>

                        </div>
                    <div class="col"><!-- Pro -->
                          <div class="form-group">
                                  <input disabled={!isEditMode}/ v-model="form.Matricule" name="Matricule" id="Matricule"
                                  placeholder="Matricule"
                                  class="form-control" >
                          </div>
                          <div class="form-group">
                             <input disabled={!isEditMode}/ v-model="form.Division" name="division" id="division" 
                                  class="form-control" >
                          </div>
                          <div class="form-group">
                                  <input disabled={!isEditMode}/ v-model="form.email" type="email" name="email"
                                      placeholder="Email Address"
                                      class="form-control" >
                          </div>
                          <div class="form-group">
                              <input disabled={!isEditMode}/ type="Date" placeholder="Date_recrutement" name="Date_recrutement" v-model="form.Date_recrutement" id="Date_recrutement" class="form-control" >
                          </div>
                          <div class="form-group">
                              <input disabled={!isEditMode}/ v-model="form.Intitule" name="Intitule" id="Intitule"
                              placeholder="Intitule"
                              class="form-control" >
                          </div>
                          <div class="form-group">
                                  <textarea disabled={!isEditMode}/ v-model="form.bio" name="bio" id="bio"
                                  placeholder="Commentaire"
                                  class="form-control" ></textarea>
                          </div>
                          <div class="form-group">
                            <input disabled={!isEditMode}/ v-model="form.type" name="type" id="type" 
                                  class="form-control" >
                          </div>

                        </div>
                    </div>
                  </div>
              </div> 
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
              </div>
            </div>
            </div>
        </div>
    </div>
</template>


<script>

import swal from 'sweetalert2';
import moment from "moment";
import { saveExcel } from '@progress/kendo-vue-excel-export';
import { Grid } from '@progress/kendo-vue-grid';

    export default {
        filters: {
                capitalize: function (value) {
                if (!value) return ''
                    return value.toUpperCase()
                },
                capitalizeFirst: function(value){
                    if (!value) return ''
                        value = value.toString()
                        return value.charAt(0).toUpperCase() + value.slice(1)
                }

        },
        data() {
            return {  
                moment: moment, 
                keyword: null,
                elem : null,
                editmode: false,
                users : {},
                divisions : {},
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
        watch: {
            keyword(after, before) {
                if(this.keyword == ""){
                    Fire.$emit('AfterCreate');
                }
                this.getUsersByName();
            }
        },
        methods: {
            hideMenu(){
                if(this.elem == null){
                    this.elem = document.getElementById('menu');
                    this.elem.click();
                }
            },
            updateUser(){
                this.$Progress.start();
                this.form.put('api/user/'+this.form.id)
                .then(() => {
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
            editModal(user){
                this.editmode = true;
                this.form.clear();
                $('#addNew').modal('show');
                this.form.fill(user);
            },
            viewUser(user){
                this.editmode = true;
                $('#viewUser').modal('show');
                this.form.fill(user);
            },
            newModal(){
                this.editmode = false;
                this.form.clear();
                $('#addNew').modal('show');
            },
            deleteUser(id){
                swal.fire({
                    title: 'Êtes-vous sûr?',
                    text: "vous ne pourrez pas revenir en arrière !",
                    type: 'Attention',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimez-le !'
                    }).then((result) => {
                        if (result.value) {
                                this.form.delete('api/user/'+id).then(()=>{
                                        swal.fire(
                                            'Supprimé!',
                                            'Votre utilisateur a été bien supprimer ',
                                            'Succès'
                                        )
                                    Fire.$emit('AfterCreate');
                                }).catch(()=> {
                                    swal("Manqué!", "Il y avait quelque chose qui n'allait pas.", "warning");
                                });
                         }
                    }).catch();
            },
            loadUsers(){
                axios.get("api/user").then(({ data }) => (this.users = data))
            },
            loadDivs(){
                axios.get("api/loadDivs").then(({ data }) => (this.divisions = data.data))
            },
            getUsersByType(){
                var type = document.getElementById("selectType").value;
                axios.get("api/getByType/"+type).then(({ data }) => (this.users = data))
            },
            getUsersByDivs(){
                var idDev = document.getElementById("selectDiv").value;
                axios.get("api/getByDivision/"+idDev).then(({ data }) => (this.users = data))
            },
            getUsersByName(){
                this.$Progress.start();
                var nom = document.getElementById("shearchField").value;
                axios.get("api/getByName/"+nom).then(({ data }) => (this.users = data))
                this.$Progress.finish();
            },
            getUsersByDate(){
                var date_from = document.getElementById("search_date_from").value;
                var date_to = document.getElementById("search_date_to").value;

                this.$Progress.start();

                axios.get('/api/getByDate/' + date_from + '/' + date_to).then(
                    ({ data }) => (this.users = data),
                    this.$Progress.finish()
                ).catch(() => {
                    this.$Progress.fail(),
                    swal.fire({
                    title: 'ooops !',
                    text: 'Veuillez choisir une date.',
                    confirmButtonColor:'#d33',
                    confirmButtonText: 'Ok'
                })});
            },
            reset(valeur){

                if(valeur != 'div' || valeur == 'all')
                    $('#selectDiv').prop('selectedIndex',0);
                    Fire.$emit('AfterCreate');

                if(valeur != 'type' || valeur == 'all')
                    $('#selectType').prop('selectedIndex',0);

                if(valeur != 'search' || valeur == 'all')
                    this.keyword="";   
                    $('#shearchField').val('');

                if(valeur != 'date_from' || valeur == 'all')
                    $('#search_date_from').val('');

                if(valeur != 'date_to' || valeur == 'all')
                    $('#search_date_to').val('');
                
                Fire.$emit('AfterCreate');

            },
            exportExcel(){
                saveExcel({
                data: this.users,
                fileName: "utilisateurs",
                columns: [
                { field: 'id', title: 'ID' },
                { field: 'nom', title: 'Nom' },
                { field: 'Division', title: 'Division' },
                { field: 'email', title: 'Email' },
                { field: 'type', title: 'Type' }
              ]
            });

            },
            createUser(){
                this.$Progress.start();
                this.form.post('api/user')
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
                        title: 'Utilisateur créé avec succès'
                        })  
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                })
            }
        },
        created() {
            this.loadDivs();
            this.loadUsers();
            Fire.$on('AfterCreate',() => {
               this.loadUsers();
               this.loadDivs();
           });
        }

    }
    
</script>
