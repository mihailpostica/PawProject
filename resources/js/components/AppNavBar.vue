<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <router-link to="/"><a class="navbar-brand" >PAW</a> </router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">

                        <router-link class="nav-item" tag="li" to="/" exact > <a class="nav-link">Home</a> </router-link>
                        <router-link class="nav-item" tag="li" to="/Login" v-show="user"> <a class="nav-link"> My Posts</a></router-link>
                        <router-link class="nav-item" tag="li" to="/Login" v-show="!user"> <a class="nav-link"> Login</a></router-link>

                        <li class="nav-item" v-show="user">
                        <a class="nav-link" href="#" @click="logout">Logout</a>
                        </li>


                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
name: "app-nav-bar",
    computed: {
        ...mapGetters("CurrentUser", ["user"])
    },
    methods:{
    ...mapActions("CurrentUser",["sendLogoutRequest"]),

        logout(){
        this.sendLogoutRequest();
            this.$router.push("/");
        }
    }
}
</script>

<style scoped>

</style>
