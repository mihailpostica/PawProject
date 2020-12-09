import VueRouter from "vue-router";
import Vue from 'vue'
import Login from "./components/Login";
import Content from "./components/Content";
Vue.use(VueRouter);

export default new VueRouter({
        routes:[
            { path: '/', component:Content},
            {path:'/login',component: Login}
        ],
        mode:'history',
        linkActiveClass: "active"
    });

