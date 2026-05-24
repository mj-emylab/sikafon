import Resource from '../../service/resources';
import { METHODS } from '../../service/const';


//Route Registration
const CategoryRoute = new Resource('categories');

const AreaRoute = new Resource('areas');
const DistrictRoute = new Resource('districts');
const RegionRoute = new Resource('regions');
const CountryRoute = new Resource('countries');

const AreaBossRoute = new Resource('area_bosses');
const AreaManagerRoute = new Resource('area_managers');
const DistrictManagerRoute = new Resource('district_managers');
const RegionalManagerRoute = new Resource('regional_managers');

const AreaBoyRoute = new Resource('area_boys');

const PaymentChannelRoute = new Resource('payment_channels');
const PromotionRoute = new Resource('promotions');

const CommissionRoute = new Resource('commissions');
const PackageRoute = new Resource('packages');
const PackageItemRoute = new Resource('package_items');
const RoleRoute = new Resource('roles');
const PermissionRoute = new Resource('permissions');
const UserProfileRoute = new Resource('user_profiles');
const VerificationRoute = new Resource('verifications');
const SkillRoute = new Resource('skills');

const FlagRoute = new Resource('flags');
const TicketRoute = new Resource('tickets');
const SessionRoute = new Resource('sessions');
const UserRoute = new Resource('users');

