<template>
    <li class="list-group-item d-flex align-items-center justify-content-sm-between flex-grow">
        <div class="d-flex flex-column container-fluid flex-grow">
            <div class="d-flex flex-row justify-content-start align-items-center" >
            <div  class="d-flex align-items-center justify-content-start mb-1">
                <div><fa-icon :icon="['fas','folder']"  style="color:#989898" class="mr-1" ></fa-icon>{{post.categorie.nume}}</div>
                <div v-if="isSearchQuery" class="disable ml-2"><fa-icon :icon="['fas','user']" style="color:#989898"></fa-icon> {{getName}}</div>
            </div>
            </div>
            <div v-if="!isSearchQuery" style="font-weight: bold; font-size: 1.5rem">
               {{post.titlu}}
            </div>
            <router-link v-if="isSearchQuery" :to="articleLink" style="font-weight:bold;margin-left=1rem">
                <h2 class="card-title">{{post.titlu}}</h2>
            </router-link>

            <div v-if="!isSearchQuery" style="color:#989898">
                {{post.descriere}}
            </div>

        </div>

        <div v-if="!isSearchQuery" class="d-flex  align-items-center justify-content-between">
            <button @click="clicked" class="button btn-link" style="padding-right: 1rem;border: none;background: none;">
                <fa-icon  :icon="['fa','trash-alt']"></fa-icon>
            </button>
            <router-link :to="articleEditLink">
                <fa-icon :icon="['fa','edit']"></fa-icon>
            </router-link>

        </div>
    </li>

</template>

<script>

export default {
    components:{
    },
    name: "UserPost",
    props:{
        post: {type: Object, required:true},
        isSearchQuery:false
    },
    methods:{
        clicked(){
            this.$emit("showModal",this.post.id);
        }
    },
    computed:{
        articleEditLink() {
            return {
                name: "EditPost",
                params: {
                    slug: this.post.id.toString()
                }
            }
        },
        getName(){
            return this.post.utilizator.nume+ ' ' + this.post.utilizator.prenume
        },
        articleLink() {
            return {
                name: "EditPost",
                params: {
                    slug: this.post.id.toString()
                }
            }
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
