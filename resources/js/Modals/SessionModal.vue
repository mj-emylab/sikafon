<template>
    <div>
         <modal ref="woModal" modal-class-name="AddSession" :modalClasses="'modal-md'">
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
                        <div class="row mb-4" v-for="(field, index) in formData.details" :key="index">
                            <div class="row">
                                <label><b>Select Day</b></label>
                                <v-select
                                    :options="days"
                                    :label="'name'"
                                    :reduce="days => days.id"
                                    v-model="field.day"
                                    placeholder="Select Day"/>
                            </div>
                            <div class="row">
                                <custom-input
                                    :label="'Start'"
                                    v-model="field.start"
                                    type="text"
                                    placeholder="Enter Start"
                                />

                            </div>
                            <div class="row">
                                <custom-input
                                    :label="'End'"
                                    v-model="field.end"
                                    type="text"
                                    placeholder="Enter End"
                                />

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
                            <div class="row">
                                <div class="col-11">
                                    <custom-input
                                        :label="'Max'"
                                        v-model="field.max"
                                        type="number"
                                        placeholder="Enter Max"
                                    />

                                </div>
                                <div class="col-1 mt-5">
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
                <button class="btn btn-success btn-sm float-left mr-1" title="Show add details media input fields" @click.prevent="addMore()">
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

            days: [
                {id:1, name: 'Sunday'},
                {id:2, name: 'Monday'},
                {id:3, name: 'Tuesday'},
                {id:4, name: 'Wednessday'},
                {id:5, name: 'Thursday'},
                {id:6, name: 'Friday'},
                {id:7, name: 'Saturday'},
            ],


            formData: {
                id: 0,
                type: '',

                details: [
                    {
                        id: 0, 
                        start: '', 
                        end: '',
                        day: '',
                        max: 0,
                        code: 0,
                    }
                ],

            },
        }
    },
    methods: {
        ...mapActions(['updateSessionAction', 'saveSessionAction', 'deleteSessionAction']),

        openAddModal(row, type) {
            this.formData.id= row.id;
            this.formData.type= type;

            this.formData.details = [];
            if (row.sessions.length == 0) {
                this.formData.details= [
                    {
                        id: 0, 
                        start: '', 
                        end: '',
                        day: '',
                        max: 0,
                        code: 0,
                    }
                ];

                this.addOrUpdate = false;
            } else {
                row.sessions.forEach(item => this.formData.details.push({
                
                    id: item.id,
                    start: item.start_at, 
                    end: item.end_at,
                    day: item.day,
                    max: item.max,
                    code: item.code,
                }));

                this.addOrUpdate = true;
            }

            
            helper.openModal(".AddSession");
        },

        addMore() {
            this.formData.details.push({
                id: 0, 
                start: '', 
                end: '',
                day: '',
                max: 0,
                code: 0,
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

        openEditModal(row) {
            // this.formData.id= row.id;
            // this.formData.type= type;

            // this.formData.details = [];
            // if (row.session.length == 0) {
            //     this.formData.details= [
            //         {
            //             id: 0, 
            //             start: '', 
            //             end: '',
            //             day: '',
            //             max: 0,
            //             code: 0,
            //         }
            //     ];
            // } else {
            //     row.session.forEach(item => this.formData.details.push({
                
            //         id: item.id,
            //         start: item.start, 
            //         end: item.end,
            //         day: item.day,
            //         max: item.max,
            //         code: item.code,
            //     }));
            // }

            // this.addOrUpdate = true;
            // helper.openModal(".AddSession");
        },

        deleteItem(row, index) {
            helper.deletingAlert("record will be deleted")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.deleteSessionAction(row)
                    .then((res) => {
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

        hideModal() {
            helper.hideModal(".AddSession");
        },

        clearData(){
            this.formData.id = 0;
            this.type = '';
            this.formData.details= [
                {
                    id: 0, 
                    start: '', 
                    end: '',
                    day: '',
                    max: 0,
                    code: 0,
                }
            ];
        },

        saveData() {
            // this.saveLoading = true;
            if(this.addOrUpdate) {
                const data = this.formData;
                this.updateSessionAction(data).then((res) => {
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
                this.saveSessionAction(data).then((res) => {
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
