<template>
    <li class="list-group-item d-flex align-items-center justify-content-sm-between flex-grow">
        <div class="d-flex flex-column container-fluid flex-grow">
            <div style="color:Red;font-weight: bold;">
                {{post.categorie.nume}}
            </div>
            <div style="font-weight: bold; font-size: 1.5rem">
               {{post.titlu}}
            </div>

            <div style="color:#989898">
                {{post.descriere}}
            </div>
        </div>
        <div class="d-flex  align-items-center justify-content-between">
            <button @click="clicked" class="button btn-link" style="padding-right: 1rem;border: none;background: none;">
                <fa-icon  :icon="['fa','trash-alt']"></fa-icon>
            </button>

            <router-link  :to="{ name: 'addEditPost', params: {post:this.post,selectedProperty:this.post.categorie.id} }">
                <fa-icon :icon="['fa','edit']"></fa-icon>
            </router-link>

        </div>
    </li>

</template>

<script>
import PostForm from "./PostForm";

export default {
    components:{
    },
    name: "UserPost",
    props:{
        post: {type: Object, required:true}
    },
    methods:{
        clicked(){
            this.$emit("showModal",this.post.id);
        }
    }

}
</script>

<style scoped>

button:focus { outline:0 !important; }
body {
    font-family: 'montserrat', sans-serif;
}


</style>
