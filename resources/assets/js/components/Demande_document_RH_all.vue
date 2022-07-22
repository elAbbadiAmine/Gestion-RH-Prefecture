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
                                    <td> <a href="#" @click="viewUser(user)">
                            <i class="fa fa-eye green"></i>
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


