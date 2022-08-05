<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 5px;">Liste des demandes de docoument RH </h3>
                        <form class="card-tools" role="search" ref="#">
                            <input v-model="keyword" @click="reset('search')" class="form-control me-2"  style="width: 280px; margin-right: 120px; margin-top: 5px;" type="search" placeholder="Rechercher par Utilisateur" aria-label="Search" id="shearchField">
                        </form>
                         
                        <div class="card-tools">
                            <button v-if="Object.keys(this.demanderh).length != 0 " class="btn btn-success" style="margin-top: 5px;" @click="exportExcel">Exporter <i class="fas fa-file-export fa-fw"></i></button>
                            <button  v-else class="btn btn-success" style="background-color: lightgray; border-color: gray;margin-top: 5px;">Exporter <i class="fas fa-file-export fa-fw"></i></button>                      
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
                                    <th>Utilisateur</th>
                                    <th>Type</th>
                                    <th>Langue</th>
                                    <th>Commentaire</th>
                                    <th>Outils</th>
                                </tr>
                                <tr v-for="rh in demanderh" :key="rh.utilisateur">
                                    <th>{{rh.utilisateur}}</th>
                                    <th>{{rh.type}}</th>
                                    <th>{{rh.langue}}</th>
                                    <th v-if="rh.Commentaire != null ">{{rh.Commentaire}}</th>
                                    <th v-else> - </th>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { saveExcel } from '@progress/kendo-vue-excel-export';
import { Grid } from '@progress/kendo-vue-grid';


export default {
     watch: {
            keyword(after, before) {
                if(this.keyword == ""){
                    Fire.$emit('AfterCreate');
                }
                this.getDemandesByName();
            }
        },
        data() {
            return {
                keyword :null,
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
            getDemandesByType(){
                var type = document.getElementById("selectType").value;
                axios.get("api/demande_rh/byType/"+type).then(({ data }) => (this.demanderh = data))
            },
            getDemandesByLangue(){
                var Langue = document.getElementById("selectLangue").value;
                axios.get("api/demande_rh/byLangue/"+Langue).then(({ data }) => (this.demanderh = data))
            },
            getDemandesByName(){
                this.$Progress.start();
                var nom = document.getElementById("shearchField").value;
                axios.get("api/demande_rh/byName/"+nom).then(({ data }) => (this.demanderh = data));
                this.$Progress.finish();
            },
            
            loadDemandeRhAll(){
                axios.get("api/loadDemandeRhAll/").then(({ data }) => (this.demanderh=data.data))
            },
            exportExcel(){
                saveExcel({
                data: this.demanderh,
                fileName: "Demandes-de-Document-RH",
                columns: [
                { field: 'utilisateur', title: 'utilisateur' },
                { field: 'type', title: 'type' },
                { field: 'langue', title: 'langue' },
                { field: 'Commentaire', title: 'Commentaire' }

              ]
            });},
            reset(valeur){

                if(valeur != 'type' || valeur == 'all')
                    $('#selectType').prop('selectedIndex',0);
                    
                if(valeur != 'Langue' || valeur == 'all')
                    $('#selectLangue').prop('selectedIndex',0);

                if(valeur != 'search' || valeur == 'all')
                    this.keyword="";   
                    $('#shearchField').val('');
                
                Fire.$emit('AfterCreate');

            }
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


