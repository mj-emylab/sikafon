import Resource from '../../service/resources';
import { METHODS } from '../../service/const';

// route registration
const BusinessRoute = new Resource('businesses');
const EventRoute = new Resource('events');
const ServiceRoute = new Resource('services');
const JobRoute = new Resource('jobs');
const ProfessionalRoute = new Resource('professionals');

const UserNameRoute = new Resource('users/user_name');
const GalleryRoute = new Resource('files');
// const FileRoute = new Resource('my_files');

export const system = {
    namespaced: true,
    state: () => ({
        businesses: [],
        events: [],
        services: [],
        jobs: [],
        professionals: [],

        userName: {},
        gallery: [],
        file: [],

    }),
    mutations: {
        //set username state
        setUserNameState(state, data) {
            state.userName = data;
        },

        // set gallery
        setGalleryState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.gallery = data;
            } else if (status === METHODS._StoreMethod) {
                state.gallery = [data, ...state.gallery];
            } else if (status === METHODS._PutMethod) {
                state.gallery = state.gallery.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.gallery = state.gallery.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set gallery
        // setFileState(state, { data, status }) {
        //     if (status === METHODS._ListMethod) {
        //         state.file = data;
        //     } else if (status === METHODS._StoreMethod) {
        //         state.file = [data, ...state.file];
        //     } else if (status === METHODS._PutMethod) {
        //         state.file = state.file.map(item => {
        //             if (item.id === data.id) {
        //                 return data;
        //             }
        //             return item;
        //         });
        //     } else if (status === METHODS._DeleteMethod) {
        //         state.file = state.file.filter((item) => item.id !== data.id);
        //     }
        // },
        // end

        // set a Business
        setBusinessState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.businesses = data;
            } else if (status === METHODS._StoreMethod) {
                state.businesses = [data, ...state.businesses];
            } else if (status === METHODS._PutMethod) {
                state.businesses = state.businesses.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.businesses = state.businesses.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set a Event
        setEventState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.events = data;
            } else if (status === METHODS._StoreMethod) {
                state.events = [data, ...state.events];
            } else if (status === METHODS._PutMethod) {
                state.events = state.events.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.events = state.events.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set a Service
        setServiceState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.services = data;
            } else if (status === METHODS._StoreMethod) {
                state.services = [data, ...state.services];
            } else if (status === METHODS._PutMethod) {
                state.services = state.services.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.services = state.services.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set a Job
        setJobState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.jobs = data;
            } else if (status === METHODS._StoreMethod) {
                state.jobs = [data, ...state.jobs];
            } else if (status === METHODS._PutMethod) {
                state.jobs = state.jobs.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.jobs = state.jobs.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set a Professional
        setProfessionalState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.professionals = data;
            } else if (status === METHODS._StoreMethod) {
                state.professionals = [data, ...state.professionals];
            } else if (status === METHODS._PutMethod) {
                state.professionals = state.professionals.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.professionals = state.professionals.filter((item) => item.id !== data.id);
            }
        },
        // end


    },
    actions: {

        //user name action
        userNameAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                UserNameRoute.store(data).then((res) => {
                    commit('setUserNameState', res.data.data);
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },

        // get all gallery
        allGalleryAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                GalleryRoute.list({}).then((res) => {
                    commit('setGalleryState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveGalleryAction({ state, commit }, data) {
            let formdata = new FormData();

            formdata.append("type", data.type);
            formdata.append("type_id", data.id);

            data.fileRecordsForUpload.forEach(element => {
                formdata.append('files[]', element);
            });

            return new Promise((resolve, reject) => {
                new Resource('save_gallery').store(formdata).then((res) => {
                    commit('setGalleryState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },

        updateGalleryAction({ state, commit }, data) {

            let formdata = new FormData();

            formdata.append("fileable_type", data.fileable_type);
            formdata.append("type", data.type);
            formdata.append("fileable_id", data.fileable_id);

            data.files.forEach(element => {
                formdata.append('files[]', element);
            });

            return new Promise((resolve, reject) => {
                new Resource('gallery/update').updateFormData(formdata, data.id).then((res) => {
                    // commit('setGalleryState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteGalleryAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                GalleryRoute.destroy(data.id).then((res) => {
                    commit('setGalleryState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end of gallery

        // get all file
        allFileAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                FileRoute.list({}).then((res) => {
                    commit('setFileState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveFileAction({ state, commit }, data) {
            let formdata = new FormData();

            data.fileRecordsForUpload.forEach(element => {
                formdata.append('files[]', element.file);
            });

            return new Promise((resolve, reject) => {
                GalleryRoute.store(formdata).then((res) => {
                    commit('setFileState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateFileAction({ state, commit }, data) {

            let formdata = new FormData();

            formdata.append("model", data.model);
            formdata.append("type", data.type);
            formdata.append("model_id", data.model_id);

            data.files.forEach(element => {
                formdata.append('files[]', element);
            });

            return new Promise((resolve, reject) => {
                new Resource('file/update').updateFormData(formdata, data.id).then((res) => {
                    commit('setFileState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteFileAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                GalleryRoute.destroy(data.id).then((res) => {
                    commit('setFileState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end of file

        // get all businesses
        allBusinessAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                BusinessRoute.list({}).then((res) => {
                    commit('setBusinessState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveBusinessAction({ state, commit }, data) {
            let formdata = new FormData();

            formdata.append("name", data.name);
            formdata.append("country", data.country);
            formdata.append("email", data.email);
            formdata.append("phone", data.phone);
            formdata.append("store", data.store);
            formdata.append("agent", data.agent);
            formdata.append("country_code", data.country_code);
            formdata.append("dial_code", data.dial_code);
            // formdata.append("business_code", data.business_code);
            formdata.append("business_code", data.genId);
            formdata.append("address", data.address);
            formdata.append("description", data.description);
            formdata.append("lat", data.lat);
            formdata.append("long", data.long);
            formdata.append("category_id", data.category_id);

            formdata.append("image", data.image);

            formdata.append("social", JSON.stringify(data.social));

            // data.files.forEach(element => {
            //     formdata.append('files[]', element);
            // });

            return new Promise((resolve, reject) => {
                BusinessRoute.store(formdata).then((res) => {
                    commit('setBusinessState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateBusinessAction({ state, commit }, data) {

            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("name", data.name);
            // formdata.append("store", data.store);
            // formdata.append("agent", data.agent);
            formdata.append("country", data.country);
            formdata.append("email", data.email);
            formdata.append("phone", data.phone);
            formdata.append("country_code", data.country_code);
            formdata.append("business_code", data.business_code);
            formdata.append("dial_code", data.dial_code);
            formdata.append("address", data.address);
            formdata.append("description", data.description);
            formdata.append("lat", data.lat);
            formdata.append("long", data.long);
            formdata.append("category_id", data.category_id);

            if (data.image == null || data.image == undefined || data.image == '' || data.image == "") {
                formdata.append("image", "None");
            } else {
                formdata.append("image", data.image);
            }

            formdata.append("social", JSON.stringify(data.social));

            // data.files.forEach(element => {
            //     formdata.append('files[]', element);
            // });

            return new Promise((resolve, reject) => {
                new Resource('businesses/update').updateFormData(formdata, data.id).then((res) => {
                    commit('setBusinessState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteBusinessAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                BusinessRoute.destroy(data.id).then((res) => {
                    commit('setBusinessState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end of Business

        // get all event
        allEventAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                EventRoute.list({}).then((res) => {
                    commit('setEventState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveEventAction({ state, commit }, data) {
            let formdata = new FormData();

            formdata.append("event_name", data.event_name);
            formdata.append("location", data.location);
            formdata.append("deadline", data.deadline);
            formdata.append("event_date", data.event_date);
            // formdata.append("event_code", data.event_code);
            formdata.append("event_code", data.genId);
            formdata.append("slots", data.slots);
            formdata.append("type", data.type);
            formdata.append("event_description", data.event_description);
            formdata.append("lat", data.lat);
            formdata.append("long", data.long);
            formdata.append("event_cat_id", data.event_cat_id);
            formdata.append("image", data.image);

            formdata.append("social", JSON.stringify(data.social));

            // data.files.forEach(element => {
            //     formdata.append('files[]', element);
            // });

            return new Promise((resolve, reject) => {
                EventRoute.store(formdata).then((res) => {
                    commit('setEventState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateEventAction({ state, commit }, data) {

            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("event_name", data.event_name);
            formdata.append("location", data.location);
            formdata.append("deadline", data.deadline);
            formdata.append("event_date", data.event_date);
            formdata.append("slots", data.slots);
            formdata.append("event_code", data.event_code);
            // formdata.append("event_code", data.genId);
            formdata.append("type", data.type);
            formdata.append("event_description", data.event_description);
            formdata.append("lat", data.lat);
            formdata.append("long", data.long);
            formdata.append("event_cat_id", data.event_cat_id);

            if (data.image == null || data.image == undefined || data.image == '' || data.image == "") {
                formdata.append("image", "None");
            } else {
                formdata.append("image", data.image);
            }

            formdata.append("social", JSON.stringify(data.social));

            // data.files.forEach(element => {
            //     formdata.append('files[]', element);
            // });

            return new Promise((resolve, reject) => {
                new Resource('events/update').updateFormData(formdata, data.id).then((res) => {
                    commit('setEventState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteEventAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                EventRoute.destroy(data.id).then((res) => {
                    commit('setEventState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end of event

        // get all service
        allServiceAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                ServiceRoute.list({}).then((res) => {
                    commit('setServiceState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveServiceAction({ state, commit }, data) {
            let formdata = new FormData();

            formdata.append("service_name", data.service_name);
            formdata.append("service_location", data.service_location);
            formdata.append("price", data.price);
            // formdata.append("service_code", data.service_code);
            formdata.append("service_code", data.genId);
            formdata.append("description", data.service_description);
            formdata.append("service_cat_id", data.service_cat_id);
            formdata.append("lat", data.lat);
            formdata.append("long", data.long);

            formdata.append("image", data.image);

            formdata.append("social", JSON.stringify(data.social));

            // data.files.forEach(element => {
            //     formdata.append('files[]', element);
            // });

            return new Promise((resolve, reject) => {
                ServiceRoute.store(formdata).then((res) => {
                    commit('setServiceState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateServiceAction({ state, commit }, data) {

            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("service_name", data.service_name);
            formdata.append("service_location", data.service_location);
            formdata.append("price", data.price);
            formdata.append("service_code", data.service_code);
            // formdata.append("service_code", data.genId);
            formdata.append("description", data.service_description);
            formdata.append("service_cat_id", data.service_cat_id);
            formdata.append("lat", data.lat);
            formdata.append("long", data.long);

            if (data.image == null || data.image == undefined || data.image == '' || data.image == "") {
                formdata.append("image", "None");
            } else {
                formdata.append("image", data.image);
            }

            formdata.append("social", JSON.stringify(data.social));

            // data.files.forEach(element => {
            //     formdata.append('files[]', element);
            // });

            return new Promise((resolve, reject) => {
                new Resource('services/update').updateFormData(formdata, data.id).then((res) => {
                    commit('setServiceState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteServiceAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                ServiceRoute.destroy(data.id).then((res) => {
                    commit('setServiceState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end of service

        // get all job
        allJobAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                JobRoute.list({}).then((res) => {
                    commit('setJobState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveJobAction({ state, commit }, data) {
            let formdata = new FormData();

            formdata.append("job_name", data.job_name);
            formdata.append("job_location", data.job_location);
            formdata.append("amount", data.amount);
            formdata.append("slots", data.slots);
            // formdata.append("job_code", data.job_code);
            formdata.append("job_code", data.genId);
            formdata.append("type_one_id", data.type_one_id);
            formdata.append("type_two_id", data.type_two_id);
            formdata.append("deadline", data.deadline);
            formdata.append("job_description", data.job_description);
            formdata.append("lat", data.lat);
            formdata.append("long", data.long);
            formdata.append("job_cat_id", data.job_cat_id);
            formdata.append("image", data.image);

            formdata.append("social", JSON.stringify(data.social));

            // data.files.forEach(element => {
            //     formdata.append('files[]', element);
            // });

            return new Promise((resolve, reject) => {
                JobRoute.store(formdata).then((res) => {
                    commit('setJobState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateJobAction({ state, commit }, data) {

            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("job_name", data.job_name);
            formdata.append("job_location", data.job_location);
            formdata.append("amount", data.amount);
            formdata.append("slots", data.slots);
            formdata.append("job_code", data.job_code);
            // formdata.append("job_code", data.genId);
            formdata.append("type_one_id", data.type_one_id);
            formdata.append("type_two_id", data.type_two_id);
            formdata.append("deadline", data.deadline);
            formdata.append("job_description", data.job_description);
            formdata.append("lat", data.lat);
            formdata.append("long", data.long);
            formdata.append("job_cat_id", data.job_cat_id);

            if (data.image == null || data.image == undefined || data.image == '' || data.image == "") {
                formdata.append("image", "None");
            } else {
                formdata.append("image", data.image);
            }

            formdata.append("social", JSON.stringify(data.social));

            // data.files.forEach(element => {
            //     formdata.append('files[]', element);
            // });

            return new Promise((resolve, reject) => {
                new Resource('jobs/update').updateFormData(formdata, data.id).then((res) => {
                    commit('setJobState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteJobAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                JobRoute.destroy(data.id).then((res) => {
                    commit('setJobState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end of job

        // get all professionals
        allProfessionalAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                ProfessionalRoute.list({}).then((res) => {
                    commit('setProfessionalState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveProfessionalAction({ state, commit }, data) {
            let formdata = new FormData();

            formdata.append("pro_title", data.pro_title);
            formdata.append("pro_location", data.pro_location);
            formdata.append("pro_description", data.pro_description);
            // formdata.append("professional_code", data.professional_code);
            formdata.append("professional_code", data.genId);
            formdata.append("lat", data.lat);
            formdata.append("long", data.long);
            formdata.append("pro_cat_id", data.pro_cat_id);
            formdata.append("image", data.image);

            formdata.append("social", JSON.stringify(data.social));

            // data.files.forEach(element => {
            //     formdata.append('files[]', element);
            // });

            return new Promise((resolve, reject) => {
                ProfessionalRoute.store(formdata).then((res) => {
                    commit('setProfessionalState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateProfessionalAction({ state, commit }, data) {

            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("pro_title", data.pro_title);
            formdata.append("pro_location", data.pro_location);
            formdata.append("pro_description", data.pro_description);
            formdata.append("professional_code", data.professional_code);
            // formdata.append("professional_code", data.genId);
            formdata.append("lat", data.lat);
            formdata.append("long", data.long);
            formdata.append("pro_cat_id", data.pro_cat_id);

            if (data.image == null || data.image == undefined || data.image == '' || data.image == "") {
                formdata.append("image", "None");
            } else {
                formdata.append("image", data.image);
            }

            formdata.append("social", JSON.stringify(data.social));

            // data.files.forEach(element => {
            //     formdata.append('files[]', element);
            // });

            return new Promise((resolve, reject) => {
                new Resource('professionals/update').updateFormData(formdata, data.id).then((res) => {
                    commit('setProfessionalState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteProfessionalAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                ProfessionalRoute.destroy(data.id).then((res) => {
                    commit('setProfessionalState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end of professionals

    },
    getters: {
        //user name getter
        getUserName(state) {
            return state.userName;
        },

        // return all gallery
        getGallery(state) {
            return state.gallery;
        },

        // return all file
        getFile(state) {
            return state.file;
        },

        // return all businesses
        getBusinesses(state) {
            return state.businesses;
        },

        // return all events
        getEvents(state) {
            return state.events;
        },

        // return all services
        getServices(state) {
            return state.services;
        },

        // return all jobs
        getJobs(state) {
            return state.jobs;
        },

        // return all professionals
        getProfessionals(state) {
            return state.professionals;
        },
    }
};


// <===========================> not in use all to inventory <===========================>   //