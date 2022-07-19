<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des divisions</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">Ajouter <i class="fas fa-user-plus fa-fw"></i></button>
                            
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>Division</th>
                                    <th>Chef de division</th>
                                    <th>Enregistré à</th>
                                    <th>Modifier</th>
                                </tr>
                                <tr v-for="div in divisions" :key="div.id">
                                    <td>{{div.Division}}</td>
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
                            <label>Chef de division :</label>
                            <select class='form-control' style="width: 470px;" v-model="form.Chef_division">
                                <option v-for="user in this.users" :key="user.id" :value="user.id">{{ user.nom+" "+user.prenom }}</option>
                            </select>
                        </div>
                
                    <div class="form-group">
                        <input v-model="form.Division" type="text" name="Divisions"   placeholder="Division" style="width: 470px;"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('Division') }">
                        <has-error :form="form" field="Division"></has-error>
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

export default {
        data() {
            return {
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
                    confirmButtonText: 'Oui, supprimez-le !'
                    }).then((result) => {


                        // Send request to the server
                        if (result.value) {
                                this.form.delete('api/division/'+id).then(()=>{
                                        swal.fire(
                                            'Supprimé!',
                                            'Your file has been deleted.',
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
                })
                .catch(()=>{
                    
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
        //    setInterval(() => this.loadDivisions(), 3000);
            }
}
            



</script>

<style>

</style>