export const administration = {
    namespaced: true,
    state: () => ({
        //
        categories: [],

        areas: [],
        districts: [],
        regions: [],
        countries: [],

        areaBosses: [],
        areaManagers: [],
        districtManagers: [],
        regionalManagers: [],

        areaBoys: [],

        promotions: [],
        paymentChannels: [],

        commissions: [],
        packages: [],
        packageItems: [],
        roles: [],
        permissions: [],
        userProfiles: [],
        userGallery: {},
        verifications: [],
        skills: [],

        flags: [],

        findmeProfiles: [],

        tickets: [],
        sessions: [],
        users: [],

    }),
    mutations: {
        //
        // findme user profile
        setFindMeProfileState(state, data) {
            state.findmeProfiles = data.data;

        },

        // user gallery
        setUserGalleryState(state, data) {
            state.userGallery = data.data;

        },

        // set session
        setSessionState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.sessions = data;
            } else if (status === METHODS._StoreMethod) {
                state.sessions = [...data, ...state.sessions];
            } else if (status === METHODS._PutMethod) {
                // 
                state.sessions = [...data, ...state.sessions];
            } else if (status === METHODS._DeleteMethod) {
                state.sessions = state.sessions.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set tickets
        setTicketState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.tickets = data;
            } else if (status === METHODS._StoreMethod) {
                state.tickets = [...data, ...state.tickets];
            } else if (status === METHODS._PutMethod) {
                state.tickets = [...data, ...state.tickets];
            } else if (status === METHODS._DeleteMethod) {
                state.tickets = state.tickets.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set category
        setCategoryState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.categories = data;
            } else if (status === METHODS._StoreMethod) {
                state.categories = [data, ...state.categories];
            } else if (status === METHODS._PutMethod) {
                state.categories = state.categories.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.categories = state.categories.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set user
        setUserState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.users = data;
            } else if (status === METHODS._StoreMethod) {
                state.users = [data, ...state.users];
            } else if (status === METHODS._PutMethod) {
                state.users = state.users.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.users = state.users.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set flag
        setFlagState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.flags = data;
            } else if (status === METHODS._StoreMethod) {
                state.flags = [data, ...state.flags];
            } else if (status === METHODS._PutMethod) {
                state.flags = state.flags.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.flags = state.flags.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set area
        setAreaState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.areas = data;
            } else if (status === METHODS._StoreMethod) {
                state.areas = [data, ...state.areas];
            } else if (status === METHODS._PutMethod) {
                state.areas = state.areas.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.areas = state.areas.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set district
        setDistrictState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.districts = data;
            } else if (status === METHODS._StoreMethod) {
                state.districts = [data, ...state.districts];
            } else if (status === METHODS._PutMethod) {
                state.districts = state.districts.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.districts = state.districts.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set region
        setRegionState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.regions = data;
            } else if (status === METHODS._StoreMethod) {
                state.regions = [data, ...state.regions];
            } else if (status === METHODS._PutMethod) {
                state.regions = state.regions.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.regions = state.regions.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set country
        setCountryState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.countries = data;
            } else if (status === METHODS._StoreMethod) {
                state.countries = [data, ...state.countries];
            } else if (status === METHODS._PutMethod) {
                state.countries = state.countries.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.countries = state.countries.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set area boss
        setAreaBossState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.areaBosses = data;
            } else if (status === METHODS._StoreMethod) {
                state.areaBosses = [data, ...state.areaBosses];
            } else if (status === METHODS._PutMethod) {
                state.areaBosses = state.areaBosses.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.areaBosses = state.areaBosses.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set area manager
        setAreaManagerState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.areaManagers = data;
            } else if (status === METHODS._StoreMethod) {
                state.areaManagers = [data, ...state.areaManagers];
            } else if (status === METHODS._PutMethod) {
                state.areaManagers = state.areaManagers.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.areaManagers = state.areaManagers.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set district manager
        setDistrictManagerState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.districtManagers = data;
            } else if (status === METHODS._StoreMethod) {
                state.districtManagers = [data, ...state.districtManagers];
            } else if (status === METHODS._PutMethod) {
                state.districtManagers = state.districtManagers.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.districtManagers = state.districtManagers.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set regional manager
        setRegionalManagerState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.regionalManagers = data;
            } else if (status === METHODS._StoreMethod) {
                state.regionalManagers = [data, ...state.regionalManagers];
            } else if (status === METHODS._PutMethod) {
                state.regionalManagers = state.regionalManagers.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.regionalManagers = state.regionalManagers.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set area boys
        setAreaBoyState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.areaBoys = data;
            } else if (status === METHODS._StoreMethod) {
                state.areaBoys = [data, ...state.areaBoys];
            } else if (status === METHODS._PutMethod) {
                state.areaBoys = state.areaBoys.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.areaBoys = state.areaBoys.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set commissions
        setCommissionState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.commissions = data;
            } else if (status === METHODS._StoreMethod) {
                state.commissions = [data, ...state.commissions];
            } else if (status === METHODS._PutMethod) {
                state.commissions = state.commissions.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.commissions = state.commissions.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set promotion
        setPromotionState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.promotions = data;
            } else if (status === METHODS._StoreMethod) {
                state.promotions = [data, ...state.promotions];
            } else if (status === METHODS._PutMethod) {
                state.promotions = state.promotions.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.promotions = state.promotions.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set payment channel
        setPaymentChannelState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.paymentChannels = data;
            } else if (status === METHODS._StoreMethod) {
                state.paymentChannels = [data, ...state.paymentChannels];
            } else if (status === METHODS._PutMethod) {
                state.paymentChannels = state.paymentChannels.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.paymentChannels = state.paymentChannels.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set package
        setPackageState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.packages = data;
            } else if (status === METHODS._StoreMethod) {
                state.packages = [data, ...state.packages];
            } else if (status === METHODS._PutMethod) {
                state.packages = state.packages.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.packages = state.packages.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set package items
        setPackageItemState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.packageItems = data;
            } else if (status === METHODS._StoreMethod) {
                state.packageItems = [data, ...state.packageItems];
            } else if (status === METHODS._PutMethod) {
                state.packageItems = state.packageItems.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.packageItems = state.packageItems.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set role
        setRoleState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.roles = data;
            } else if (status === METHODS._StoreMethod) {
                state.roles = [data, ...state.roles];
            } else if (status === METHODS._PutMethod) {
                state.roles = state.roles.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.roles = state.roles.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set permission
        setPermissionState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.permissions = data;
            } else if (status === METHODS._StoreMethod) {
                state.permissions = [data, ...state.permissions];
            } else if (status === METHODS._PutMethod) {
                state.permissions = state.permissions.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.permissions = state.permissions.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set user profile
        setUserProfileState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.userProfiles = data;
            } else if (status === METHODS._StoreMethod) {
                state.userProfiles = [data, ...state.userProfiles];
            } else if (status === METHODS._PutMethod) {
                state.userProfiles = state.userProfiles.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.userProfiles = state.userProfiles.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set verification
        setVerificationState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.verifications = data;
            } else if (status === METHODS._StoreMethod) {
                state.verifications = [data, ...state.verifications];
            } else if (status === METHODS._PutMethod) {
                state.verifications = state.verifications.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.verifications = state.verifications.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set skill
        setSkillState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.skills = data;
            } else if (status === METHODS._StoreMethod) {
                state.skills = [data, ...state.skills];
            } else if (status === METHODS._PutMethod) {
                state.skills = state.skills.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.skills = state.skills.filter((item) => item.id !== data.id);
            }
        },
        // end

    },
    actions: {
        //
        // pay commission
        payCommissionAction({ state, commit }, data) {
            new Resource('pay_commissions').store(data).then((res) => {
                commit('setCommissionState', { data: res.data.data, status: METHODS._StoreMethod });
                resolve(true);
            }).catch((err) => {
                reject(err);
            });
        },
        //end

        // user gallery
        allUserGalleryAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                new Resource('user_gallery').list({}).then((res) => {
                    commit('setUserGalleryState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        //end

        //commission status
        statusCommissionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('commissions/update').get(data.id).then((res) => {
                    commit('setCommissionState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        //end

        // verification
        allVerificationAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                VerificationRoute.list({}).then((res) => {
                    commit('setVerificationState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveVerificationAction({ state, commit }, data) {
            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("message", data.message);
            formdata.append("action_id", data.action_id);
            formdata.append("guarantor1", data.guarantor1);
            formdata.append("guarantor2", data.guarantor2);
            formdata.append("cardId", data.cardId);
            formdata.append("location", data.location);
            formdata.append("level_id", data.level_id);

            formdata.append("type_id", data.type_id);
            formdata.append("type", data.type);

            data.fileRecordsForUpload.forEach(element => {
                formdata.append('files[]', element.file);
            });

            return new Promise((resolve, reject) => {
                VerificationRoute.store(formdata).then((res) => {
                    commit('setVerificationState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateVerificationAction({ state, commit }, data) {

            return new Promise((resolve, reject) => {
                VerificationRoute.update(data, data.id).then((res) => {
                    commit('setVerificationState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteVerificationAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                VerificationRoute.destroy(data.id).then((res) => {
                    commit('setVerificationState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // user
        allUserAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                UserRoute.list({}).then((res) => {
                    commit('setUserState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveUserAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                UserRoute.store(data).then((res) => {
                    commit('setUserState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateUserAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                UserRoute.update(data, data.id).then((res) => {
                    commit('setUserState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        changeUserAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('user/type').updateFormData(data, data.id).then((res) => {
                    commit('setUserState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteUserAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                UserRoute.destroy(data.id).then((res) => {
                    commit('setUserState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // package
        allPackageAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                PackageRoute.list({}).then((res) => {
                    commit('setPackageState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        savePackageAction({ state, commit }, data) {
            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("service_id", data.service_id);
            formdata.append("image", data.image);
            formdata.append("details", JSON.stringify(data.details));
            formdata.append("name", data.name);
            formdata.append("description", data.description);
            formdata.append("duration", data.duration);
            formdata.append("cost", data.cost);

            return new Promise((resolve, reject) => {
                PackageRoute.store(formdata).then((res) => {
                    commit('setPackageState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updatePackageAction({ state, commit }, data) {

            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("service_id", data.service_id);
            formdata.append("image", data.image);
            formdata.append("details", JSON.stringify(data.details));
            formdata.append("name", data.name);
            formdata.append("description", data.description);
            formdata.append("duration", data.duration);
            formdata.append("cost", data.cost);

            return new Promise((resolve, reject) => {
                new Resource('package/update').updateFormData(formdata, data.id).then((res) => {
                    commit('setPackageState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deletePackageAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                PackageRoute.destroy(data.id).then((res) => {
                    commit('setPackageState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // PackageItem
        allPackageItemAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                PackageItemRoute.list({}).then((res) => {
                    commit('setPackageItemState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        savePackageItemAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                PackageItemRoute.store(data).then((res) => {
                    commit('setPackageItemState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updatePackageItemAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                PackageItemRoute.update(data, data.id).then((res) => {
                    commit('setPackageItemState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deletePackageItemAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                PackageItemRoute.destroy(data.id).then((res) => {
                    commit('setPackageItemState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // user profile
        allUserProfileAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                UserProfileRoute.list({}).then((res) => {
                    commit('setUserProfileState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveUserProfileAction({ state, commit }, data) {
            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("name", data.name);
            formdata.append("description", data.description);

            if (data.fileRecordsForUpload.length === 0) {
                formdata.append('files[]', {});
                formdata.append("file", {});
            } else {

                formdata.append("file", data.fileRecordsForUpload[0].file);
                data.fileRecordsForUpload.forEach(element => {
                    formdata.append('files[]', element.file);
                });
            }

            return new Promise((resolve, reject) => {
                UserProfileRoute.store(formdata).then((res) => {
                    commit('setUserProfileState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateUserProfileAction({ state, commit }, data) {

            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("name", data.name);
            formdata.append("description", data.description);

            if (data.fileRecordsForUpload.length == 0) {
                formdata.append('files[]', {});
                formdata.append("file", {});
            } else {

                formdata.append("file", data.fileRecordsForUpload[0].file);
                data.fileRecordsForUpload.forEach(element => {
                    formdata.append('files[]', element.file);
                });
            }

            return new Promise((resolve, reject) => {
                new Resource('user_profiles/update').updateFormData(formdata, data.id).then((res) => {
                    commit('setUserProfileState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteUserProfileAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                UserProfileRoute.destroy(data.id).then((res) => {
                    commit('setUserProfileState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        downloadUserProfileAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('user_profiles/download').get(data.id).then((res) => {
                    // commit('setUserProfileState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(res);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // flag
        allFlagAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                FlagRoute.list({}).then((res) => {
                    commit('setFlagState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveFlagAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                FlagRoute.store(data).then((res) => {
                    commit('setFlagState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateFlagAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                FlagRoute.update(data, data.id).then((res) => {
                    commit('setFlagState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteFlagAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                FlagRoute.destroy(data.id).then((res) => {
                    commit('setFlagState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // session
        allSessionAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                SessionRoute.list({}).then((res) => {
                    commit('setSessionState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveSessionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                SessionRoute.store(data).then((res) => {
                    commit('setSessionState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateSessionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                SessionRoute.update(data, data.id).then((res) => {
                    commit('setSessionState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteSessionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                SessionRoute.destroy(data.id).then((res) => {
                    commit('setSessionState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // ticket
        allTicketAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                TicketRoute.list({}).then((res) => {
                    commit('setTicketState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveTicketAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                TicketRoute.store(data).then((res) => {
                    commit('setTicketState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateTicketAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                TicketRoute.update(data, data.id).then((res) => {
                    commit('setTicketState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteTicketAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                TicketRoute.destroy(data.id).then((res) => {
                    commit('setTicketState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // Role
        allRoleAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                RoleRoute.list({}).then((res) => {
                    commit('setRoleState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveRoleAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                RoleRoute.store(data).then((res) => {
                    commit('setRoleState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateRoleAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                RoleRoute.update(data, data.id).then((res) => {
                    commit('setRoleState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteRoleAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                RoleRoute.destroy(data.id).then((res) => {
                    commit('setRoleState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // Permission
        allPermissionAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                PermissionRoute.list({}).then((res) => {
                    commit('setPermissionState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        savePermissionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                PermissionRoute.store(data).then((res) => {
                    commit('setPermissionState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updatePermissionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                PermissionRoute.update(data, data.id).then((res) => {
                    commit('setPermissionState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deletePermissionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                PermissionRoute.destroy(data.id).then((res) => {
                    commit('setPermissionState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // Area
        allAreaAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                AreaRoute.list({}).then((res) => {
                    commit('setAreaState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveAreaAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                AreaRoute.store(data).then((res) => {
                    commit('setAreaState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateAreaAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                AreaRoute.update(data, data.id).then((res) => {
                    commit('setAreaState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteAreaAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                AreaRoute.destroy(data.id).then((res) => {
                    commit('setAreaState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // District
        allDistrictAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                DistrictRoute.list({}).then((res) => {
                    commit('setDistrictState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveDistrictAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                DistrictRoute.store(data).then((res) => {
                    commit('setDistrictState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateDistrictAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                DistrictRoute.update(data, data.id).then((res) => {
                    commit('setDistrictState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteDistrictAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                DistrictRoute.destroy(data.id).then((res) => {
                    commit('setDistrictState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // Region
        allRegionAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                RegionRoute.list({}).then((res) => {
                    commit('setRegionState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveRegionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                RegionRoute.store(data).then((res) => {
                    commit('setRegionState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateRegionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                RegionRoute.update(data, data.id).then((res) => {
                    commit('setRegionState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteRegionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                RegionRoute.destroy(data.id).then((res) => {
                    commit('setRegionState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // Country
        allCountryAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                CountryRoute.list({}).then((res) => {
                    commit('setCountryState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveCountryAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                CountryRoute.store(data).then((res) => {
                    commit('setCountryState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateCountryAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                CountryRoute.update(data, data.id).then((res) => {
                    commit('setCountryState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteCountryAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                CountryRoute.destroy(data.id).then((res) => {
                    commit('setCountryState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // AreaBoss
        allAreaBossAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                AreaBossRoute.list({}).then((res) => {
                    commit('setAreaBossState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveAreaBossAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                AreaBossRoute.store(data).then((res) => {
                    commit('setAreaBossState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateAreaBossAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                AreaBossRoute.update(data, data.id).then((res) => {
                    commit('setAreaBossState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteAreaBossAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                AreaBossRoute.destroy(data.id).then((res) => {
                    commit('setAreaBossState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // AreaManager
        allAreaManagerAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                AreaManagerRoute.list({}).then((res) => {
                    commit('setAreaManagerState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveAreaManagerAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                AreaManagerRoute.store(data).then((res) => {
                    commit('setAreaManagerState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateAreaManagerAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                AreaManagerRoute.update(data, data.id).then((res) => {
                    commit('setAreaManagerState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteAreaManagerAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                AreaManagerRoute.destroy(data.id).then((res) => {
                    commit('setAreaManagerState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // DistrictManager
        allDistrictManagerAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                DistrictManagerRoute.list({}).then((res) => {
                    commit('setDistrictManagerState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveDistrictManagerAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                DistrictManagerRoute.store(data).then((res) => {
                    commit('setDistrictManagerState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateDistrictManagerAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                DistrictManagerRoute.update(data, data.id).then((res) => {
                    commit('setDistrictManagerState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteDistrictManagerAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                DistrictManagerRoute.destroy(data.id).then((res) => {
                    commit('setDistrictManagerState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // RegionalManager
        allRegionalManagerAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                RegionalManagerRoute.list({}).then((res) => {
                    commit('setRegionalManagerState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveRegionalManagerAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                RegionalManagerRoute.store(data).then((res) => {
                    commit('setRegionalManagerState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateRegionalManagerAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                RegionalManagerRoute.update(data, data.id).then((res) => {
                    commit('setRegionalManagerState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteRegionalManagerAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                RegionalManagerRoute.destroy(data.id).then((res) => {
                    commit('setRegionalManagerState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // AreaBoy
        allAreaBoyAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                AreaBoyRoute.list({}).then((res) => {
                    commit('setAreaBoyState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveAreaBoyAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                AreaBoyRoute.store(data).then((res) => {
                    commit('setAreaBoyState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateAreaBoyAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                AreaBoyRoute.update(data, data.id).then((res) => {
                    commit('setAreaBoyState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteAreaBoyAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                AreaBoyRoute.destroy(data.id).then((res) => {
                    commit('setAreaBoyState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // Commission
        allCommissionAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                CommissionRoute.list({}).then((res) => {
                    commit('setCommissionState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveCommissionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                CommissionRoute.store(data).then((res) => {
                    commit('setCommissionState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateCommissionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                CommissionRoute.update(data, data.id).then((res) => {
                    commit('setCommissionState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteCommissionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                CommissionRoute.destroy(data.id).then((res) => {
                    commit('setCommissionState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // Promotion
        allPromotionAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                PromotionRoute.list({}).then((res) => {
                    commit('setPromotionState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        savePromotionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                PromotionRoute.store(data).then((res) => {
                    commit('setPromotionState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updatePromotionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                PromotionRoute.update(data, data.id).then((res) => {
                    commit('setPromotionState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deletePromotionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                PromotionRoute.destroy(data.id).then((res) => {
                    commit('setPromotionState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // PaymentChannel
        allPaymentChannelAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                PaymentChannelRoute.list({}).then((res) => {
                    commit('setPaymentChannelState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        savePaymentChannelAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                PaymentChannelRoute.store(data).then((res) => {
                    commit('setPaymentChannelState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updatePaymentChannelAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                PaymentChannelRoute.update(data, data.id).then((res) => {
                    commit('setPaymentChannelState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deletePaymentChannelAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                PaymentChannelRoute.destroy(data.id).then((res) => {
                    commit('setPaymentChannelState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // Skill
        allSkillAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                SkillRoute.list({}).then((res) => {
                    commit('setSkillState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveSkillAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                SkillRoute.store(data).then((res) => {
                    commit('setSkillState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateSkillAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                SkillRoute.update(data, data.id).then((res) => {
                    commit('setSkillState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteSkillAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                SkillRoute.destroy(data.id).then((res) => {
                    commit('setSkillState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // Category
        allCategoryAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                CategoryRoute.list({}).then((res) => {
                    commit('setCategoryState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveCategoryAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                CategoryRoute.store(data).then((res) => {
                    commit('setCategoryState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateCategoryAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                CategoryRoute.update(data, data.id).then((res) => {
                    commit('setCategoryState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteCategoryAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                CategoryRoute.destroy(data.id).then((res) => {
                    commit('setCategoryState', { data: data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end





    },
    getters: {
        // 
        // return all user gallery
        getUserGallery(state) {
            return state.userGallery;
        },

        // return all categories
        getCategories(state) {
            return state.categories;
        },

        // return all tickets
        getTickets(state) {
            return state.tickets;
        },

        // return all users
        getUsers(state) {
            return state.users;
        },

        // return all sessions
        getSessions(state) {
            return state.sessions;
        },

        // return all flags
        getFlags(state) {
            return state.flags;
        },

        // return all areas
        getAreas(state) {
            return state.areas;
        },

        // return all districts
        getDistricts(state) {
            return state.districts;
        },

        // return all regions
        getRegions(state) {
            return state.regions;
        },

        // return all countries
        getCountries(state) {
            return state.countries;
        },

        // return all area bosses
        getAreaBosses(state) {
            return state.areaBosses;
        },

        // return all area managers
        getAreaManagers(state) {
            return state.areaManagers;
        },

        // return all district managers
        getDistrictManagers(state) {
            return state.districtManagers;
        },

        // return all regional manager
        getRegionalManagers(state) {
            return state.regionalManagers;
        },

        // return all areaBoys
        getAreaBoys(state) {
            return state.areaBoys;
        },

        // return all commissions
        getCommissions(state) {
            return state.commissions;
        },

        // return all promotions
        getPromotions(state) {
            return state.promotions;
        },

        // return all payment channels
        getPaymentChannels(state) {
            return state.paymentChannels;
        },

        // return all roles
        getRoles(state) {
            return state.roles;
        },

        // return all permissions
        getPermissions(state) {
            return state.permissions;
        },

        // return all skills
        getSkills(state) {
            return state.skills;
        },

        // return all user profiles
        getUserProfiles(state) {
            return state.userProfiles;
        },

        // return all verifications
        getVerifications(state) {
            return state.verifications;
        },

        // return all packages
        getPackages(state) {
            return state.packages;
        },

        // return all package items
        getPackageItems(state) {
            return state.packageItems;
        },




    }
};