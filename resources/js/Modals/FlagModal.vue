<template>
    <div>
         <modal ref="woModal" modal-class-name="AddFlag" :modalClasses="'modal-md'">
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

                <form @submit.prevent="saveData" id="flagForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>

                    <div class="col-md-12 mb-3">
                        <label><b>Type</b></label>
                        <v-select
                            :options="types"
                            :label="'name'"
                            :reduce="types => types.id"
                            v-model="formData.is_percent"
                            placeholder="Select Type">

                            <!-- <template #search="{attributes, events}">
                                <input
                                    class="vs__search"
                                    :required="!formData.is_percent"
                                    v-bind="attributes"
                                    v-on="events" />
                            </template> -->
                        </v-select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label><b>Status</b></label>
                        <v-select
                            :options="statuses"
                            :label="'name'"
                            :reduce="statuses => statuses.id"
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
                        
                        
                        <div class="col-md-12">
                            <custom-input
                                :label="'Name'"
                                v-model="formData.name"
                                :required="true"
                                type="text"
                                placeholder="Enter name"/>
                        </div>

                        <div class="col-md-12">
                            <custom-input
                                :label="'Display Name'"
                                v-model="formData.display_name"
                                :required="true"
                                type="text"
                                placeholder="Enter display name"/>
                        </div>
                        
                        <div class="col-md-12">
                            <custom-input
                                :label="'Value'"
                                v-model="formData.value"
                                :required="true"
                                type="number"
                                placeholder="Enter value"/>
                        </div>

                    </div>


                </form>
            </template>
            <template slot="footer">
                
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button form="flagForm" type="submit" title="Click to save data" class="btn btn-primary">
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

            types:[
                {id: 0, name: 'value'},
                {id: 1, name: 'percentage'}
            ],

            statuses:[
                {id: 0, name: 'Inactive'},
                {id: 1, name: 'Active'}
            ],


            formData: {
                id: 0,
                name: "",
                display_name: "",
                is_percent: 0,
                status: 0,
                
                value: 0,

            },
        }
    },
    methods: {
        ...mapActions(['updateFlagAction', 'saveFlagAction', 'allFlagAction']),

        openAddModal() {
            this.clearData();
            this.addOrUpdate = false;
            // helper.openModal(".AddFlag");
            $(".AddFlag").modal('show');
        },

        openEditModal(row) {
            this.clearData();
            this.formData.id= row.id;
            this.formData.display_name= row.display_name;
            this.formData.name= row.name;
            this.formData.value= row.value;
            this.formData.is_percent= row.is_percent;
            this.formData.status= row.status;



            this.addOrUpdate = true;
            helper.openModal(".AddFlag");
            // $(".AddFlag").modal('show');
        },

        hideModal() {
            helper.hideModal(".AddFlag");
            // $(".AddFlag").modal('hide');
        },

        clearData(){
            this.formData.id = "";
            this.formData.name = "";
            this.formData.display_name = "";
            this.formData.value= 0;
            this.formData.is_percent = 0;
            this.formData.status = 0;
        },

        
        saveData() {
            // this.saveLoading = true;
            if(this.addOrUpdate) {
                const data = this.formData;
                this.updateFlagAction(data).then((res) => {
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
                this.saveFlagAction(data).then((res) => {
                    this.saveLoading = false;
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
