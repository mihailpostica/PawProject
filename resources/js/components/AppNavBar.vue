<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <router-link to="/"><a class="navbar-brand" >PAW</a> </router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto d-flex align-items-center">
                    <div>
                        <input type="text" placeholder="Search" v-model="query" v-on:keyup="search">
                    </div>

                        <router-link class="nav-item" tag="li" to="/" exact > <a class="nav-link">Home</a> </router-link>
                        <router-link class="nav-item" tag="li" to="/dash" v-show="isAuthenticated"> <a class="nav-link"> Dashboard</a></router-link>
                        <router-link class="nav-item" tag="li" to="/admin" v-show="isAuthenticated&&isAdmin"> <a class="nav-link">Admin</a></router-link>
                        <router-link class="nav-item" tag="li" to="/login" v-show="!isAuthenticated"> <a class="nav-link"> Login</a></router-link>
                        <li class="nav-item" v-show="isAuthenticated">
                        <a class="nav-link" href="#" v-show="isAuthenticated" @click="logOut" >Logout</a>
                        </li>

                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import {LOGOUT} from "../store/action.types";
export default {
    data() {
        return {
            query:''
        }
    },
name: "app-nav-bar",
    computed: {
        ...mapGetters(["currentUser", "isAuthenticated",'isAdmin']),
    },
methods:{
    logOut(){
        this.$store.dispatch(LOGOUT).then(() => {

        });
    },

    search(e){
        if (e.keyCode === 13) {
            this.$router.push({ path: 'search', query: { query: this.query }})
            }
}
}

}


</script>

<style scoped>

</style>
