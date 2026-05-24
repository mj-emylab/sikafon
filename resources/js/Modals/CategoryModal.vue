<template>
    <div>
         <modal ref="woModal" modal-class-name="AddCategory" :modalClasses="'modal-md'">
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

                <form @submit.prevent="saveData" id="categoryForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>

                    <div class="row mt-3 mb-3">
                        <label><b>Select Type</b></label>
                            <v-select
                                :options="types"
                                :label="'name'"
                                :reduce="types => types.name"
                                v-model="formData.type"
                                placeholder="Select Type">

                                <template #search="{attributes, events}">
                                    <input
                                        class="vs__search"
                                        :required="!formData.type"
                                        v-bind="attributes"
                                        v-on="events" />
                                </template>
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
                        <div class="col-md-12 mb-3">
                            <label><b>Description</b></label>
                            <textarea
                                placeholder="Enter Description"
                                cols="30"
                                class="form-control"
                                rows="3"
                                style="resize:none"
                                v-model="formData.description"
                                required
                            ></textarea>
                        </div>

                    </div>

                </form>
            </template>
            <template slot="footer">
                
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button form="categoryForm" type="submit" title="Click to save data" class="btn btn-primary">
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

            types: [
                {id:1, name: 'business'},
                {id:2, name: 'event'},
                {id:3, name: 'professional'},
                {id:4, name: 'job'},
                {id:5, name: 'service'}
            ],


            formData: {
                id: 0,
                name: "",
                description: '',
                type: "",

            },
        }
    },
    methods: {
        ...mapActions(['updateCategoryAction', 'saveCategoryAction', 'allCategoryAction']),

        openAddModal() {
            this.clearData();
            this.addOrUpdate = false;
            // helper.openModal(".AddCategory");
            $(".AddCategory").modal('show');
        },

        openEditModal(row) {
            this.clearData();
            this.formData.id= row.id;
            this.formData.name= row.name;
            this.formData.description= row.description;
            this.formData.type= row.type;

            this.addOrUpdate = true;
            helper.openModal(".AddCategory");
            // $(".AddCategory").modal('show');
        },

        hideModal() {
            helper.hideModal(".AddCategory");
            // $(".AddCategory").modal('hide');
        },

        clearData(){
            this.formData.id = "";
            this.formData.name = "";
            this.formData.description= "";
            this.formData.type= "";
        },

        saveData() {
            // this.saveLoading = true;
            if(this.addOrUpdate) {
                const data = this.formData;
                this.updateCategoryAction(data).then((res) => {
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
                this.saveCategoryAction(data).then((res) => {
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
        // this.allCategoryAction()
    },
    computed: {
        // ...mapGetters([]),

        
    },

    mounted() {

    },

    
}
</script>
<style scoped>

</style>
