import axios from 'axios'
import router from "../../router";
const state={
    userData:{}
};
const getters={
    user:state=>{
        return state.userData
    }
};


export default{
    namespaced:true,
    state,
    getters,
    mutations:{

        setUserData(state, user) {
            state.userData = user;
        },
        logSomething(state,vr){
            console.log(vr)
        }

    },
    actions:{
        loginUser({commit},user){
            axios.post("/api/users/login",{
                email:user.email,
                password:user.password
            }).then(response=>{
                if(response.data.accessToken){
                    commit("setUserData", response.data.user);
                    localStorage.setItem("token",
                        response.data.accessToken);
                    router.push('/');
                }

            })
        },
        sendLogoutRequest({ commit }) {

            commit("setUserData", null);
            localStorage.removeItem("authToken");
        }
    }

}


