import Vue from 'vue'
import router from "./router";
import store from "./store"
import ApiService from "./common/api.service";
require('./bootstrap');
import {library} from "@fortawesome/fontawesome-svg-core";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {
    faEdit,
    faFolder,
    faHeart,
    faPlusSquare,
    faTrashAlt,
    faUser,
    faUserEdit
} from "@fortawesome/free-solid-svg-icons";
import {faCalendarAlt, faClock} from "@fortawesome/free-regular-svg-icons";
import {faSpinner} from "@fortawesome/free-solid-svg-icons";
import Main from "./Views/Main";
import {getToken} from "./common/auth.service";
import {CHECK_AUTH} from "./store/action.types";
import {StarRating} from 'vue-rate-it';
Vue.component("fa-icon",FontAwesomeIcon);
library.add(faHeart,faCalendarAlt,faSpinner,faEdit,faUserEdit,faPlusSquare,faTrashAlt,faUser,faFolder,faClock)
ApiService.init();
Vue.component('navbar', require('./components/AppNavBar').default);

import { BootstrapVue} from 'bootstrap-vue'
import {mapGetters} from "vuex";
Vue.use(BootstrapVue)
Vue.component('star-rating', StarRating);
const token = getToken();
if (token) {
    axios.defaults.headers.common['Authorization'] ='Bearer '+ token
};

router.beforeEach((to, from, next) => {
        Promise.all([store.dispatch(CHECK_AUTH)]).then((data) => {
            next();
        })
    }
);


const app = new Vue({
    el: '#app',
    components:{
        Main,
    },
    computed:{
      ...mapGetters(["isAuthenticated"])
    },
    router,
    store
});
