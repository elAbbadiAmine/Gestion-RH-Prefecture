<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des demandes de congé</h3>
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
                                </tr>
                                <tr v-for="conge in conges" :key="conge.utilisateur">
                                    <th>{{conge.utilisateur}}</th>
                                    <th>{{conge.type}}</th>
                                    <th>{{conge.date_debut}}</th>
                                    <th>{{conge.date_fin}}</th>
                                    <th>{{conge.Commentaire}}</th>
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
export default {
        data() {
            return {
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
                axios.get("api/loadDemandeCongeAll/").then(({ data }) => (this.conges=data.data))
            },
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


