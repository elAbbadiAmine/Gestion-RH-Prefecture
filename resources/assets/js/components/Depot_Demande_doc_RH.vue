<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Demande des Documents RH</div>
                    <form @submit.prevent=" create_demande()">
                    <div class="card-body">
                    <div>
                        <div class="form-group " >
                            <label>Type de document :  </label>
                            <select class='form-control' v-model="form.type">
                                <option>Certificat de travail</option>
                                <option>Etat d'engagement</option>
                            </select>
                        </div>
                          
                        </div>
                          <div class="form-group " >
                            <label>Langue de document : </label>
                            <select class='form-control' v-model="form.langue">
                                <option>Français</option>
                                <option>Arabe</option>
                            </select>

                        </div>
                        <div class="form-group mt-4">
                        <textarea v-model="form.Commentaire" name="Commentaire" id="Commentaire"
                        placeholder="Commentaire pour les utilisateurs (Optionnel)"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('Commentaire') }"></textarea>
                        <has-error :form="form" field="Commentaire"></has-error>
                    </div>
                        <button class="btn btn-success mt-2">Valider</button>
                     
                        
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
   
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
             form: new Form({
                    utilisateur:'',
                    type:'',
                    langue:'',
                    Commentaire:''
                })
            };
        },
        methods: {
            create_demande(){
                this.$Progress.start();
                this.form.post('api/demande_rh')
                .then(()=>{
                    swal.fire(
                        'Succès',
                        'la Demande a été bien crée',
                        'Succès'
                        )
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    toast({
                        type: 'success',
                        title: ' la demande a été crée avec succés'
                        })
                this.$Progress.finish();
                })
                .catch(()=>{
                    
                });
                
            },
            }
        }
</script>