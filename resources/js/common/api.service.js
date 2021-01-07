import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import JwtService from "./auth.service";
import { API_URL } from "./config";

const ApiService = {
    init() {
        Vue.use(VueAxios, axios);
        Vue.axios.defaults.baseURL = API_URL;
        console.log(Vue.axios.defaults.baseURL)
    },

    setHeader() {
        console.log(JwtService.getToken())

        Vue.axios.defaults.headers.common[
            "Authorization"
            ] = 'Bearer '+ JwtService.getToken();
    },

    query(resource, params) {
        console.log(Vue.axios.defaults.baseURL)
        return Vue.axios.get(resource, params).catch(error => {
            throw new Error(`ApiService ${error}`);
        });
    },

    get(resource, slug = "") {
        console.log(Vue.axios.defaults.baseURL)
        return Vue.axios.get(`${resource}/${slug}`).catch(error => {
            throw new Error(`ApiService ${error}`);
        });
    },

    post(resource, params) {
        console.log(Vue.axios.defaults.baseURL)
      const a= Vue.axios.post(`${resource}`, params);
        return a;
    },

    update(resource, slug, params) {
        console.log(Vue.axios.defaults.baseURL)
        return Vue.axios.put(`${resource}/${slug}`, params);
    },

    put(resource, params) {
        console.log(Vue.axios.defaults.baseURL)
        return Vue.axios.put(`${resource}`, params);
    },

    delete(resource) {
        console.log(Vue.axios.defaults.baseURL)
        return Vue.axios.delete(resource).catch(error => {
            throw new Error(` ApiService ${error}`);
        });
    }
};

export default ApiService;

