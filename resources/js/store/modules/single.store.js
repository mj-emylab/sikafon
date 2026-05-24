import Resource from '../../service/resources';
import { METHODS } from '../../service/const';

// route registration
const UserRequestRoute = new Resource('messages');
const UserResponseRoute = new Resource('replies');
const ReplyRoute = new Resource('replies');
const MessageRoute = new Resource('messages');
const GroupRoute = new Resource('groups');
const GroupUserRoute = new Resource('group_users');
const ShareRoute = new Resource('shares');

export const single = {
    namespaced: true,
    state: () => ({
        userResponse: [], //for all res to any req
        userRequest: [], //for all req on packages

        findResponse: [], //for all res on find someone
        share: [], // for save update delete and get all

        messages: [],
        replies: [],
        groups: [],
        groupUsers: [],

        // comment: [],
        // session: [],
        // ticket: [],
        // applyJob: [],
        // package: [],
        user: {},
        userFiles: [],
        comments: [],

        business: [],
        event: [],
        job: [],
        professional: [],
        service: [],

        chatHistory: [],
        lastPage: 0,

        dashboard: [],
        deletedForMe: {},
    }),
    mutations: {

        // dashboard data
        setDashboardState(state, data) {
            state.dashboard = data.data;
        },
        //end

        // chat history
        setChatHistoryState(state, data) {

            state.chatHistory = data.data;

        },
        //end

        // business
        setBusinessState(state, data) {

            state.business = data.data;

        },
        //end

        // event
        setEventState(state, data) {
            state.event = data.data;

        },
        //end

        // professional
        setProfessionalState(state, data) {
            state.professional = data.data;

        },
        //end

        // service
        setServiceState(state, data) {
            state.service = data.data;

        },
        //end

        // job
        setJobState(state, data) {
            state.job = data.data;

        },
        //end

        // findresponse
        setFindResponseState(state, data) {
            state.findResponse = data.data;

        },
        //end

        // set all share
        setShareState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.share = data;
            } else if (status === METHODS._StoreMethod) {
                state.share = [data, ...state.share];
            } else if (status === METHODS._PutMethod) {
                state.share = state.share.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.share = state.share.filter((item) => item.id !== data.id);
            }
        },
        // end




        // set a user request
        setUserRequestState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.userRequest = data;
            } else if (status === METHODS._StoreMethod) {
                state.userRequest = [data, ...state.userRequest];
            } else if (status === METHODS._PutMethod) {
                state.userRequest = state.userRequest.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.userRequest = state.userRequest.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set a user response
        setUserResponseState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.userResponse = data;
            } else if (status === METHODS._StoreMethod) {
                state.userResponse = [data, ...state.userResponse];
            } else if (status === METHODS._PutMethod) {
                state.userResponse = state.userResponse.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.userResponse = state.userResponse.filter((item) => item.id !== data.id);
            }
        },
        // end

        // user by findme id setter
        setUserState(state, data) {
            state.user = data.data;
        },
        //end

        // user files setter
        setUserFileState(state, data) {
            state.userFiles = data.data;

        },
        //end

        // page comment setter
        setCommentState(state, data) {
            state.comments = data.data;
        },
        //end

        // set all replies
        setReplyState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.replies = data;
            } else if (status === METHODS._StoreMethod) {
                state.replies = [data, ...state.replies];
            } else if (status === METHODS._PutMethod) {
                state.replies = state.replies.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.replies = state.replies.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set all messages
        setMessageState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.messages = data;
            } else if (status === METHODS._StoreMethod) {
                state.messages = [data, ...state.messages];
            } else if (status === METHODS._PutMethod) {
                state.messages = state.messages.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.messages = state.messages.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set all groups
        setGroupState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.groups = data;
            } else if (status === METHODS._StoreMethod) {
                state.groups = [data, ...state.groups];
            } else if (status === METHODS._PutMethod) {
                state.groups = state.groups.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.groups = state.groups.filter((item) => item.id !== data.id);
            }
        },
        // end

        // set all groupUsers
        setGroupUserState(state, { data, status }) {
            if (status === METHODS._ListMethod) {
                state.groupUsers = data;
            } else if (status === METHODS._StoreMethod) {
                state.groupUsers = [data, ...state.groupUsers];
            } else if (status === METHODS._PutMethod) {
                state.groupUsers = state.groupUsers.map(item => {
                    if (item.id === data.id) {
                        return data;
                    }
                    return item;
                });
            } else if (status === METHODS._DeleteMethod) {
                state.groupUsers = state.groupUsers.filter((item) => item.id !== data.id);
            }
        },
        // end

        // last page
        setLastPageState(state, data) {
            state.lastPage = data;
        },
        //end

        // deleted for me replies
        setMyRemovedMessageState(state, data) {
            state.deletedForMe = data;
        },
        //end


    },
    actions: {
        setDashboardAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                new Resource('dashboard/data').list({}).then((res) => {
                    commit('setDashboardState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },

        getMyRemovedMessageAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                new Resource('my_delete_messages/get').list({}).then((res) => {
                    commit('setMyRemovedMessageState', res.data.data);
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },

        setMyRemovedMessageAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('my_delete_messages/add').store(data).then((res) => {
                    commit('setMyRemovedMessageState', res.data.data);
                    resolve(res.data.data)
                }).catch((err) => {
                    reject(err)
                })
            });
        },

        setLastPageAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                commit('setLastPageState', data);
                resolve(true);
            });
        },
        getLastPageAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                if (state.lastPage == 0) {
                    resolve([]);
                } else {
                    new Resource('message/last').get(state.lastPage).then((res) => {
                        // commit('setCommentState', res.data.data);
                        resolve(res.data.data);
                    }).catch((error) => {
                        reject(error);
                    });
                }

            });
        },

        joinGroupAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('group/admin').get(data.id).then((res) => {
                    // commit('setCommentState', res.data.data);
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        allAffiliateAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                new Resource('affiliate/join').list({}).then((res) => {
                    // commit('setMessageState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },

        // get all user request
        allChatHistoryAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                new Resource('chat_history').list({}).then((res) => {
                    commit('setChatHistoryState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        // end

        // reply
        saveReplyAction({ state, commit }, data) {
            let formdata = new FormData();

            formdata.append("message_id", data.message_id);
            formdata.append("type", data.type);
            formdata.append("msg", data.msg);
            formdata.append("reply_id", data.reply_id);

            data.attached.forEach(element => {
                formdata.append('attached[]', element.file);
            });

            return new Promise((resolve, reject) => {
                ReplyRoute.store(formdata).then((res) => {
                    commit('setReplyState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteReplyAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                ReplyRoute.destroy(data.id).then((res) => {
                    commit('setReplyState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end
        // message
        allMessageAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                MessageRoute.list({}).then((res) => {
                    commit('setMessageState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveMessageAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                MessageRoute.store(data).then((res) => {
                    commit('setMessageState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateMessageAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                MessageRoute.update(data, data.id).then((res) => {
                    commit('setMessageState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteMessageAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                MessageRoute.destroy(data.id).then((res) => {
                    commit('setMessageState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // group user
        allGroupUserAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                GroupUserRoute.list({}).then((res) => {
                    commit('setGroupUserState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveGroupUserAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                GroupUserRoute.store(data).then((res) => {
                    commit('setGroupUserState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateGroupUserAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                GroupUserRoute.update(data, data.id).then((res) => {
                    commit('setGroupUserState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        makeGroupAdminAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('group/admin').get(data.id).then((res) => {
                    // commit('setCommentState', res.data.data);
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        deleteGroupUserAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                GroupUserRoute.destroy(data.id).then((res) => {
                    commit('setGroupUserState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end
        // get group
        allGroupAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                GroupRoute.list({}).then((res) => {
                    commit('setGroupState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveGroupAction({ state, commit }, data) {
            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("name", data.name);
            formdata.append("description", data.description);
            formdata.append("status", data.status);

            formdata.append("image", data.image);

            return new Promise((resolve, reject) => {
                GroupRoute.store(formdata).then((res) => {
                    commit('setGroupState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateGroupAction({ state, commit }, data) {

            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("name", data.name);
            formdata.append("description", data.description);
            formdata.append("status", data.status);

            formdata.append("image", data.image);

            return new Promise((resolve, reject) => {
                new Resource('group/update').updateFormData(formdata, data.id).then((res) => {
                    commit('setGroupState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },

        deleteGroupForMeAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('group/exit').get(data.id).then((res) => {
                    commit('setGroupState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },

        deleteGroupAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                GroupRoute.destroy(data.id).then((res) => {
                    commit('setGroupState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end



        // from users page 
        promotionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('promotion/create').store(data).then((res) => {
                    // commit('setCommentState', res.data.data);
                    resolve(res.data.data)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        getCommentAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('page/comment').store(data).then((res) => {
                    // commit('setCommentState', res.data.data);
                    resolve(res.data.data)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        commentAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('comment/send').store(data).then((res) => {
                    // commit('setUserNameState', res.data.data);
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        messageAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('message/send').store(data).then((res) => {
                    // commit('setUserNameState', res.data.data);
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        sessionAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('session/book').store(data).then((res) => {
                    // commit('setUserNameState', res.data.data);
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        ticketAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('ticket/book').store(data).then((res) => {
                    // commit('setUserNameState', res.data.data);
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        applyJobAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('job/book').store(data).then((res) => {
                    // commit('setUserNameState', res.data.data);
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        packageAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('package/book').store(data).then((res) => {
                    // commit('setUserNameState', res.data.data);
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        // user by findme id
        getUserAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('user/find').get(data.id).then((res) => {
                    commit('setUserState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        userFileAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('user/files').list({}).then((res) => {
                    commit('setUserFileState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        requestFileAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('findme/request').store(data).then((res) => {
                    // commit('setUserNameState', res.data.data);
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },

        //end from users page

        // get all user request
        allUserRequestAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                UserRequestRoute.list({}).then((res) => {
                    commit('setUserRequestState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveUserRequestAction({ state, commit }, data) {
            let formdata = new FormData();

            formdata.append("fimdmeId", data.fimdmeId);

            if (data.image == null || data.image == undefined || data.image == '' || data.image == "") {
                formdata.append("image", "None");
            } else {
                formdata.append("image", data.image);
            }

            return new Promise((resolve, reject) => {
                UserRequestRoute.store(formdata).then((res) => {
                    commit('setUserRequestState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateUserRequestAction({ state, commit }, data) {

            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("findmeId", data.findmeId);

            if (data.image == null || data.image == undefined || data.image == '' || data.image == "") {
                formdata.append("image", "None");
            } else {
                formdata.append("image", data.image);
            }

            return new Promise((resolve, reject) => {
                new Resource('user_requestes/update').updateFormData(formdata, data.id).then((res) => {
                    commit('setUserRequestState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteUserRequestAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                UserRequestRoute.destroy(data.id).then((res) => {
                    commit('setUserRequestState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // get all user response
        allUserResponseAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                UserResponseRoute.list({}).then((res) => {
                    commit('setUserResponseState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveUserResponseAction({ state, commit }, data) {
            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("findmeId", data.findmeId);

            if (data.image == null || data.image == undefined || data.image == '' || data.image == "") {
                formdata.append("image", "None");
            } else {
                formdata.append("image", data.image);
            }

            return new Promise((resolve, reject) => {
                UserResponseRoute.store(formdata).then((res) => {
                    commit('setUserResponseState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateUserResponseAction({ state, commit }, data) {

            let formdata = new FormData();

            formdata.append("id", data.id);
            formdata.append("findmeId", data.findmeId);

            if (data.image == null || data.image == undefined || data.image == '' || data.image == "") {
                formdata.append("image", "None");
            } else {
                formdata.append("image", data.image);
            }

            return new Promise((resolve, reject) => {
                new Resource('user_responses/update').updateFormData(formdata, data.id).then((res) => {
                    commit('setUserResponseState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteUserResponseAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                UserResponseRoute.destroy(data.id).then((res) => {
                    commit('setUserResponseState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end




        // business single
        businessAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('detail_business').store(data).then((res) => {

                    commit('setBusinessState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        // end

        // event single
        eventAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('detail_event').store(data).then((res) => {
                    commit('setEventState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        // end

        // professional single
        professionalAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('detail_professional').store(data).then((res) => {
                    commit('setProfessionalState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        // end

        // service single
        serviceAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('detail_service').store(data).then((res) => {
                    commit('setServiceState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        // end

        // job single
        jobAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('detail_job').store(data).then((res) => {
                    commit('setJobState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        // end


        // a find someone
        findResponseAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('find_response').store(data).then((res) => {
                    commit('setFindResponseState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        // end

        // all share
        allShareAction({ state, commit }) {
            return new Promise((resolve, reject) => {
                ShareRoute.list({}).then((res) => {
                    commit('setShareState', { data: res.data.data, status: METHODS._ListMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        saveShareAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                ShareRoute.store(data).then((res) => {
                    commit('setShareState', { data: res.data.data, status: METHODS._StoreMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        updateShareAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                ShareRoute.update(data, data.id).then((res) => {
                    commit('setShareState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        deleteShareAction({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                ShareRoute.destroy(data.id).then((res) => {
                    commit('setShareState', { data: res.data.data, status: METHODS._DeleteMethod });
                    resolve(true);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        // end

        // download file not in use
        downloadFile({ state, commit }, data) {
            return new Promise((resolve, reject) => {
                new Resource('download_file').store(data).then((res) => {
                    commit('setDownloadState', { data: res.data.data, status: METHODS._PutMethod });
                    resolve(true)
                }).catch((err) => {
                    reject(err)
                })
            });
        },
        // end

    },
    getters: {
        // dashboard data
        getDashboardData(state) {
            return state.dashboard;
        },

        // chats deleted for me
        getDeletedForMe(state) {
            return state.deletedForMe;
        },

        // chat history
        getChatHistory(state) {
            return state.chatHistory;
        },

        // groups
        getGroups(state) {
            return state.groups;
        },
        // group users
        getGroupUsers(state) {
            return state.groupUsers;
        },

        // messages
        getMessages(state) {
            return state.messages;
        },
        // end
        // replies
        getReplies(state) {
            return state.replies;
        },
        // end

        // business getter
        getBusiness(state) {
            return state.business;
        },
        // end

        // service getter
        getService(state) {
            return state.service;
        },
        // end

        // job getter
        getJob(state) {
            return state.job;
        },
        // end

        // event getter
        getEvent(state) {
            return state.event;
        },
        // end

        // professional getter
        getProfessional(state) {
            return state.professional;
        },
        // end



        // find response getter
        getFindResponse(state) {
            return state.findResponse;
        },
        // end

        // share getter
        getShare(state) {
            return state.share;
        },
        // end




        // user request getter
        getUserRequest(state) {
            return state.userRequest;
        },
        // end

        // user response getter
        getUserResponse(state) {
            return state.userResponse;
        },
        // end

        // get user by findme id getter
        getUser(state) {
            return state.user;
        },
        // end

        // get user files getter
        userFiles(state) {
            return state.userFiles;
        },
        // end

        // get page comment getter
        getComments(state) {
            return state.comments;
        },
        // end

    }
};