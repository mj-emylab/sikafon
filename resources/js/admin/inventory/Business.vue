<template>
  <!-- Content Wrapper. Contains page content -->
  <div>

    <section class="content-header">
      <h1>
        Businesses
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><router-link :to="'/index'"><i class="fa fa-dashboard"></i> Home</router-link>></li>
        <li class="active">Business</li>
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
                            <!-- <div class="add add-agent" v-if="can('system_create') || can('system_all')">
                                <button @click.prevent="showModal()" type="button" class="btn btn-lg btn-primary mb-2 float-end">
                                    <i class="fa fa-plus"></i>
                                    Add
                                </button>
                            </div> -->
                            <button style="float:right;" @click.prevent="showModal()" type="button" class="btn btn-danger mb-2 mt-2 float-right mr-1">
                                <i class="fa fa-plus"></i>
                                Add
                            </button>
                        </div>
                    
                    </ul>
                    <div class="tab-content">
                    
                        <wo-table
                            :total-records="getBusinesses ? getBusinesses.length : 0"
                            :remote="false"
                            :columns="columns"
                            :enable-check-box="false"
                            :rows="getBusinesses">
                            <template #view="{row}">
                                <router-link class="badge" style="text-color: white; background-color:#2E8B57" :to="{path:'/view-business',query:{id: row.id}}" >View</router-link>
                            </template>
                            <template #site="{row}">
                                <a target="_blank" :href="'https://areashoppers.co/my-website?id='+row.id" class="badge" style="text-color: white; background-color:#8B0000" >My Free Website</a>
                            </template>
                            <template #status="{row}">
                                <span style="text-color: white; background-color:#FF0000" class="badge badge-danger" @click.prevent="editStatus(row)" v-if="row.status == 0">
                                    Not Verified
                                </span>
                                <span style="text-color: white; background-color:#2E8B57" class="badge badge-success" @click.prevent="editStatus(row)" v-if="row.status == 1">
                                    Level 1
                                </span>
                                <span style="text-color: white; background-color:#8B0000" class="badge badge-info" @click.prevent="editStatus(row)" v-if="row.status == 2">
                                    Level 2
                                </span>
                                <span style="text-color: white; background-color:#2E8B57" class="badge badge-success" @click.prevent="editStatus(row)" v-if="row.status == 3">
                                    Level 3
                                </span>
                                <span style="text-color: white; background-color:#8B0000" class="badge badge-info" @click.prevent="editStatus(row)" v-if="row.status == 4">
                                    Pending
                                </span>
                                <span style="text-color: white; background-color:#FF0000" class="badge badge-danger" @click.prevent="editStatus(row)" v-if="row.status == 5">
                                    Declined
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
                                            <i class="fa fa-pencil text-green"></i> Edit
                                        </a>
                                        <a  @click.prevent="galleryModal(row)" class="dropdown-item"  title="Gallery" href="#">
                                            <i class="fa fa-pencil text-blue"></i> Gallery
                                        </a>
                                        <a  @click.prevent="" class="dropdown-item"  title="Shoppers page" href="#">
                                            <i class="fa fa-pencil text-yellow"></i> Shoppers
                                        </a>
                                        <a  @click.prevent="verificationModal(row)" class="dropdown-item"  title="verification" href="#">
                                            <i class="fa fa-pencil text-pink"></i> Verification
                                        </a>
                                        <a @click.prevent="deleteItem(row)" class="dropdown-item" title="Delete" href="#">
                                            <i class="fa fa-trash text-red"></i> Delete
                                        </a>
                                    </div>
                                </div>
                                <!-- <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
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
                                </div> -->
                            </template>
                        </wo-table>
                    </div>
                        
                        
                </div>
            </div>
        </div>

    </section>

    <business-modal ref="business" />

    <gallery-modal ref="gallery" />
    <session-modal ref="session" />
    <verification-modal ref="verification" />

  </div>
</template>

<script>

    import WoTable from "../../components/WoTable.vue";
    import helper from '../../helpers/helpers.js';
    import BusinessModal from '../../Modals/BusinessModal.vue';

    import GalleryModal from '../../Modals/GalleryModal.vue';
    import SessionModal from '../../Modals/SessionModal.vue';
    import VerificationModal from '../../Modals/VerificationModal.vue';

    import { createNamespacedHelpers } from 'vuex';
    const { mapActions, mapGetters } = createNamespacedHelpers('system');

    export default {
            components: { WoTable, BusinessModal, GalleryModal, SessionModal, VerificationModal },

            data() {
                return {
                isLoading: false,
                columns: [
                    { label: 'Name', field: 'name'},
                    { label: 'Findme ID', field: 'business_code'},
                    { label: 'Phone', field: 'phone'},
                    { label: 'Free Site', field: 'site'},
                    { label: 'View', field: 'view'},
                    { label: 'Status', field: 'status'},
                    { label: 'Created Date', field: 'created_at'},
                    { label: 'Actions', field: 'actions', sortable: false, thClass: 'text-center', tdClass: 'text-center'}
                ],
            }
        },
        methods: {
        ...mapActions(['allBusinessAction', 'deleteBusinessAction', 'updateBusinessAction']),

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

            editStatus(row) {
                // helper.deletingAlert("Business validation status will be change")
                // .then((result) => {
                //     if (result.value) {
                //         this.isLoading = true;
                //         this.statusProjectAction(row)
                //         .then(() => {
                //             this.isLoading = false;
                //             helper.successAlert("Project status changed");
                //         }).catch((error) => {
                //             this.isLoading = false;
                //             helper.errorMessage(error);
                //         });
                //     }
                // });
            },

            showModal() {
                this.$refs.business.openAddModal();
            },

            editModal(row) {
                this.$refs.business.openEditModal(row);
            },

            galleryModal(row) {
                this.$refs.gallery.openAddModal('business', row);
                this.allBusinessAction();
            },
            sessionModal() {
                this.$refs.session.openAddModal();
                this.allBusinessAction();
            },

            verificationModal(row) {
                this.$refs.verification.openAddModal(row, 'business');
                this.allBusinessAction();
            },
        },
        created() {
            // if (this.can('system_view') || this.can('system_all')) {
            //     this.allBusNameAction({});
            // }
            this.allBusinessAction();
        },
        computed: {
            ...mapGetters(['getBusinesses']),
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
