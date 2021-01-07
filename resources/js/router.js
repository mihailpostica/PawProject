import VueRouter from "vue-router";
import Vue from 'vue'
import Login from "./components/Login";
import Main from "./Views/Main";
import UserInformation from "./Views/UserInformation";
import DashBoard from "./Views/DashBoard";
import PostList from "./components/PostList";
import ModalConfirm from "./components/ModalConfirm";
import PostForm from "./components/PostForm";
import PostView from "./components/PostView";
import PostEdit from "./components/PostEdit";
import Admin from "./components/Admin";
import SearchResults from "./components/SearchResults";
Vue.use(VueRouter);

export default new VueRouter({
        routes:[
            { path: '/', component:Main, name:'home'},
            { path: '/search', component:SearchResults, name:'search'},
            { path: '/admin', component:Admin, name:'admin'},
            {path:'/login',component: Login,name:'login'},
            { path: '/user', component:UserInformation, name:'user'},
            {path:'/dash',component: DashBoard},
            {path: '/user/posts',component: PostList,name:'UserPosts'},
            {path:'/modal',component: ModalConfirm},
            {path:'/user/posts/edit/:slug',component:PostEdit, name: 'EditPost', props:true},
            {path:'/user/posts/new',component:PostForm, name: 'addEditPost', props:true},
            {
                component: PostView,
                name:'PostView',
                path: "/post/:slug",
                props:true
            }
        ],
        mode:'history',
        linkActiveClass: "active"
    });

