<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Mes demandes de documents RH  </h3>
                        <div class="card-tools">
                            <button  v-if="Object.keys(this.demanderh).length != 0 "  class="btn btn-success" @click="exportExcel" style="margin-top: 8px;">Exporter <i class="fas fa-file-export fa-fw"></i></button>
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
                                    <th>Outils</th>
                                </tr>
                                <tr v-for="rh in demanderh" :key="rh.utilisateur">
                                    <th>{{rh.type}}</th>
                                    <th>{{rh.langue}}</th>
                                    <th v-if="rh.Commentaire != null ">{{rh.Commentaire}}</th>
                                    <th v-else> - </th>
                                   <td>
                                    <a href="#" @click=" viewDemande(), hideMenu()">
                                        <i class="fa fa-circle-check blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteDemande(rh.id) , hideMenu()">
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
    </div>
</template>

<script>
import swal from 'sweetalert2';

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
            hideMenu(){
                if(this.elem == null){
                    this.elem = document.getElementById('menu');
                    this.elem.click();
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
            viewDemande(){
                
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