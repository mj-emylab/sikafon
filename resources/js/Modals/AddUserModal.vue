<template>
    <div>
         <modal ref="woModal" modal-class-name="AddGroupUser" :modalClasses="'modal-md'">
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

                <form @submit.prevent="saveData" id="addGroupUserForm">

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
                                v-model="formData.findme_id"
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
                <button form="addGroupUserForm" type="submit" title="Click to save data" class="btn btn-primary">
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
const { mapActions, mapGetters } = createNamespacedHelpers('single');

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
                findme_id: "",
                

            },
        }
    },
    methods: {
        ...mapActions(['saveGroupUserAction']),

        openAddModal(row) {
            this.clearData();

            this.formData.id = row.id;
            this.addOrUpdate = false;

            $(".AddGroupUser").modal('show');
        },

        hideModal() {
            helper.hideModal(".AddGroupUser");
        },

        clearData(){
            this.formData.id = 0;
            this.formData.findme_id = "";
        },

        
        saveData() {
            // this.saveLoading = true;
            const data = this.formData;
            this.saveGroupUserAction(data).then((res) => {
                this.saveLoading = false;
                this.hideModal();
                helper.successAlert("Created Successfully");
                this.clearData()
            }).catch((error) => {
                this.saveLoading = false;
                helper.errorMessage(error);
            });

        },

    },
    created() {
    },
    computed: {

        
    },

    mounted() {

    },

    
}
</script>
<style scoped>

</style>
