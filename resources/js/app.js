import Vue from 'vue'
import axios from "axios";
import router from "./router";
import App from "./components/App";
import store from "./store"
require('./bootstrap');


axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response.status === 422) {
            store.commit("setErrors", error.response.data.errors);
        } else if (error.response.status === 401) {
            store.commit("auth/setUserData", null);
            localStorage.removeItem("authToken");
            router.push({ name: "Login" });
        } else {
            return Promise.reject(error);
        }
    }
);
axios.interceptors.request.use(function(config) {
    config.headers.common = {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
        "Content-Type": "application/json",
        Accept: "application/json"
    };

    return config;
});


const app = new Vue({
    el: '#app',
    components:{
        App
    },
    router,
    store
});
