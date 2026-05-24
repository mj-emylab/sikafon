<template>
  <!-- Content Wrapper. Contains page content -->
  <div>

    <section class="content-header">
      <h1>
        Files
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><router-link :to="'/index'"><i class="fa fa-dashboard"></i> Home</router-link>></li>
        <li class="active">My Profile</li>
      </ol>
    </section>
    
    <section class="content">

        <div class="row">
            <!-- <div class="col-md-3">

            <img class="" src="images/event.png" style="width: 100%; height: 100%; margin-left: auto;margin-right: auto;" />
            </div> -->
        
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs bg-red">

                        <div style="margin-left:10px; margin-bottom:5px;">
                            <span>
                                <loading
                                    :active="isLoading"
                                    :is-full-page="false"
                                    loader="bars"
                                    :width="25"
                                    :height="25"
                                ></loading>
                            </span>
                            <button style="float:right;" @click.prevent="galleryModal()" type="button" class="btn btn-danger mb-2 mt-2 float-right mr-1">
                                <i class="fa fa-plus"></i>
                                Add Gallery
                            </button>
                            <button style="float:right;" @click.prevent="fileModal()" type="button" class="btn btn-danger mb-2 mt-2 float-right mr-1">
                                <i class="fa fa-plus"></i>
                                Add Files
                            </button>
                            <button style="float:right;" @click.prevent="skillModal()" type="button" class="btn btn-danger mb-2 mt-2 float-right mr-1">
                                <i class="fa fa-plus"></i>
                                Skill
                            </button>
                        </div>
                    
                    </ul>
                    <div class="tab-content">
                    
                        <wo-table
                            :total-records="getUserProfiles ? getUserProfiles.length : 0"
                            :remote="false"
                            :columns="columns"
                            :enable-check-box="false"
                            :rows="getUserProfiles">
                            
                            <template #status="{row}">
                                <span class="badge badge-success" @click.prevent="editStatus(row)" v-if="row.status == 0">
                                    Active
                                </span>
                                <span class="badge badge-info" @click.prevent="editModal(row)" v-else>
                                    Inactive
                                </span>
                            </template>
                            <template #created_at="{row}">
                                {{ row.created_at | dateOnly }}
                            </template>
                            <template #actions="{row}">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown" data-bs-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a  @click.prevent="editModal(row)" class="dropdown-item"  title="Edit" href="#">
                                            <i class="fa fa-pencil text-success"></i> Edit
                                        </a>
                                        <a @click.prevent="deleteItem(row)" class="dropdown-item" title="Delete" href="#">
                                            <i class="fa fa-trash text-danger"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </template>
                        </wo-table>
                    </div>


                    <template>
                        <VueFileAgent
                            :uploadConfig="
                                (xhr) => {
                                    xhr.timeout = 25000;
                            }"

                            ref="vueFileAgent"
                            :capture="'user'"
                            :editable="false"
                            :sortable="false"
                            :resumable="true"
                            :disabled="false"
                            :theme="'grid'"
                            :multiple="true"
                            :deletable="true"
                            :meta="true"
                            :linkable="true"
                            :accept="'image/*,.zip,audio/*,.pdf,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document'"
                            :maxSize="'10MB'"
                            :maxFiles="14"
                            :helpText="'Choose images or zip files'"
                            :errorText="{
                            type: 'Invalid file type. Only images or zip Allowed',
                            size: 'Files should not exceed 10MB in size',
                            }"
                            @select="filesSelected($event)"
                            @beforedelete="onBeforeDelete($event)"
                            @delete="fileDeleted($event)"

                            @upload="onUpload($event)"
                            @upload:error="onUploadError($event)"

                            v-model="fileRecords"
                        ></VueFileAgent>
                        <button :disabled="!fileRecordsForUpload.length" @click="uploadFiles()">
                            Upload {{ fileRecordsForUpload.length }} files
                        </button>
                    </template>
                        
                        
                </div>
            </div>
        </div>

    </section>

    <profile-modal ref="profiles" />
    <gallery-modal ref="gallery" />
    <skill-modal ref="skill" />

  </div>
</template>

