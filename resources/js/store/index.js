import Vue from "vue";
import Vuex from "vuex";
import auth from "./modules/CurrentUser";
import Home from "./modules/Home";
import Posts from "./modules/Posts";
import Article from "./modules/Article";
Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        namespaced: true,
        auth,
        Home,
        Posts,
        Article
    }
});
