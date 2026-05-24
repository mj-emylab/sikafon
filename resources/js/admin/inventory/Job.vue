<template>
  <!-- Content Wrapper. Contains page content -->
  <div>

    <section class="content-header">
      <h1>
        Jobs
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><router-link :to="'/index'"><i class="fa fa-dashboard"></i> Home</router-link>></li>
        <li class="active">Job</li>
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
                            <button style="float:right;" @click.prevent="showModal()" type="button" class="btn btn-danger mb-2 mt-2 float-right mr-1">
                                <i class="fa fa-plus"></i>
                                Add
                            </button>
                        </div>
                    
                    </ul>
                    <div class="tab-content">
                    
                        <wo-table
                            :total-records="getJobs ? getJobs.length : 0"
                            :remote="false"
                            :columns="columns"
                            :enable-check-box="false"
                            :rows="getJobs">
                            <template #view="{row}">
                                <router-link class="badge" style="text-color: white; background-color:#2E8B57" :to="{path:'/view-job',query:{id: row.id}}" >View</router-link>
                            </template>
                            <template #status="{row}">
                                <span style="text-color: white; background-color:#FF0000" class="badge badge-danger" v-if="row.status == 0">
                                    Not Verified
                                </span>
                                <span style="text-color: white; background-color:#2E8B57" class="badge badge-success" v-if="row.status == 1">
                                    Level 1
                                </span>
                                <span style="text-color: white; background-color:#8B0000" class="badge badge-info" v-if="row.status == 2">
                                    Level 2
                                </span>
                                <span style="text-color: white; background-color:#2E8B57" class="badge badge-success" v-if="row.status == 3">
                                    Level 3
                                </span>
                                <span style="text-color: white; background-color:#8B0000" class="badge badge-info" v-if="row.status == 4">
                                    Pending
                                </span>
                                <span style="text-color: white; background-color:#FF0000" class="badge badge-danger" v-if="row.status == 5">
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
                                        <!-- <a  @click.prevent="sessionModal(row)" class="dropdown-item"  title="Session" href="#">
                                            <i class="fa fa-pencil text-brown"></i> Session
                                        </a> -->
                                        <a @click.prevent="deleteItem(row)" class="dropdown-item" title="Delete" href="#">
                                            <i class="fa fa-trash text-red"></i> Delete
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

    <job-modal ref="job" />

    <gallery-modal ref="gallery" />
    <session-modal ref="session" />

  </div>
</template>

<script>

    import WoTable from "../../components/WoTable.vue";
    import helper from '../../helpers/helpers.js';
    import JobModal from '../../Modals/JobModal.vue';

    import GalleryModal from '../../Modals/GalleryModal.vue';
    import SessionModal from '../../Modals/SessionModal.vue';

    import { createNamespacedHelpers } from 'vuex';
    const { mapActions, mapGetters } = createNamespacedHelpers('system');

    export default {
            components: { WoTable, JobModal, GalleryModal, SessionModal },

            data() {
                return {
                isLoading: false,
                columns: [
                    { label: 'Name', field: 'job_name'},
                    { label: 'Findme ID', field: 'job_code'},
                    { label: 'View', field: 'view'},
                    { label: 'Status', field: 'status'},
                    { label: 'Created Date', field: 'created_at'},
                    { label: 'Actions', field: 'actions', sortable: false, thClass: 'text-center', tdClass: 'text-center'}
                ],
            }
        },
        methods: {
        ...mapActions(['allJobAction', 'deleteJobAction', 'updateJobAction']),

            deleteItem(row) {
                helper.deletingAlert("job will be deleted")
                .then((result) => {
                    if (result.value) {
                        this.isLoading = true;
                        this.deleteJobAction(row)
                        .then((res) => {
                            this.isLoading = false;
                            helper.successAlert("job deleted");
                        }).catch((error) => {
                            this.isLoading = false;
                            helper.errorMessage(error);
                        });
                    }
                });
            },

            showModal() {
                this.$refs.job.openAddModal();
            },

            editModal(row) {
                this.$refs.job.openEditModal(row);
            },

            galleryModal(row) {
                this.$refs.gallery.openAddModal('job', row);
                this.allJobAction();
            },
            sessionModal() {
                this.$refs.session.openAddModal();
                this.allJobAction();
            },
        },
        created() {
            this.allJobAction();
        },
        computed: {
            ...mapGetters(['getJobs']),
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