<script>

    import WoTable from "../../components/WoTable.vue";
    import helper from '../../helpers/helpers.js';
    import ProfileModal from '../../modals/UserFileModal';
    import GalleryModal from '../../Modals/GalleryModal.vue';
    import SkillModal from '../../modals/SkillModal';

    import { createNamespacedHelpers } from 'vuex';
    const { mapActions, mapGetters } = createNamespacedHelpers('administration');

    export default {
            components: { WoTable, ProfileModal, SkillModal, GalleryModal },

            data() {
                return {
                isLoading: false,
                columns: [
                    { label: 'Name', field: 'name'},
                    // { label: 'Category', field: 'category.name'},
                    { label: 'Description', field: 'about'},
                    { label: 'Phone', field: 'phone'},
                    { label: 'Status', field: 'status'},
                    { label: 'Created Date', field: 'created_at'},
                    { label: 'Actions', field: 'actions', sortable: false, thClass: 'text-center', tdClass: 'text-center'}
                ],



                fileRecords: [
                    {
                        "name":"Some Invalid.exe",
                        "size": 8165824,
                        "type": "application/vnd.microsoft.portable-executable",
                        "ext":"exe",
                        "url": "",
                    },
                    {
                        "name": "Golf.mp4",
                        "lastModified": 1576563996233,
                        "sizeText": "549 KB",
                        "size": 561813,
                        "type": "video/mp4",
                        "ext": "mp4",
                        "dimensions": {
                        "width": 640,
                        "height": 360
                        },
                        "url": "http://127.0.0.1:8000/assets/Golf.mp4",
                        "videoThumbnail": "http://127.0.0.1:8000/assets/Golf-thumb.jpg",
                        "imageColor": [66, 62, 45]
                    },
                    {
                        "name":"Some Large File.zip",
                        "size": 25165824, // 24 MB
                        "type": "application/zip",
                        "ext":"zip",
                    },
                ],
                // uploadUrl: 'https://www.mocky.io/v2/5d4fb20b3000005c111099e3',
                uploadUrl: 'http://127.0.0.1:8000/assets/test/',
                // uploadHeaders: { 'X-Test-Header': 'vue-file-agent' },
                fileRecordsForUpload: [], // maintain an upload queue
            }
        },
        methods: {
        ...mapActions(['allUserProfileAction', 'deleteUserProfileAction', 'updateUserProfileAction']),


            uploadFiles: function () {
                // Using the default uploader. You may use another uploader instead.
                // this.$refs.vueFileAgent.upload(this.uploadUrl, this.uploadHeaders, this.fileRecordsForUpload);
                alert('hi zaid')
                console.log(this.fileRecordsForUpload)
                this.fileRecordsForUpload = [];
            },
            deleteUploadedFile: function (fileRecord) {
                // Using the default uploader. You may use another uploader instead.
                // this.$refs.vueFileAgent.deleteUpload(this.uploadUrl, this.uploadHeaders, fileRecord);
            },
            filesSelected: function (fileRecordsNewlySelected) {
                var validFileRecords = fileRecordsNewlySelected.filter((fileRecord) => !fileRecord.error);
                this.fileRecordsForUpload = this.fileRecordsForUpload.concat(validFileRecords);
            },
            onBeforeDelete: function (fileRecord) {
                var i = this.fileRecordsForUpload.indexOf(fileRecord);
                if (i !== -1) {
                    // queued file, not yet uploaded. Just remove from the arrays
                    this.fileRecordsForUpload.splice(i, 1);
                    var k = this.fileRecords.indexOf(fileRecord);
                    if (k !== -1) this.fileRecords.splice(k, 1);
                    } else {
                        if (confirm('Are you sure you want to delete?')) {
                            this.$refs.vueFileAgent.deleteFileRecord(fileRecord); // will trigger 'delete' event
                    }
                }
            },
            fileDeleted: function (fileRecord) {
                var i = this.fileRecordsForUpload.indexOf(fileRecord);
                if (i !== -1) {
                    this.fileRecordsForUpload.splice(i, 1);
                } else {
                    this.deleteUploadedFile(fileRecord);
                }
            },
            onUpload(e){
                console.log(e)
            },
            onUploadError(e){
                console.log(e)
            },




            deleteItem(row) {
                helper.deletingAlert("business will be deleted")
                .then((result) => {
                    if (result.value) {
                        this.isLoading = true;
                        this.deleteBusinessAction(row)
                        .then((res) => {
                            this.isLoading = false;
                            helper.successAlert("business deleted");
                        }).catch((error) => {
                            this.isLoading = false;
                            helper.errorMessage(error);
                        });
                    }
                });
            },

            fileModal(row={id: 1, name: 'emjay'}) {
                this.$refs.profiles.openAddModal();
            },

            galleryModal() {
                this.$refs.gallery.openAddModal('user', {id: 1, name: 'emjay'});
            },

            skillModal() {
                this.$refs.skill.openAddModal();
            },


            editModal(row) {
                this.$refs.profiles.openEditModal(row);
            }
        },
        created() {
            this.allUserProfileAction();
        },
        computed: {
            ...mapGetters(['getUserProfiles']),
        },

        mounted() {
        },
    }
</script>
<style scoped>
    @media (max-width: 767px) {
        .content-header{
            padding-top: 30px;
        }
    }
</style>
