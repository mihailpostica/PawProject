import VueRouter from "vue-router";
import Vue from 'vue'
import Login from "./components/Login";
import Main from "./Views/Main";
import UserInformation from "./Views/UserInformation";
import UploadTest from "./Views/UploadTest";
import DashBoard from "./Views/DashBoard";
import PostList from "./components/PostList";
import ModalConfirm from "./components/ModalConfirm";
import PostForm from "./components/PostForm";
import PostView from "./components/PostView";
Vue.use(VueRouter);

export default new VueRouter({
        routes:[
            { path: '/', component:Main, name:'home'},
            {path:'/login',component: Login,name:'login'},
            { path: '/user', component:UserInformation, name:'user'},
            {path:'/upload',component: UploadTest},
            {path:'/dash',component: DashBoard},
            {path: '/user/posts',component: PostList,name:'UserPosts'},
            {path:'/modal',component: ModalConfirm},
            {path:'/user/posts/edit',component:PostForm, name: 'addEditPost', props:true},
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

