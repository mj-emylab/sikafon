<template>
  <!-- Content Wrapper. Contains page content -->
  <div>

    <section class="content-header">
      <h1>
        Job
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

                        <div style="margin-left:10px; margin-bottom:5px; height: 50px;">
                            <span>
                                <loading
                                    :active="isLoading"
                                    :is-full-page="false"
                                    loader="bars"
                                    :width="25"
                                    :height="25"
                                ></loading>
                            </span>
                        </div>
                    
                    </ul>
                    <div class="tab-content">
                    
                        <wo-table
                            :total-records="getJob ? getJob.length : 0"
                            :remote="false"
                            :columns="columns"
                            :enable-check-box="false"
                            :rows="getJob">
                            <template #name="{row}">
                                {{ row.user.first_name }} {{ row.user.last_name }}
                            </template>
                            <template #findme="{row}">
                                {{ row.user.findme_id }}
                            </template>
                            <template #phone="{row}">
                                {{ row.user.phone }}
                            </template>
                            <template #status="{row}">
                                <span style="text-color: white; background-color:#FF0000;" class="badge badge-success" @click.prevent="editStatus(row)" v-if="row.status == 0">
                                    Active
                                </span>
                                <span style="text-color: white; background-color:#2E8B57;" class="badge badge-info" @click.prevent="editModal(row)" v-else>
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
                                        <!-- <a @click.prevent="download(row.profile.id)" class="dropdown-item"  title="Download" href="#">
                                            <i class="fa fa-pencil text-success"></i> Download
                                        </a> -->
                                        <a @click.prevent="viewModal(row)" class="dropdown-item"  title="Download" href="#">
                                            <i class="fa fa-eye text-success"></i> View Application
                                        </a>
                                        <a @click.prevent="replyModal(row)" class="dropdown-item"  title="Reply" href="#">
                                            <i class="fa fa-comment text-success"></i> Reply
                                        </a>
                                        <!-- <a @click.prevent="deleteItem(row)" class="dropdown-item" title="Delete" href="#">
                                            <i class="fa fa-trash text-danger"></i> Delete
                                        </a> -->
                                    </div>
                                </div>
                            </template>
                        </wo-table>
                    </div>
                        
                        
                </div>
            </div>
        </div>

    </section>


    <reply-modal ref="reply" />
    <job-view-modal ref="job_view" />

  </div>
</template>

<script>

    import WoTable from "../../components/WoTable.vue";
    import helper from '../../helpers/helpers.js';
    import ReplyModal from '../../Modals/ReplyModal.vue';
    import JobViewModal from '../../Modals/JobViewModal.vue';

    import { createNamespacedHelpers } from 'vuex';
    const { mapActions, mapGetters } = createNamespacedHelpers('single');

    export default {
            components: { WoTable, ReplyModal, JobViewModal },

            data() {
                return {
                isLoading: false,
                columns: [
                    { label: 'Name', field: 'name'},
                    { label: 'Findme ID', field: 'findme'},
                    { label: 'Phone', field: 'phone'},
                    { label: 'Status', field: 'status'},
                    { label: 'Created Date', field: 'created_at'},
                    { label: 'Actions', field: 'actions', sortable: false, thClass: 'text-center', tdClass: 'text-center'}
                ],

                formData: {
                    id: this.$route.query.id,
                    type: 'job',
                    msg: '',
                },
                pageData:[],
            }
        },
        methods: {
        ...mapActions(['jobAction']),

            replyModal(row) {
                this.$refs.reply.openAddModal(row, 'job');
            },
            viewModal(row) {
                this.$refs.job_view.openAddModal(row);
            },
        },
        created() {

            this.jobAction(this.formData).then((res) => {
                this.pageData = this.getJob

            }).catch((error) => {

                // this.$router.push({ path: "/404" });
                
                helper.errorMessage(error);
            });
        },
        computed: {
            ...mapGetters(['getJob']),
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
