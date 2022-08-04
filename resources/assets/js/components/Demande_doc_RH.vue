<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des demandes de document RH</h3>
                        <div class="card-tools">
                            <button class="btn btn-success"><i class="nav-icon fas fa-file-excel fa-fw"></i> Généré fichier excel </button>
                            <button  v-if="Object.keys(this.conges).length != 0 "  class="btn btn-success" @click="exportExcel" style="margin-top: 8px;">Exporter <i class="fas fa-file-export fa-fw"></i></button>
                            <button :disabled="isDisabled"   v-else class="btn btn-success" style="margin-top: 8px; background-color: lightgray; border-color: gray;">Exporter <i class="fas fa-file-export fa-fw"></i></button>
                         
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