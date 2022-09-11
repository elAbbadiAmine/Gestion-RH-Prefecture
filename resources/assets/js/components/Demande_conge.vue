<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 10px;">Mes demandes de congés</h3>
                        <div class="card-tools">
                            <button  v-if="Object.keys(this.conges).length != 0 "  class="btn btn-success" @click="exportExcel" style="margin-top: 8px; margin-right: 13px;">Exporter <i class="fas fa-file-export fa-fw"></i></button>
                            <button :disabled="isDisabled"   v-else class="btn btn-success" style="margin-top: 8px; background-color: lightgray; border-color: gray; margin-right: 13px;">Exporter <i class="fas fa-file-export fa-fw"></i></button>
                  
                        </div>
                    </div>

                <div class="navbar navbar-expand-lg bg-light">
                    <div class="container-fluid">
                        <select  id="selectType" class='form-control '  style="width: 200px;" @focus="reset('type')" @change="getDemandesByType();" >
                            <option disabled selected value> -- Type -- </option>
                            <option  value="Congé de Maladie">Congé de Maladie</option>
                            <option  value="Congé de Maternité" >Congé de Maternité</option>
                            <option  value="Congé Normal">Congé Normal</option>
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
                        <button @click="getDemandesByDate()" class="btn btn-navbar" >
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
                                    <th>Type</th>
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                    <th>Commentaire</th>
                                    <th>Outils</th>
                                </tr>
                                <tr v-for="conge in conges" :key="conge.utilisateur">
                                    <th>{{conge.type}}</th>
                                    <th>{{conge.date_debut}}</th>
                                    <th>{{conge.date_fin}}</th>
                                    <th v-if="conge.Commentaire != null ">{{conge.Commentaire}}</th>
                                    <th v-else> - </th>
                                    <td>
                                    <a href="#" @click="etatDemande(conge) , calculateDurée(conge) , hideMenu()">
                                        <i class="fa fa-circle-check blue"></i>
                                        
                                    </a>
                                    
                                    <a v-if="isOKtoDelete(conge.id) == null" href="#" @click="deleteDemande(conge.id)">
                                    /
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="modal fade" id="TraitementDemnde" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" v-show="editmode" id="addNewLabel">Traitement</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
              <div class="modal-body" id="addNew">
                  <div class="container-fluid">
                    
                        <ul class="step-wizard-list">

                                <li class="step-wizard-item ">
                                <span class="progress-count">1</span>
                                <span class="progress-label">Demande Crée</span>
                                <span v-if="this.etat1 != null" class="progress-label">{{(this.etat1.created_at).split(" ")[0]}}</span>
                                <span v-else class="progress-label">-</span>                            
                                </li>

                                <li v-if = "this.etat2 == null" class="step-wizard-item current-item">
                                <span class="progress-count">2</span>
                                <span class="progress-label">Traitée Par le chef de division</span>
                                <span class="progress-label">-</span>
                                </li>

                                <li v-else class="step-wizard-item ">
                                <span class="progress-count">2</span>
                                <span class="progress-label">Traitée Par le chef de division</span>
                                <span v-if="this.etat2 != null" class="progress-label">{{(this.etat2.created_at).split(" ")[0]}}</span>
                                </li>

                                <li v-if=" this.etat2 == null & this.etat3 == null" class="step-wizard-item " >
                                <span class="progress-count">3</span>
                                <span class="progress-label">Validée Par l'Admin </span>
                                <span class="progress-label">-</span>
                                </li>
    
                                <li v-if=" this.etat2 != null & this.etat3 == null" class="step-wizard-item current-item " >
                                <span class="progress-count">3</span>
                                <span class="progress-label">Validée Par l'Admin</span>
                                <span class="progress-label">-</span>
                                </li>
    
                                <li v-if=" this.etat2 != null & this.etat3 != null" class="step-wizard-item " >
                                <span class="progress-count">3</span>
                                <span class="progress-label">Validée Par l'Admin</span>
                                <span v-if="this.etat3 != null" class="progress-label">{{(this.etat3.created_at).split(" ")[0]}}</span>
                                <span v-else class="progress-label">-</span>
                                </li> 
                        </ul>

                        <div class="row g-3" style="margin-left: 50px; margin-top: 30px;">
                            <div class="form-group col-md">
                                <label >Utilisateur</label>
                                <input disabled={!isEditMode}/ style="width: 200px" v-model="utilisateur" name="utilisateur" id="utilisateur" 
                                    class="form-control" >
                            </div>
                            
                            <div class="form-group col-md" style="margin-left: 80px;">
                                 <label >Solde (jour)</label>
                                 <input disabled={!isEditMode}/ style="width: 80px" v-model="nbJours"  name="nbJours" class="form-control" > 
                            </div>
 
                            <div class="form-group col-md">
                                <label >Durée (jour)</label>
                                <input disabled={!isEditMode}/ style="width: 80px" v-model="durée"  name="durée" class="form-control" >
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
                etat1:null,
                etat2:null,
                etat3:null,
                idConge : null,

                nbJours: null,
                utilisateur: null,
                elem : null,

                durée: 0,
                editmode: false,
                conges : {},
                form: new Form({
                    utilisateur :  ''  , 
                    date_debut:'',
                    date_fin:'',
                    type:'',
                    durée: '',
                    Commentaire:''
                })
            }
            
        },
        methods: {
            loadDemandeConge(){
                axios.get("api/loadDemandeConge/").then(({ data }) => (this.conges=data.data))
            },
            exportExcel(){
                var currentDate = new Date().toJSON().slice(0,10).replace(/-/g,'/');;
                saveExcel({
                data: this.conges,         
                fileName: this.form.type + "Mes-demandes-de-Congés-" + currentDate,
                columns: [
                { field: 'id', title: 'ID' },
                { field: 'type', title: 'Type' },
                { field: 'date_debut', title: 'Date Début' },
                { field: 'date_fin', title: 'Date Fin' },
                { field: 'Commentaire', title: 'Commentaire' }
              ]
            });

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
                                this.form.delete('api/demande_conge/'+id).then(()=>{
                                        swal.fire(
                                            'Supprimé!',
                                            'La Demande a été bien supprimer ',
                                            'Succès'
                                        )
                                    Fire.$emit('AfterCreate');
                                }).catch(()=> {
                                    swal("Manqué!", "Il y avait quelque chose qui n'allait pas.", "warning");
                                });
                         }
                    }).catch();

            },
            etatDemande(conge){

                this.etat1 = null;
                this.etat2 = null;
                this.etat3 = null;


                this.utilisateur = conge.utilisateur;

                ///recupéré le solde
                    axios.get("api/getSolde/"+conge.id).then(({ data }) => (this.nbJours = data.data))                              
                ///


                ///chercher les etats par le id de congé
                    this.idConge = conge.id;
                    
                    axios.get("api/getCongeEtat/"+this.idConge).then(({ data }) => (
                        this.etat1 = data.CongeEtat1[0],
                        this.etat2 = data.CongeEtat2[0],
                        this.etat3 = data.CongeEtat3[0]
                    )).then($('#TraitementDemnde').modal('show'));
                        
            },
            hideMenu(){
                if(this.elem == null){
                    this.elem = document.getElementById('menu');
                    this.elem.click();
                }
            },
            calculateDurée(conge){
                var date1 = new Date(conge.date_fin);
                var date2 = new Date(conge.date_debut);
                this.durée =  (date1 - date2 )/ (1000 * 3600 * 24) ;
            },
            reset(valeur){

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
            getDemandesByType(){
                var type = document.getElementById("selectType").value;
                axios.get("api/mesDemandes/demande_conge/byType/"+type).then(({ data }) => (this.conges = data))
            },
            getDemandesByDate(){
                var date_from = document.getElementById("search_date_from").value;
                var date_to = document.getElementById("search_date_to").value;

                this.$Progress.start();

                axios.get('api/mesDemandes/demande_conge/byDate/' + date_from + '/' + date_to).then(
                    ({ data }) => (this.conges = data),
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
            isOKtoDelete(id){
                let etat2 = null;

                axios.get("api/getCongeEtat/"+id).then(({ data }) => (
                        etat2 = data.CongeEtat2[0]
                ));

                return etat2;
            }
  
        },
        created() {
                this.loadDemandeConge();
                Fire.$on('AfterCreate',() => {
                this.loadDemandeConge();
                

           });
        //    setInterval(() => this.loadServices(), 3000);
            }
}
</script>


