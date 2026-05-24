<template>
    <div>
         <modal ref="woModal" modal-class-name="AddTicket" :modalClasses="'modal-md'">
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

                <form @submit.prevent="saveData" id="myForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>

                    <div class="mt-3">
                        <div class="row my-3" v-for="(field, index) in formData.details" :key="index">
                            <div class="row">
                                <custom-input
                                    :label="'Cost'"
                                    v-model="field.cost"
                                    type="text"
                                    :disabled="false"
                                    placeholder="Enter cost"
                                />

                            </div>
                            <div class="row">
                                <div class="col-11">
                                    <custom-input
                                        :label="'Description'"
                                        v-model="field.description"
                                        type="text"
                                        placeholder="Enter Description"
                                    />

                                </div>
                                <div class="col-1 mt-5">
                                    <a href="" title="Click to delete input fields" @click.prevent="removeField(index)">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </div>
                            </div>
                            <div v-if="field.id != 0" class="row">
                                <custom-input
                                    :label="'Code'"
                                    v-model="field.code"
                                    type="text"
                                    :disabled="true"
                                    placeholder="Enter Code"
                                />

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

export default {
    components: {
        Modal,
        CustomInput,
    },
    data() {
        return {
            saveLoading:false,
            addOrUpdate: false,

            formData: {
                id: 0,

                details: [
                    {   id: 0, 
                        description: "",
                        code: "",
                        cost: 0,
                    }
                ],

            },
        }
    },
    methods: {
        ...mapActions(['updateTicketAction', 'saveTicketAction', 'deleteTicketAction']),

        openAddModal(row) {
            this.formData.id= row.id;

            this.formData.details = [];
            if (row.tickets.length == 0) {
                this.formData.details= [
                    {
                        id: 0, 
                        description: '',
                        code: 0,
                        cost: 0,
                    }
                ];

                this.addOrUpdate = false;
            } else {
                row.tickets.forEach(item => this.formData.details.push({
                
                    id: item.id,
                    description: item.description,
                    code: item.code,
                    cost: item.cost,
                }));

                this.addOrUpdate = true;
            }

            
            helper.openModal(".AddTicket");
        },

        addMore() {
            this.formData.details.push({
                id: 0,
                description: "",
                code: "",
                cost: 0,
            });
        },

        removeField(index) {
            let row = this.formData.details[index];
            if (row.id != 0) {
                this.deleteItem(row, index);
            } else {
                this.formData.details.splice(index, 1);
            }
        },

        hideModal() {
            helper.hideModal(".AddTicket");
            // $(".AddTicket").modal('hide');
        },

        clearData(){
            this.formData.id = 0;

            this.formData.details= [
                {
                    id: 0,
                    description: "",
                    code: "",
                    cost: 0,
                }
            ];
        },

        deleteItem(row, index) {
            helper.deletingAlert("record will be deleted")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.deleteTicketAction(row)
                    .then((res) => {
                        this.formData.details.splice(index, 1);
                        this.isLoading = false;
                        helper.successAlert("record deleted");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
            });
        },

        saveData() {
            // this.saveLoading = true;
            if(this.addOrUpdate) {
                const data = this.formData;
                this.updateTicketAction(data).then((res) => {
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
                this.saveTicketAction(data).then((res) => {
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
