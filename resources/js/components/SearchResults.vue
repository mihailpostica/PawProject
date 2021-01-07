<template>
    <div class="container">
        <ul class="list-group">
            <div class="d-flex justify-content-center"  v-if="isLoading" style="margin-top: 25em">
                <fa-icon :icon="['fas','spinner']" size="4x" spin></fa-icon>
            </div>
            <div v-else>
                <h2>Potrivire dupa titlu sau continut</h2>
                <user-post
                    v-for="(post, index) in postsMatches"
                    :post="post"
                    :is-search-query="true"
                    :key="post.titlu + index">
                </user-post>
                <h2>Potrivire dupa categorie</h2>
                <user-post
                    v-for="(post, index) in categoryMatches"
                    :post="post"
                    :is-search-query="true"
                    :key="post.titlu + index">
                </user-post>
            </div>
        </ul>

    </div>
</template>

<script>
import UserPost from "./UserPost";
import {mapGetters} from "vuex";
import ApiService from "../common/api.service";

export default {
    name: "PostList",
    components: {UserPost},
    data() {
        return {
            isLoading:true,
            postsMatches:[],
            categoryMatches:[],
        }
    },
    methods: {
        fetchSearchResults() {
        },
    },
    created() {
        const payload={
            query:this.$route.query.query
        }
       ApiService.post('posts/search',payload).then(({data})=>{
           let postsIdx=0;
           let categoryIdx=0;

          data.posts.forEach(element =>{
              if(element.type==='categorii'){
                  let postari=element.searchable.continut;
                postari.forEach(postElement=>{
                    postElement['categorie']={
                        id:element.searchable.id,
                        nume:element.searchable.nume
                    }
                    this.categoryMatches[categoryIdx++]=postElement;
                })
              }
              if(element.type==='continut'){
                  this.postsMatches[postsIdx++]=element.searchable;
                  }
          });
           this.isLoading=false;

        })
        this.fetchSearchResults();


    },
    computed:{
        ...mapGetters(['userPosts','isUserPostsLoading','isArticleLoading']),
        shouldSpin(){
       return false;
        }
    }

}
</script>

<style scoped>

</style>
