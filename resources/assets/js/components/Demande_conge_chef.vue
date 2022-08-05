<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des demandes de congé </h3>
                        <div class="card-tools">
                            <button class="btn btn-success"><i class="nav-icon fas fa-file-excel fa-fw"></i> Généré fichier excel </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>utilisateur</th>
                                    <th>Type</th>
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                    <th>Commentaire</th>
                                    <th>Outils</th>
                                </tr>
                                <tr v-for="conge in conges" :key="conge.utilisateur">
                                    <th>{{conge.utilisateur}}</th>
                                    <th>{{conge.type}}</th>
                                    <th>{{conge.date_debut}}</th>
                                    <th>{{conge.date_fin}}</th>
                                    <th>{{conge.Commentaire}}</th>
                                    <td>
                                    <a href="#" @click="viewDemande(conge) , calculateDurée(conge) , hideMenu()">
                                        <i class="fa fa-eye green"></i>
                                    </a>
                                    /
                                    <a href="#" @click="etatDemande(conge) , calculateDurée(conge) , hideMenu()">
                                        <i class="fa fa-circle-check blue"></i>
                                    </a>
                                    /
                                    <a  href="#" @click="deleteDemande(conge.id)">
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

        <!--afficher details-->
          <div class="modal fade" id="viewDemnde" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
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
                            <label >Utilisateur</label>
                             <input disabled={!isEditMode}/ v-model="form.utilisateur" name="utilisateur" id="utilisateur" 
                                  class="form-control" >
                          </div>
                          <div class="form-group">
                                <label >Type</label>
                                <input disabled={!isEditMode}/ v-model="form.type"  name="type" class="form-control" >
                          </div>
                          <div class="form-group">
                                <label >Date de début</label>
                                <input disabled={!isEditMode}/ v-model="form.date_debut"  name="date_debut" class="form-control" >
                          </div>
                          <div class="form-group">
                                <label >Date de fin</label>
                                <input disabled={!isEditMode}/ v-model="form.date_fin"  name="date_fin" class="form-control" >
                          </div>
                          <div class="form-group">
                                <label >Commentaire</label>
                                <textarea placeholder="-" disabled={!isEditMode}/ v-model="form.Commentaire"  name="Commentaire" class="form-control" >
                                </textarea>
                          </div>
                          
                          <div v-if="form.type == 'Congé de Maladie'" class="form-group">
                                <label >Télécharger la Certificat</label>
                                <button style="display:block ;" @click="telechargerCertificat()" type="button" class="btn btn-outline-success">Télécharger</button>
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

        <!--Traitement de la demande-->
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
                            <button v-if="this.etat2 == null" type="button"  @click="traiterDemande()"  class="btn btn-primary">Traiter la demande</button>                    
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
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
                axios.get("api/loadDemandeCongeChef/").then(({ data }) => (this.conges=data.data))
            },
            viewDemande(user){
                this.editmode = true;
                $('#viewDemnde').modal('show');
                this.form.fill(user);
            },
            calculateDurée(conge){
                var date1 = new Date(conge.date_fin);
                var date2 = new Date(conge.date_debut);
                this.durée =  (date1 - date2 )/ (1000 * 3600 * 24) ;
            },
            hideMenu(){
                if(this.elem == null){
                    this.elem = document.getElementById('menu');
                    this.elem.click();
                }
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
            traiterDemande(){
                // ajouter congeEtat 2 ---> demande traitée par le chef de division 
                    let $idEtat = 2;
                    axios.post("api/setCongeEtat/"+this.idConge+"/"+$idEtat).then(()=>{
                    swal.fire(
                        'Demande Traitée !',
                        'Votre Demande est Traitée ',
                        'Succès'
                    )});
                    $('#TraitementDemnde').modal('hide');                          
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
            isOkToDelete(id){
                
                let etat = null;/*
                let $idEtat = 2;
                axios.get("api/getCongeEtat/"+id+'/'+$idEtat).then(({ data }) => (etat = data.data));
                if(etat == null){
                    return true
                }
                return false;
                */
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


