<template>
    <div>
         <modal ref="woModal" modal-class-name="AddRole" :modalClasses="'modal-md'">
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

                <!-- <form @submit.prevent="saveData" id="myForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>

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

                        <div class="col-md-12 mb-3">
                            <label><b>Select Permissions</b></label>
                            <treeselect v-model="formData.permissions" :multiple="true" :options="options"/>
                        </div>

                    </div>

                </form> -->
            </template>
            <template slot="footer">
                
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button form="myForm" type="submit" title="Click to save data" class="btn btn-primary">
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

// import Treeselect from '@riophae/vue-treeselect'
// import '@riophae/vue-treeselect/dist/vue-treeselect.css'

export default {
    components: {
        Modal,
        CustomInput,
        // Treeselect,
    },
    data() {
        return {
            saveLoading:false,
            addOrUpdate: false,


            formData: {
                id: 0,
                name: "",
                description: '',
                permissions: [],

            },
        }
    },
    methods: {
        ...mapActions(['updateRoleAction', 'saveRoleAction', 'allRoleAction', 'allPermissionAction']),

        openAddModal() {
            this.addOrUpdate = false;
            // helper.openModal(".AddRole");
            $(".AddRole").modal('show');
        },

        openEditModal(row) {
            this.clearData();

            this.formData.id= row.id;
            this.formData.name= row.name;
            this.formData.description= row.description;

            // row.permissions.forEach(item => this.formData.permissions.push({  
            //     id: item.id, 
            //     // label: item.description
            // }));

            this.formData.permissions = row.permissions.map(x => x.id);

            this.addOrUpdate = true;
            helper.openModal(".AddRole");
            // $(".AddRole").modal('show');
        },

        hideModal() {
            helper.hideModal(".AddRole");
            // $(".AddRole").modal('hide');
        },

        clearData(){
            this.formData.id = "";
            this.formData.name = "";
            this.formData.description= "";
            this.formData.permissions= [];
        },

        saveData() {
            this.saveLoading = true;
            if(this.addOrUpdate) {
                const data = this.formData;
                this.updateRoleAction(data).then((res) => {
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
                this.saveRoleAction(data).then((res) => {
                    this.saveLoading = false;
                    this.allRoleAction();
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
        this.allPermissionAction()
    },
    computed: {
        ...mapGetters(['getPermissions']),
        options() {
            return this.getPermissions.map(item => {
                return {id: item.id, label: item.description};
            })
        }

        
    },

    mounted() {

    },

    
}
</script>
<style scoped>

</style>
