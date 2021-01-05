import AuthService from "../../common/auth.service"
import ApiService from "../../common/api.service";
import {
    LOGIN,
    LOGOUT,
    REGISTER,
    CHECK_AUTH,
    UPDATE_USER
} from "../action.types";
import {SET_AUTH, PURGE_AUTH, SET_ERROR, SET_USER} from "../mutations.type";

const state = {
    errors: null,
    user: {},
    isAuthenticated: !!AuthService.getToken(),
    isUserLoading:false
};
const getters = {
    currentUser(state) {
        return state.user;
    },
    isAuthenticated(state) {
        return state.isAuthenticated;
    },
    loadingUser(state) {
        return state.isUserLoading
    },
    preferinte(state){
        let arr=[];
        let idx=0;
        state.user.categorii.forEach(element => {
            arr[idx++]=element.id
        });
        return arr;
    },
    errori(state){
      return state.errors
    }

};

const actions = {

    [LOGIN](context, credentials) {
        return new Promise(resolve => {
            context.commit('loadingUser',true);
            ApiService.post("users/login", { email: credentials.email,password:credentials.password})
                .then(({ data }) => {
                const payload={user:data.user,accessToken:data.accessToken};
                    context.commit(SET_AUTH, payload);
                    context.commit('loadingUser',false)
                    resolve(data);
                })
                .catch(({ response }) => {
                    context.commit(SET_ERROR, response.data.errors);
                });
        });
    },
    [UPDATE_USER](context,payload){
        return ApiService.put('/user',payload)
    },
    [LOGOUT](context) {
        context.commit(PURGE_AUTH);
    },
    [REGISTER](context, credentials) {
        return new Promise((resolve, reject) => {
            ApiService.post("users/register",  credentials )
                .then(({ data }) => {
                    context.commit(SET_AUTH, data.user);
                    context.commit('loadingUser',false)
                    return data;
                })
                .catch(({ response }) => {
                    context.commit(SET_ERROR, response.data.errors);
                    return response
                });
        });
    },

    [CHECK_AUTH](context) {
        if (AuthService.getToken()) {
            context.commit('loadingUser',true)
            ApiService.setHeader();
            ApiService.get("user")
                .then(({ data }) => {
                    context.commit(SET_USER, data);
                    context.commit('loadingUser',false)
                })
                .catch(({ response }) => {
                    context.commit(SET_ERROR, response.data.errors);
                });
        } else {

        }
    },
};



const mutations = {
    [SET_ERROR](state, error) {
        state.errors = error;
    },
    [SET_AUTH](state,payload) {
        state.isAuthenticated = true;
        state.user = payload.user;
        state.errors = {};
        AuthService.saveToken(payload.accessToken);
    },
    [SET_USER](state,payload){
        state.isAuthenticated = true;
        state.user = payload.user;
        state.errors = {};
    },
    [PURGE_AUTH](state) {
        state.isAuthenticated = false;
        state.user = {};
        state.errors = {};
        AuthService.destroyToken();
    },
    loadingUser(state,value){
      state.isUserLoading=value
    }
};

export default {
    state,
    actions,
    mutations,
    getters
};



