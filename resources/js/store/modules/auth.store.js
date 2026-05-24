import Resource from '../../service/resources';
import { METHODS } from '../../service/const';

const UserRoute = new Resource('users');
const UserNameRoute = new Resource('users/user_name');

export const auth = {
    namespaced: true,
    state: () => ({
        user: {},
        token: null,
        userName: {},
        permissions: []
    }),
    mutations: {
        setAuthState(state, data) {
            state.token = data.access_token;
            state.user = data.user;
            state.permissions = data.permissions;
        },
        clearAuthState(state) {
            state.token = null;
            state.user = null;
            state.permissions = null;
        },
        updateAuthState(state, data) {
            state.user = data;
        },
        reset() {},

        setUserNameState(state, data) {
            state.userName = data;
        },
    },
    actions: {

        registerAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                UserRoute.store(data).then((res) => {
                    commit('setAuthState', res.data.data);
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },

        loginAction({ state, commit }, formData) {
            return new Promise((resolve, reject) => {
                new Resource('login').store(formData).then((res) => {
                    commit('setAuthState', res.data.data);
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },

        //Logout
        logoutAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                new Resource('logout').list(null).then((res) => {
                    commit('clearAuthState');
                    resolve(true);
                }).catch((err) => {
                    console.log(err);
                    reject(err);
                });
            });
        },

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


        //reset password token
        createTokenPasswordReset({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('password/token').store(data).then((res) => {
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                })
            });
        },

        // new reset password details
        savePasswordResetDetails({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('reset/password').store(data).then((res) => {
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                })
            });
        },

        // Validate Reset Password Code
        validateResetPasswordToken({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('find/token').store(data).then((res) => {
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },

        // Update user password
        updateUserPassAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('password/update').store(data).then((res) => {
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },

        // Update user profile information
        updateUserProfile({ state, commit }, data) {
            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("first_name", data.first_name);
            formdata.append("last_name", data.last_name);
            formdata.append("middle_name", data.middle_name);
            formdata.append("phone", data.phone);
            formdata.append("email", data.email);
            formdata.append("area", data.area);
            formdata.append("country", data.country);
            formdata.append("findMeId", data.findMeId);
            formdata.append("country_code", data.country_code);
            formdata.append("dial_code", data.dial_code);
            formdata.append("lat", data.lat);
            formdata.append("long", data.long);
            formdata.append("pic", data.pic);

            return new Promise((resolve, reject) => {
                new Resource('profile/update').updateFormData(formdata, data.id).then((res) => {
                    console.log('Profile', res.data);
                    commit('updateAuthState', res.data.data);
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },


    },
    getters: {
        getToken(state) {
            return state.token;
        },
        user(state) {
            return state.user;
        },

        getUserName(state) {
            return state.userName;
        },

        permissions(state) {
            return state.permissions;
        },
    }
}