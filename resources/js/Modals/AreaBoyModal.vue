<template>
    <div>
         <modal ref="woModal" modal-class-name="AddAreaBoy" :modalClasses="'modal-md'">
            <template slot="header">
                <div class="modal-title row">
                    <h2 class="col-12">
                        <span><b>{{ addOrUpdate ? 'Edit' : 'Add' }}</b></span>
                    </h2>
                </div>
            </template>
            <template slot="close-button">
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <!-- <i class="fa fa-window-close"></i> -->
                    <span>&times;</span>
                </button>
            </template>
            <template>

                <form @submit.prevent="saveData" id="areaBoyForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>

                    <div class="row mt-3 mb-3">
                        
                        <div class="col-md-12">
                            <custom-input
                                :label="'Findme ID'"
                                v-model="formData.findmeId"
                                :required="true"
                                type="text"
                                placeholder="Enter Findme ID"/>
                        </div>

                    </div>


                </form>
            </template>
            <template slot="footer">
                
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button form="areaBoyForm" type="submit" title="Click to save data" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    <span>Save</span>
                </button>
            </template>
         </modal>
    </div>
</template>
<script>
import Modal from "../components/CustomModal.vue";
import helper from '../helpers/helpers';
import { createNamespacedHelpers } from 'vuex';
import CustomInput from '../components/CustomInput.vue';
const { mapActions, mapGetters } = createNamespacedHelpers('administration');

export default {
    components: {
        Modal,
        CustomInput,
    },
    data() {
        return {
            saveLoading:false,
            addOrUpdate: false,


            formData: {
                id: 0,
                findmeId: "",
                

            },
        }
    },
    methods: {
        ...mapActions(['updateAreaBoyAction', 'saveAreaBoyAction', 'allAreaBoyAction']),

        openAddModal() {
            this.clearData();
            this.addOrUpdate = false;
            // helper.openModal(".AddAreaBoy");
            $(".AddAreaBoy").modal('show');
        },

        openEditModal(row) {
            this.clearData();
            this.formData.id= row.id;
            this.formData.findmeId= row.findme_id;

            this.addOrUpdate = true;
            helper.openModal(".AddAreaBoy");
            // $(".AddAreaBoy").modal('show');
        },

        hideModal() {
            helper.hideModal(".AddAreaBoy");
            // $(".AddAreaBoy").modal('hide');
        },

        clearData(){
            this.formData.id = "";
            this.formData.findmeId = "";
        },

        
        saveData() {
            // this.saveLoading = true;
            if(this.addOrUpdate) {
                const data = this.formData;
                this.updateAreaBoyAction(data).then((res) => {
                    this.saveLoading = false;
                    helper.successAlert("Updated Successfully");
                    this.clearData()
                    this.hideModal();
                }).catch((error) => {
                    this.saveLoading = false;
                    helper.errorMessage(error);
                });
            } else {
                const data = this.formData;
                this.saveAreaBoyAction(data).then((res) => {
                    this.saveLoading = false;
                    this.allAreaBoyAction();
                    this.hideModal();
                    helper.successAlert("Created Successfully");
                    this.clearData()
                }).catch((error) => {
                    this.saveLoading = false;
                    helper.errorMessage(error);
                });
            }

        },

    },
    created() {
        // this.allAreaBoyAction()
    },
    computed: {
        ...mapGetters([]),

        
    },

    mounted() {

    },

    
}
</script>
<style scoped>

</style>
