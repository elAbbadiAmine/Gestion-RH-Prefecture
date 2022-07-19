<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des utilisateurs</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal">Ajouter <i class="fas fa-user-plus fa-fw"></i></button>
                    <a class="btn btn-success white" @click="exportExcel">Export <i class="fa-solid fa-file-export"></i></a>
            
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Division</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Enregistré à</th>
                        <th>Modifier</th>
                  </tr>


                  <tr v-for="user in users" :key="user.id">

                    <td>{{user.id}}</td>
                    <td>{{user.nom}}</td>
                    <td>{{user.Division}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.type}}</td>
                    <td>{{user.created_at | myDate}}</td>

                    <td>
                        <a href="#" @click="viewUser(user)">
                            <i class="fa fa-eye green"></i>
                        </a>
                        /
                        <a href="#" @click="editModal(user)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteUser(user.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                    </td>

                  </tr>
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
                              <select name="Sex" v-model="form.Sex" id="Sex" class="form-control" :class="{ 'is-invalid': form.errors.has('Sex') }">
                                  <option value="Homme">Homme</option>
                                  <option value="Femme">Femme</option>
                              </select>
                              <has-error :form="form" field="Sex"></has-error>
                          </div>
                          <div class="form-group">
                              <input type="Date" name="Date_naissance" v-model="form.Date_naissance" id="Date_naissance" class="form-control" :class="{ 'is-invalid': form.errors.has('Date_naissance') }">
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
                              <input type="Date" placeholder="Date_recrutement" name="Date_recrutement" v-model="form.Date_recrutement" id="Date_recrutement" class="form-control" :class="{ 'is-invalid': form.errors.has('Date_recrutement') }">
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
                                    <!-- <option value="admin">Administrateur</option> -->
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
                <h2 class="modal-title" v-show="editmode" id="addNewLabel">Visualisation</h2>
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
                              <input v-model="form.nom" type="text" name="nom" placeholder="nom"
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
                              <select name="Sex" v-model="form.Sex" id="Sex" class="form-control" :class="{ 'is-invalid': form.errors.has('Sex') }">
                                  <option value="Homme">Homme</option>
                                  <option value="Femme">Femme</option>
                              </select>
                              <has-error :form="form" field="Sex"></has-error>
                          </div>
                          <div class="form-group">
                              <input type="Date" name="Date_naissance" v-model="form.Date_naissance" id="Date_naissance" class="form-control" :class="{ 'is-invalid': form.errors.has('Date_naissance') }">
                              <has-error :form="form" field="Date_naissance"></has-error>
                          </div>
                          <div class="form-group">
                              <textarea v-model="form.Adresse" name="Adresse" id="Adresse"
                              placeholder="Adresse"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('Adresse') }"></textarea>
                              <has-error :form="form" field="Adresse"></has-error>
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
                              <input type="Date" placeholder="Date_recrutement" name="Date_recrutement" v-model="form.Date_recrutement" id="Date_recrutement" class="form-control" :class="{ 'is-invalid': form.errors.has('Date_recrutement') }">
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
                                    <!-- <option value="admin">Administrateur</option> -->
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
              </div>
          </div>
        </div>
      </div>

      

    </div>
</template>
<script>
import swal from 'sweetalert2';

    export default {
        data() {
            return {
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
        methods: {
            updateUser(){
                this.$Progress.start();
                //console.log('Editing data');
                this.form.put('api/user/'+this.form.id)
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
            editModal(user){
                this.editmode = true;
                this.form.reset();
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
                this.form.reset();
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

                        // Send request to the server
                        if (result.value) {
                                this.form.delete('api/user/'+id).then(()=>{
                                        swal.fire(
                                            'Supprimé!',
                                            'Your file has been deleted.',
                                            'Succès'
                                        )
                                    Fire.$emit('AfterCreate');
                                }).catch(()=> {
                                    swal("Manqué!", "Il y avait quelque chose qui n'allait pas.", "warning");
                                });
                         }
                    })
            },
            loadUsers(){
                axios.get("api/user").then(({ data }) => (this.users = data))
            },
            loadDivs(){
                axios.get("api/loadDivs").then(({ data }) => (this.divisions = data.data))
            },
            exportExcel(){
                axios.get('api/export')
                    .then((res)=>{
                        console.log('hahahhaahahhahaahaha')
                    })
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
        //setInterval(() => this.loadUsers(), 3000);
        }

    }
</script>
