import Resource from '../../service/resources';
import { METHODS } from '../../service/const';



const DistrictRoute = new Resource('districts');


export const inventory = {
    namespaced: true,
    state: () => ({
        //home page
        businesses: [],
        events: [],
        jobs: [],
        services: [],
        professionals: [],

        //paginated
        paginateBusinesses: [],
        paginateEvents: [],
        paginateJobs: [],
        paginateServices: [],
        paginateProfessionals: [],

        //single pages
        singleBusinesses: {},
        singleEvents: {},
        singleProfessionals: {},
        singleJobs: {},
        singleServices: {},

        //sub pages
        subBusinesses: [],
        subEvents: [],
        subJobs: [],
        subServices: [],
        subProfessionals: [],

        //similar pages
        similarBusinesses: {},
        similarEvents: {},
        similarProfessionals: {},
        similarJobs: {},
        similarServices: {},

        //upcoming pages
        upcomingEvents: {},

    }),

    mutations: {

        // business
        setBusinessState(state, { data, status }) {
            state.businesses = data;

        },
        //end business

        // events
        setEventState(state, { data, status }) {
            state.events = data;

        },
        //end events

        // service
        setServiceState(state, { data, status }) {
            state.services = data;

        },
        //end service

        // Jobs
        setJobState(state, { data, status }) {
            state.jobs = data;

        },
        //end Jobs

        // professionals
        setProfessionalState(state, { data, status }) {
            state.professionals = data;

        },
        //end professionals




        //paginated
        // business
        setPaginateBusinessState(state, { data, status }) {
            state.paginateBusinesses = data;

        },
        //end business

        // events
        setPaginateEventState(state, { data, status }) {
            state.paginateEvents = data;

        },
        //end events

        // service
        setPaginateServiceState(state, { data, status }) {
            state.paginateServices = data;

        },
        //end service

        // Jobs
        setPaginateJobState(state, { data, status }) {
            state.paginateJobs = data;

        },
        //end Jobs

        // professionals
        setPaginateProfessionalState(state, { data, status }) {
            state.paginateProfessionals = data;

        },
        //end professionals





        // single business
        setBusinessSingleState(state, data) {

            state.singleBusinesses = data.data;

        },
        //end single business

        // single event
        setEventSingleState(state, data) {
            state.singleEvents = data.data;

        },
        //end single event

        // single professional
        setProfessionalSingleState(state, data) {
            state.singleProfessionals = data.data;

        },
        //end single professional

        // single service
        setServiceSingleState(state, data) {
            state.singleServices = data.data;

        },
        //end single service

        // single job
        setJobSingleState(state, data) {
            state.singleJobs = data.data;

        },
        //end single job



        ///// similar pages
        // similar business
        setBusinessSimilarState(state, data) {

            state.similarBusinesses = data.data;

        },
        //end similar business

        // similar event
        setEventSimilarState(state, data) {
            state.similarEvents = data.data;

        },
        //end similar event

        // similar professional
        setProfessionalSimilarState(state, data) {
            state.similarProfessionals = data.data;

        },
        //end similar professional

        // similar service
        setServiceSimilarState(state, data) {
            state.similarServices = data.data;

        },
        //end similar service

        // similar job
        setJobSimilarState(state, data) {
            state.similarJobs = data.data;

        },
        //end similar job



        /////sub pages



    },
    actions: {
        contactAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('contact_us').store(data).then((res) => {

                    resolve(res.data.data)
                }).catch((err) => {
                    reject(err)
                })
            });
        },

        searchAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('search_any').get(data.word).then((res) => {

                    resolve(res.data.data)
                }).catch((err) => {
                    reject(err)
                })
            });
        },

        getCategoryAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                new Resource('get_categories').list({}).then((res) => {
                    resolve(res.data.data);
                }).catch((err) => {
                    reject(err);
                });
            });
        },

        findAnyAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('find_any').store(data).then((res) => {

                    resolve(res.data.data)
                }).catch((err) => {
                    reject(err)
                })
            });
        },

        // get business
        allBusinessAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                new Resource('page_business').list({}).then((res) => {
                    commit('setBusinessState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        //end business

        // get service
        allServiceAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                new Resource('page_service').list({}).then((res) => {
                    commit('setServiceState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        //end service

        // get job
        allJobAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                new Resource('page_job').list({}).then((res) => {
                    commit('setJobState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        //end job

        // get professional
        allProfessionalAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                new Resource('page_professional').list({}).then((res) => {
                    commit('setProfessionalState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        //end professional

        // get event
        allEventAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                new Resource('page_event').list({}).then((res) => {
                    commit('setEventState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        //end event




        //paginate
        // get business
        paginateBusinessAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {

                new Resource('paginate_business').paginate(data).then((res) => {
                    commit('setPaginateBusinessState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        businessPaginateDataAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                resolve(state.paginateBusinesses.paginated)
            })
        },
        //end business

        // get service
        paginateServiceAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('paginate_service').paginate(data).then((res) => {

                    commit('setPaginateServiceState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        servicePaginateDataAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                resolve(state.paginateServices.paginated)
            })
        },
        //end service

        // get job
        paginateJobAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('paginate_job').paginate(data).then((res) => {

                    commit('setPaginateJobState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        jobPaginateDataAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                resolve(state.paginateJobs.paginated)
            })
        },
        //end job

        // get professional
        paginateProfessionalAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('paginate_professional').paginate(data).then((res) => {

                    commit('setPaginateProfessionalState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        professionalPaginateDataAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                resolve(state.paginateProfessionals.paginated)
            })
        },
        //end professional

        // get event
        paginateEventAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('paginate_event').paginate(data).then((res) => {

                    commit('setPaginateEventState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        eventPaginateDataAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                resolve(state.paginateEvents.paginated)
            })
        },
        //end event





        // get single business
        singleBusinessAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('single_business').store(data).then((res) => {

                    commit('setBusinessSingleState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        //end business

        // get single event
        singleEventAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('single_event').store(data).then((res) => {
                    commit('setEventSingleState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        //end event

        // get single professional
        singleProfessionalAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('single_professional').store(data).then((res) => {
                    commit('setProfessionalSingleState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        //end professional

        // get single service
        singleServiceAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('single_service').store(data).then((res) => {
                    commit('setServiceSingleState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        //end service

        // get single job
        singleJobAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('single_job').store(data).then((res) => {
                    commit('setJobSingleState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        //end job




        //similar
        // get similar business
        similarBusinessAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('similar_business').store(data).then((res) => {

                    commit('setBusinessSimilarState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        //end business

        // get similar event
        similarEventAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('similar_event').store(data).then((res) => {
                    commit('setEventSimilarState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        //end event

        // get similar professional
        similarProfessionalAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('similar_professional').store(data).then((res) => {
                    commit('setProfessionalSimilarState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        //end professional

        // get similar service
        similarServiceAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('similar_service').store(data).then((res) => {
                    commit('setServiceSimilarState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        //end service

        // get similar job
        similarJobAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('similar_job').store(data).then((res) => {
                    commit('setJobSimilarState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        //end job

    },
    getters: {

        // businesses getter
        getAllBusinesses(state) {
            return state.businesses;
        },
        //end businesses

        // services getter
        getAllServices(state) {
            return state.services;
        },
        //end services

        // jobs getter
        getAllJobs(state) {
            return state.jobs;
        },
        //end jobs

        // events getter
        getAllEvents(state) {
            return state.events;
        },
        //end events

        // professionals getter
        getAllProfessionals(state) {
            return state.professionals;
        },
        //end professionals




        //pagination
        // businesses getter
        getPaginateBusinesses(state) {
            return state.paginateBusinesses;
        },
        //end businesses

        // services getter
        getPaginateServices(state) {
            return state.paginateServices;
        },
        //end services

        // jobs getter
        getPaginateJobs(state) {
            return state.paginateJobs;
        },
        //end jobs

        // events getter
        getPaginateEvents(state) {
            return state.paginateEvents;
        },
        //end events

        // professionals getter
        getPaginateProfessionals(state) {
            return state.paginateProfessionals;
        },
        //end professionals





        //single business getter
        getSingleBusiness(state) {
            return state.singleBusinesses;
        },
        //end businesses

        //single event getter
        getSingleEvent(state) {
            return state.singleEvents;
        },
        //end event

        //single professional getter
        getSingleProfessional(state) {
            return state.singleProfessionals;
        },
        //end professional

        //single service getter
        getSingleService(state) {
            return state.singleServices;
        },
        //end service

        //single job getter
        getSingleJob(state) {
            return state.singleJobs;
        },
        //end job


        ///similar
        //similar business getter
        getSimilarBusiness(state) {
            return state.similarBusinesses;
        },
        //end businesses

        //similar event getter
        getSimilarEvent(state) {
            return state.similarEvents;
        },
        //end event

        //similar professional getter
        getSimilarProfessional(state) {
            return state.similarProfessionals;
        },
        //end professional

        //similar service getter
        getSimilarService(state) {
            return state.similarServices;
        },
        //end service

        //similar job getter
        getSimilarJob(state) {
            return state.similarJobs;
        },
        //end job


    }
};