<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 10px;">Mes demandes de documents RH </h3>
                        <div class="card-tools">
                            <button v-if="Object.keys(this.demanderh).length != 0 " class="btn btn-success" style="margin-top: 5px; margin-right: 13px;" @click="exportExcel">Exporter <i class="fas fa-file-export fa-fw"></i></button>
                            <button  v-else class="btn btn-success" style="background-color: lightgray; border-color: gray;margin-top: 5px;margin-right: 13px;">Exporter <i class="fas fa-file-export fa-fw"></i></button>                      
                        </div>
                    </div>
                    <div class="navbar navbar-expand-lg bg-light">
                    <div class="container-fluid">

                <select  id="selectType" class='form-control '  style="width: 200px;" @focus="reset('type')" @change="getDemandesByType();" >
                    <option disabled selected value> -- Type -- </option>
                    <option>Certificat de travail</option>
                    <option>Etat d'engagement</option>
                </select>

                <span>|</span>

                 <select  id="selectLangue" class='form-control '  style="width: 200px;" @focus="reset('Langue')" @change="getDemandesByLangue();" >
                    <option disabled selected value> -- Langue -- </option>
                    <option>Français</option>
                    <option>Arabe</option>
                </select>

                <span>|</span>
                
                <input class="btn btn-primary" style="width:100px;" type="reset" value="réinitialiser" @click="reset('all')">

                    </div>
                </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>Type</th>
                                    <th>Langue</th>
                                    <th>Commentaire</th>
                                    <th>Outils</th>
                                </tr>
                                <tr v-for="rh in demanderh" :key="rh.utilisateur">

                                    <th>{{rh.type}}</th>
                                    <th>{{rh.langue}}</th>
                                    <th v-if="rh.Commentaire != null ">{{rh.Commentaire}}</th>
                                    <th v-else> - </th>
                                   <th>
                                    <a href="#" @click=" viewDemande(rh), hideMenu()">
                                        <i class="fa fa-eye green"></i>
                                    </a>
                                    / 
                                    <a  title="Exporter le document" @click=" printPDF(rh.id) , hideMenu()">
                                        <i class="fa fa-download blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteDemande(rh.id) , hideMenu()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                    </th>

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
              <div class="modal-body" id="addNew">
                  <div class="container-fluid">

                    <div class="row">
                        <div class="col">
                          <div class="form-group">
                                <label>Le Type :</label>
                              <input disabled={!isEditMode}/ v-model="form.type" type="text"  placeholder="-"
                                  class="form-control" >
                          </div>
                          <div class="form-group">
                              <label>La langue :</label>
                              <input disabled={!isEditMode}/ v-model="form.langue" name="langue" id="langue"
                              placeholder="-"
                              class="form-control" >
                          </div>
                          <div class="form-group">
                              <label>La Date de Création :</label>
                              <input disabled={!isEditMode}/ type="" v-model="form.created_at" name="created_at" id="created_at"
                              placeholder="-"
                              class="form-control">
                          </div>
                          <div class="form-group">
                              <label>Commentaire :</label>
                              <input disabled={!isEditMode}/ type="" v-model="form.Commentaire" name="Commentaire" id="Commentaire"
                              placeholder="-"
                              class="form-control">
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
import { saveExcel } from '@progress/kendo-vue-excel-export';
import { Grid } from '@progress/kendo-vue-grid';

export default {
      data(){
            return{
                menu : null,
                editmode: false,
                demanderh: {},
                form: new Form({
                    type:'',
                    langue:'',
                    Commentaire:'',
                    created_at:''
                })
            }
        

      },
      methods: {
            loadDemandeRh(){
                axios.get("api/mesDemandes/demande_rh/loadDemandeRh/").then(({ data }) => (this.demanderh=data.data))
            },
            hideMenu(){
                if(this.menu == null){
                    this.menu = document.getElementById('menu');
                    this.menu.click();
                }
            },
            deleteDemande(id){
                swal.fire({
                    title: 'Êtes-vous sûr?',
                    text: "vous ne pourrez pas revenir en arrière !",
                    type: 'Attention',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Supprimer la demande!',
                    cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.value) {
                                this.form.delete('api/demande_rh/'+id).then(()=>{
                                        swal.fire(
                                            'Supprimé!',
                                            'La Demande a été bien supprimer ',
                                        );
                                    Fire.$emit('AfterCreate');
                                }).catch(()=> {
                                    swal("Manqué!", "Il y avait quelque chose qui n'allait pas.", "warning");
                                });
                         }
                    }).catch();

            },
            viewDemande(rh){
                this.editmode = true;
                $('#viewDemande').modal('show');
                this.form.fill(rh);
                this.form.created_at = this.form.created_at.split(" ")[0];
            },
            etatDemande(){

            },
            reset(valeur){

                if(valeur != 'type' || valeur == 'all')
                    $('#selectType').prop('selectedIndex',0);
                    
                if(valeur != 'Langue' || valeur == 'all')
                    $('#selectLangue').prop('selectedIndex',0);
                
                Fire.$emit('AfterCreate');

            },
            exportExcel(){
                saveExcel({
                data: this.demanderh,
                fileName: "Mes-Demandes-de-Document-RH",
                columns: [
                { field: 'type', title: 'type' },
                { field: 'langue', title: 'langue' },
                { field: 'Commentaire', title: 'Commentaire' }
              ]});
            },
            getDemandesByType(){
                var type = document.getElementById("selectType").value;
                axios.get("api/mesDemandes/demande_rh/byType/"+type).then(({ data }) => (this.demanderh = data))
            },
            getDemandesByLangue(){
                var Langue = document.getElementById("selectLangue").value;
                axios.get("api/mesDemandes/demande_rh/byLangue/"+Langue).then(({ data }) => (this.demanderh = data))
            },
            printPDF(id){
	            window.location.href = "pdfview/"+id;
            }

        },
        created() {
            this.loadDemandeRh();
            Fire.$on('AfterCreate',() => {
               this.loadDemandeRh();
           });
      }
}
</script>

<style>

</style>