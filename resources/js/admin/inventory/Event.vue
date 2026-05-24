<template>
  <!-- Content Wrapper. Contains page content -->
  <div>

    <section class="content-header">
      <h1>
        Events
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><router-link :to="'/index'"><i class="fa fa-dashboard"></i> Home</router-link>></li>
        <li class="active">Event</li>
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
                            :total-records="getEvents ? getEvents.length : 0"
                            :remote="false"
                            :columns="columns"
                            :enable-check-box="false"
                            :rows="getEvents">
                            <template #view="{row}">
                                <router-link class="badge" style="text-color: white; background-color:#2E8B57" :to="{path:'/view-event',query:{id: row.id}}" >View</router-link>
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
                                            <i class="fa fa-pencil text-success"></i> Session
                                        </a> -->
                                        <a  @click.prevent="ticketModal(row)" class="dropdown-item"  title="Ticket" href="#">
                                            <i class="fa fa-pencil text-brown"></i> Ticket
                                        </a>
                                        <a  @click.prevent="viewModal(row)" class="dropdown-item"  title="Ticket" href="#">
                                            <i class="fa fa-pencil text-yellow"></i> View
                                        </a>
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

    <event-modal ref="event" />

    <gallery-modal ref="gallery" />
    <ticket-modal ref="ticket" />

    <view-modal ref="view" />

  </div>
</template>

<script>

    import WoTable from "../../components/WoTable.vue";
    import helper from '../../helpers/helpers.js';
    import EventModal from '../../Modals/EventModal.vue';

    import GalleryModal from '../../Modals/GalleryModal.vue';
    import TicketModal from '../../Modals/EventTicketModal.vue';
    import ViewModal from '../../Modals/ViewModal.vue';

    import { createNamespacedHelpers } from 'vuex';
    const { mapActions, mapGetters } = createNamespacedHelpers('system');

    export default {
            components: { WoTable, EventModal, GalleryModal, TicketModal, ViewModal },

            data() {
                return {
                isLoading: false,
                columns: [
                    { label: 'Name', field: 'event_name'},
                    { label: 'Findme ID', field: 'event_code'},
                    { label: 'View', field: 'view'},
                    { label: 'Status', field: 'status'},
                    { label: 'Created Date', field: 'created_at'},
                    { label: 'Actions', field: 'actions', sortable: false, thClass: 'text-center', tdClass: 'text-center'}
                ],
            }
        },
        methods: {
        ...mapActions(['allEventAction', 'deleteEventAction', 'updateEventAction']),

            deleteItem(row) {
                helper.deletingAlert("event will be deleted")
                .then((result) => {
                    if (result.value) {
                        this.isLoading = true;
                        this.deleteEventAction(row)
                        .then((res) => {
                            this.isLoading = false;
                            helper.successAlert("event deleted");
                        }).catch((error) => {
                            this.isLoading = false;
                            helper.errorMessage(error);
                        });
                    }
                });
            },

            showModal() {
                this.$refs.event.openAddModal();
            },

            editModal(row) {
                this.$refs.event.openEditModal(row);
            },

            galleryModal(row) {
                this.$refs.gallery.openAddModal('event', row);
                this.allEventAction();
            },
            ticketModal(row) {
                this.$refs.ticket.openAddModal(row);
                this.allEventAction();
            },

            viewModal(row) {
                this.$refs.view.openModal(row, 'ticket');
            },
        },
        created() {
            this.allEventAction();
        },
        computed: {
            ...mapGetters(['getEvents']),
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
