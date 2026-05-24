<template>
    <div>

        <modal ref="woModal" modal-class-name="ShowPackage" :modalClasses="'modal-md'">
            <template slot="header">
                <div class="modal-title row">
                    <h2 class="col-12">
                        <span><b>Show</b></span>
                    </h2>
                </div>
            </template>
            <template slot="close-button">
                <button @click.prevent="hideShowModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <!-- <i class="fa fa-window-close"></i> -->
                    <span>&times;</span>
                </button>
            </template>
            <template>

                

                <loading
                    :active="saveLoading"
                    :is-full-page="false"
                    loader="bars"
                    :width="20"
                    :height="20"/>

                <div v-if="showShow" class="mt-3">
                    <div class="row mx-1 my-3" v-for="(row, index) in showData" :key="index">
                        <div class="col-10">
                            <button class="col-12 bg-green" @click.prevent="openEditModal(row)">
                                Edit/View
                            </button>
                        </div>
                        <div class="col-1 mt-2">
                            <a href="" title="Click to delete input fields" @click.prevent="deleteShowItem(row)">
                                <i class="fa fa-trash text-danger"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </template>
            <template slot="footer">
                <button @click.prevent="hideShowModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
            </template>
        </modal>

        <modal ref="woModal" modal-class-name="AddPackage" :modalClasses="'modal-md'">
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

                <form @submit.prevent="saveData" id="packageForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>


                    <div class="col-md-12 flex-fill">
                        <div v-if="showImage != 0">
                            <img v-for="(show, index) in showImage" :key="index" :src="show" alt="Image"
                                class="img img-thumbnail" style="width: 70px; height: 70px">
                        </div>
                        <div v-if="showUpdateImage">
                            <img :src="showUpdateImage" alt="Image"
                                class="img img-thumbnail" style="width: 70px; height: 70px">
                        </div>
                    </div>

                    <div class="row mt-3 mb-3">
                        <div class="row">
                            <custom-input
                                :label="'Name'"
                                v-model="formData.name"
                                :required="true"
                                type="text"
                                placeholder="Enter name"/>
                        </div>
                        <div class="row">
                            <custom-input
                                :label="'Cost'"
                                v-model="formData.cost"
                                :required="true"
                                type="text"
                                placeholder="Enter cost"/>
                        </div>
                        <div class="row">
                            <custom-input
                                :label="'Duration'"
                                v-model="formData.duration"
                                :required="true"
                                type="text"
                                placeholder="Enter duration"/>
                        </div>
                        <div class="row mb-3">
                            <custom-input
                                :label="'Description'"
                                v-model="formData.description"
                                :required="true"
                                type="text"
                                placeholder="Enter description"/>
                        </div>
                        
                        <div class="row">
                            <label><b>Upload Picture</b></label>
                            <wo-file-uploader
                            :variant="'danger'"
                            :size="size"
                            @onUpload="uploadFiles"/>

                        </div>

                    </div>


                    <hr>
                    <div class="mt-3">
                        <div class="row" v-for="(field, index) in formData.details" :key="index">
                            
                            <div class="row">
                                <custom-input
                                    :label="'Description'"
                                    v-model="field.description"
                                    type="text"
                                    placeholder="Enter Description"
                                />

                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <custom-input
                                        :label="'Name'"
                                        v-model="field.name"
                                        type="text"
                                        placeholder="Enter Name"
                                    />
                                </div>
                                <div class="col-md-1 mt-5">
                                    <a href="" title="Click to delete input fields" @click.prevent="removeField(index)">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </form>
            </template>
            <template slot="footer">
                <button class="btn btn-success btn-sm float-left mr-1" title="Show add social media input fields" @click.prevent="addMore()">
                    <i class="fa fa-plus"></i> more
                </button>
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button form="packageForm" type="submit" title="Click to save data" class="btn btn-primary">
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
import WoFileUploader from '../components/WoFileUploader.vue';
const { mapActions, mapGetters } = createNamespacedHelpers('administration');

