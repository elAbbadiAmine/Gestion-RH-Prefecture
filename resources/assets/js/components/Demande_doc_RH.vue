<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des demandes de document RH</h3>
                        <div class="card-tools">
                            <button class="btn btn-success"><i class="nav-icon fas fa-file-excel fa-fw"></i> Généré fichier excel </button>
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
                                </tr>
                                <tr v-for="rh in demanderh" :key="rh.utilisateur">
                                    <th>{{rh.type}}</th>
                                    <th>{{rh.langue}}</th>
                                    <th>{{rh.Commentaire}}</th>
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
      data(){
            return{
                editmode: false,
                demanderh: {},
                form: new Form({
                    type:'',
                    langue:'',
                    Commentaire:''
                })
            }
        

      },
      methods: {
            loadDemandeRh(){
                axios.get("api/loadDemandeRh/").then(({ data }) => (this.demanderh=data.data))
            },
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