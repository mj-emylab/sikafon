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
                                <span style="text-color: white; background-color:#2E8B57" class="badge badge-success" @click.prevent="editModal(row)" v-if="row.status == 0">
                                    Active
                                </span>
                                <span style="text-color: white; background-color:#8B0000" class="badge badge-info" @click.prevent="editModal(row)" v-else>
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
                                        <a  @click.prevent="editFileModal(row)" class="dropdown-item"  title="Edit" href="#">
                                            <i class="fa fa-pencil text-success"></i> Edit
                                        </a>
                                        <a  @click.prevent="download(row)" class="dropdown-item"  title="Edit" href="#">
                                            <i class="fa fa-download text-success"></i> Download
                                        </a>
                                        <a @click.prevent="deleteItem(row)" class="dropdown-item" title="Delete" href="#">
                                            <i class="fa fa-trash text-danger"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </template>
                        </wo-table>
                    </div>     
                        
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

    const axios = require('axios').default;

    import { createNamespacedHelpers } from 'vuex';
    const { mapActions, mapGetters } = createNamespacedHelpers('administration');

    export default {
            components: { WoTable, ProfileModal, SkillModal, GalleryModal },

            data() {
                return {
                isLoading: false,
                token: "",
                columns: [
                    { label: 'Name', field: 'name'},
                    { label: 'User', field: 'user.first_name'},
                    { label: 'Description', field: 'description'},
                    { label: 'Status', field: 'status'},
                    { label: 'Created Date', field: 'created_at'},
                    { label: 'Actions', field: 'actions', sortable: false, thClass: 'text-center', tdClass: 'text-center'}
                ],
            }
        },
        methods: {
        ...mapActions(['allUserProfileAction', 'deleteUserProfileAction', 'updateUserProfileAction', 'allUserGalleryAction', 'downloadUserProfileAction']),

            deleteItem(row) {
                helper.deletingAlert("record will be deleted")
                .then((result) => {
                    if (result.value) {
                        this.isLoading = true;
                        this.deleteUserProfileAction(row)
                        .then((res) => {
                            this.isLoading = false;
                            helper.successAlert("record deleted");
                        }).catch((error) => {
                            this.isLoading = false;
                            helper.errorMessage(error);
                        });
                    }
                });
            },

            download(row) {
                this.isLoading = true;
                if (this.token == null || this.token == undefined || this.token == '' || this.token == "") {
                    this.isLoading = false;
                    helper.errorAlert("Soryy cannot download this file");
                } else {
                    axios({
                        url: 'http://127.0.0.1:8000/api/user_profiles/download/'+row.id,
                        method: 'GET',
                        responseType: 'blob',
                        headers: {"Authorization" : `Bearer ${this.token}`}
                    }).then((response) => {
                        // console.log(response.data.type)
                        this.isLoading = false;
                        var fileURL = window.URL.createObjectURL(new Blob([response.data], {type: response.data.type}));
                        var fileLink = document.createElement('a');

                        fileLink.href = fileURL;
                        fileLink.setAttribute('download', '');
                        document.body.appendChild(fileLink);

                        fileLink.click();
                    });
                    this.isLoading = false;
                }
                
            },

            fileModal() {
                this.$refs.profiles.openAddModal();
            },

            editFileModal(row) {
                this.$refs.profiles.openEditModal(row);
            },

            galleryModal() {
                this.$refs.gallery.openAddModal('user', this.getUserGallery);
            },

            skillModal() {
                this.$refs.skill.openAddModal();
            },


            editModal(row) {
                // this.$refs.profiles.openEditModal(row);
            }
        },
        created() {
            this.token = JSON.parse(localStorage.getItem('findMe')).auth.token;
            this.allUserProfileAction();
            this.allUserGalleryAction();
        },
        computed: {
            ...mapGetters(['getUserProfiles', 'getUserGallery']),
        },

        mounted() {
        },
    }
</script>
<style scoped>
    @media (max-width: 767px) {
        .content-header{
            padding-top: 10%;
        }
    }
</style>
