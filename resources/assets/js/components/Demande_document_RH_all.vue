<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des demandes de doc RH</h3>
                        <div class="card-tools">
                            <button class="btn btn-success"><i class="nav-icon fas fa-file-excel fa-fw"></i> Généré fichier excel </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                                    <tr>
                                    <th>Utilisateur</th>
                                    <th>Type</th>
                                    <th>Langue</th>
                                    <th>Commentaire</th>
                                    <th>&ensp;&ensp;État</th>
                                </tr>
                                <tr v-for="rh in demanderh" :key="rh.utilisateur">
                                    <th>{{rh.utilisateur}}</th>
                                    <th>{{rh.type}}</th>
                                    <th>{{rh.langue}}</th>
                                    <th>{{rh.Commentaire}}</th>
                                    <td> <a href="#" @click="viewDemande(rh)">
                            <i class="fa fa-eye green"></i>
                        </a>
                        /
                        <a href="#" @click="valideDemande()">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </a> 
                        /
                        <a href="#" @click="deleteUser(user.id)">
                            <i class="fas fa-check"></i>
                        </a> 
                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<!-- Afficher info Modal-->
      <div class="modal fade" id="viewDemande" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" v-show="editmode" id="addNewLabel">Détails</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                    <form @submit.prevent=" create_demande()">
                    <div class="card-body">
                    <div>  
                        <div class="form-group">
                            <label>Type de document : </label>
                            <input disabled={!isEditMode}/ v-model="form.type" name="type" id="type" 
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                  <has-error :form="form" field="type"></has-error>
                        </div>   
                    </div>
                    
                        <div class="form-group">
                            <label>Langue de document :</label>
                            <input disabled={!isEditMode}/ v-model="form.langue" name="langue" id="langue" 
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('langue') }">
                                  <has-error :form="form" field="langue"></has-error>
                        </div>
                        <div class="form-group mt-4">
                        <input disabled={!isEditMode}/ v-model="form.Commentaire" name="Commentaire" id="Commentaire"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('Commentaire') }">
                        <has-error :form="form" field="Commentaire"></has-error>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                    </div>
                    
                    </form>
                </div> 
          </div>
        </div>



    </div>

</template>

<script>
export default {
        data() {
            return {
                editmode: false,
                demanderh : {},
                form: new Form({
                    utilisateur :  ''  ,
                    type:'',
                    langue: '',
                    Commentaire:''
                })
            }
            
        },
        methods: {
            viewDemande(demande){
                this.editmode = true;
                $('#viewDemande').modal('show');
                this.form.fill(demande);
            },
            valideDemande(){
                swal.fire({
                    title: 'Voulez-vous vraiment de traité la demande ?',
                    text: "vous ne pourrez pas revenir en arrière !",
                    type: 'Attention',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, validez-le !',
                    })
            },
            loadDemandeRhAll(){
                axios.get("api/loadDemandeRhAll/").then(({ data }) => (this.demanderh=data.data))
            },
        },
        created() {
                this.loadDemandeRhAll();
                Fire.$on('AfterCreate',() => {
                this.loadDemandeRhAll();
                

           });
        //    setInterval(() => this.loadServices(), 3000);
            }
}
</script>


