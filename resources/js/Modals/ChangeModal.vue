<template>
    <div>
         <modal ref="woModal" modal-class-name="AddChange" :modalClasses="'modal-md'">
            <template slot="header">
                <div class="modal-title row">
                    <h2 class="col-12">
                        <span><b>Change Type</b></span>
                    </h2>
                </div>
            </template>
            <template slot="close-button">
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <!-- <i class="fa fa-window-close"></i> -->
                    <span>&times;</span>
                </button>
            </template>
            <template v-if="show">

                <form @submit.prevent="saveData" id="statusForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>

                    <div class="row mt-3 mb-3">
                        <label><b>Type</b></label>
                        <v-select
                            :options="types"
                            :label="'name'"
                            :reduce="types => types.id"
                            v-model="formData.status"
                            placeholder="Select Type">

                            <!-- <template #search="{attributes, events}">
                                <input
                                    class="vs__search"
                                    :required="!formData.status"
                                    v-bind="attributes"
                                    v-on="events" />
                            </template> -->
                        </v-select>

                    </div>
                    <div class="row mt-3 mb-3">
                        <label><b>Roles</b></label>
                        <v-select
                            :options="getRoles"
                            :label="'name'"
                            :reduce="getRoles => getRoles.name"
                            v-model="formData.role"
                            placeholder="Select Role">

                            <template #search="{attributes, events}">
                                <input
                                    class="vs__search"
                                    :required="!formData.role"
                                    v-bind="attributes"
                                    v-on="events" />
                            </template>
                        </v-select>
                    </div>

                </form>
            </template>
            <template slot="footer">
                
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button form="statusForm" type="submit" title="Click to save data" class="btn btn-primary">
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
            show: false,

            types:[
                {id: 0, name: 'User'},
                {id: 1, name: 'Super Admin'},
                {id: 2, name: 'Admin'},
                {id: 3, name: 'Agent'},
                {id: 4, name: 'Others'},
            ],


            formData: {
                id: 0,
                status: 0,
                role: 0,

            },
        }
    },
    methods: {
        ...mapActions(['changeUserAction', 'allRoleAction']),

        openAddModal(row) {
            this.show = false;

            this.formData.id= row.id;
            this.formData.status= row.status;
            this.formData.role= row.role;

            this.show = true;
            helper.openModal(".AddChange");
            // $(".AddChange").modal('show');
        },

        openEditModal(row) {
            this.show = false;
            this.formData.id= row.id;
            this.formData.status= row.status;
            this.formData.role= row.role;

            this.addOrUpdate = true;
            helper.openModal(".AddChange");
        },

        hideModal() {
            helper.hideModal(".AddChange");
        },

        clearData(){
            this.show = false;
            this.formData.id = 0;
            this.formData.status = 0;
            this.formData.role = 0;
        },

        saveData() {
            // this.saveLoading = true;
            const data = this.formData;
            this.changeUserAction(data).then((res) => {
                this.saveLoading = false;
                helper.successAlert("Updated Successfully");
                this.clearData()
                this.hideModal();
            }).catch((error) => {
                this.saveLoading = false;
                helper.errorMessage(error);
            });

        },

    },
    created() {
        this.allRoleAction()
    },
    computed: {
        ...mapGetters(['getRoles']),
    },

    mounted() {

    },

    
}
</script>
<style scoped>

</style>