export default {
    components: {
        Modal,
        CustomInput,
        WoFileUploader,
    },
    data() {
        return {
            saveLoading:false,
            addOrUpdate: false,
            size: 'col-12',

            showShow: false,
            showData: [],


            formData: {

                id: 0,
                name: "",
                image: '',
                description: '',
                duration: '',
                cost: '',
                service_id: 0,

                details: [
                    {id: 0, name: "", description: ''}
                ],

            },
            showImage: [],
            showUpdateImage: "",
        }
    },
    methods: {
        ...mapActions(['updatePackageAction', 'savePackageAction', 'allPackageAction', 'deletePackageItemAction', 'deletePackageAction']),

        ////
        openAddPackageModal(row) {
            this.clearDataShow();

            this.showData = row.package;
            this.showShow = true;

            $(".ShowPackage").modal('show');
        },

        hideShowModal() {
            this.showShow = false;
            helper.hideModal(".ShowPackage");
        },

        clearDataShow(){
            this.showData = [];
            this.show = false;
        },

        deleteItem(row, index) {
            helper.deletingAlert("record will be deleted")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.deletePackageItemAction(row)
                    .then((res) => {
                        // this.formData.details = this.formData.details.filter((value) =>value.id != row.id);
                        this.formData.details.splice(index, 1)
                        this.isLoading = false;
                        helper.successAlert("record deleted");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
            });
        },

        deleteShowItem(row) {
            helper.deletingAlert("record will be deleted")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.deletePackageAction(row)
                    .then((res) => {

                        // this.hideShowModal();

                        // let i = this.showData.map(item => item.id).indexOf(row.id);
                        // console.log(this.showData[i]);
                        // this.showData.slice(i, 1);

                        this.showData = this.showData.filter((value) =>value.id != row.id);


                        this.isLoading = false;
                        helper.successAlert("record deleted");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
            });
        },


        ///////

        addMore() {
            this.formData.details.push({
                id: 0,
                name: "",
                description: "",

            });
        },

        removeField(index) {
            let row = this.formData.details[index];
            if (row.id != 0) {
                this.deleteItem(row, index);
            } else {
                this.formData.details.splice(index, 1)
            }
            
        },

        openAddModal(row) {
            this.formData.service_id= row.id;

            this.addOrUpdate = false;
            $(".AddPackage").modal('show');
        },

        openEditModal(row) {
            // helper.hideModal(".AddPackage");
            this.formData.service_id= row.service_id;

            this.formData.id= row.id;
            this.formData.name= row.name;
            this.formData.description= row.description;
            this.formData.cost= row.cost;
            this.formData.duration= row.duration;

            // this.formData.image = row.image;
            if(row.image) {
              this.showUpdateImage = row.image;
            }

            this.formData.details = [];
            row.item.forEach(item => this.formData.details.push({
                id: item.id,
                name: item.name,
                description: item.description
            }));



            this.addOrUpdate = true;
            helper.openModal(".AddPackage");
        },

        hideModal() {
            helper.hideModal(".AddPackage");
        },

        clearData(){
            this.formData.id = 0;
            this.formData.service_id = 0;
            this.formData.name = "";
            this.formData.image= "";
            this.formData.duration= "";
            this.formData.cost= "";
            this.formData.description= "";

            this.size= 'col-12';

            this.formData.details= [
                {id: 0, name: "", description: ""}
            ];
        },

        uploadFiles(file){
            if(file){
                this.formData.image = helper.uploadFileUsingComponent(file);
                this.showImage = helper.previewImageComponent(this.formData.image);
                this.formData.image = file;
                this.size= 'col-11';
            }else{
                this.formData.image = null;
                this.showImage = [];
                this.size= 'col-12';
            }
        },

        saveData() {
            // this.saveLoading = true;
            if(this.addOrUpdate) {
                const data = this.formData;
                this.updatePackageAction(data).then((res) => {
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
                this.savePackageAction(data).then((res) => {
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
        // this.allPackageAction()
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
