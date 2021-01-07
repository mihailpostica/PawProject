<template>
    <div class="container" >
        <div class="row align-items-center" style="margin-top: 15rem">
            <div class="col-lg-4 mb-4">
                <router-link to="/user/posts" class="link">
                    <div class="card">
                        <div class="d-flex justify-content-center">
                            <fa-icon :icon="['fas','edit']" size="10x"></fa-icon>
                        </div>
                        <div class="card-body>
                            <div d-flex justify-content-center " style="padding: 2rem;font-weight: bold;font-size: 150% ">
                            Administreaza Postari
                        </div>
                    </div>
                </router-link>

            </div>

            <div class="col-lg-4 mb-4">
               <router-link to="/user" class="link">
                   <div class="card">
                    <div class="d-flex justify-content-center">
                        <fa-icon :icon="['fas','user-edit']" size="10x"></fa-icon>
                    </div>
                    <div class="card-body d-flex justify-content-center
                       <div d-flex justify-content-center " style="padding: 2rem;font-weight: bold;font-size: 150% ">
                        Editeaza Profil Personal
                    </div>
                </div>
               </router-link>
            </div>

            <div class="col-lg-4 mb-4">
                <router-link :to="{ name: 'addEditPost', params: {isEdit: false } }" class="link">
                    <div class="card">
                        <div class="d-flex justify-content-center" >
                            <fa-icon :icon="['fas','plus-square']" size="10x"></fa-icon>
                        </div>
                        <div class="card-body d-flex justify-content-center
                        <div d-flex justify-content-center " style="padding: 2rem;font-weight: bold;font-size: 150% ">
                            Adauga Postare
                        </div>
                    </div>
                </router-link>
            </div>

        </div>
    </div>



</template>

<script>
import PostList from "../components/PostList";
import UserInformation from "./UserInformation";
export default {
name: "DashBoard",
    methods:{

        },
    components:{
        PostList,
        UserInformation
    }
    }

</script>

<style scoped>
.card{
    border-radius: 4px;
    background: #fff;
    box-shadow: 0 6px 10px rgba(0,0,0,.08), 0 0 6px rgba(0,0,0,.05);
    transition: .3s transform cubic-bezier(.155,1.105,.295,1.12),.3s box-shadow,.3s -webkit-transform cubic-bezier(.155,1.105,.295,1.12);
    cursor: pointer;
    padding-bottom: 3rem;
    padding-top: 3rem;
}
.link{
    color: black;
}

.card:hover{
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
}

</style>
