<template>
    <section >
        <div class="d-flex justify-content-center"  v-if="isLoading ||isRatings" style="margin-top: 25em">
            <fa-icon :icon="['fas','spinner']" size="4x" spin></fa-icon>
        </div>
        <div v-else>
            <div class="container mx-auto">
                <div class="row mx-auto">
                    <Post
                        v-for="(post, index) in posts"
                        :post="post"
                        :key="post.titlu + index"
                    />
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Post from "../Components/Content";
import {mapGetters} from "vuex";
import Content from "../components/Content";
import {FETCH_ARTICLES, FETCH_AUTH_ARTICLES} from "../store/action.types";
import DashBoard from "./DashBoard";
import PostForm from "../components/PostForm";
import PostView from "../components/PostView";

export default {
    components:{
        Content,
        Post,
        DashBoard,
        PostForm,
        PostView
    },
    methods:{
      fetchAllArticles(){
          if(this.isAuthenticated){
            this.$store.dispatch(FETCH_AUTH_ARTICLES)
          }else{
              this.$store.dispatch(FETCH_ARTICLES)
          }
      },
    },
    mounted() {
        this.fetchAllArticles();
    },
    computed:{
        ...mapGetters(["posts","isLoading",'isAuthenticated','isArticleLoading','isRatings'])
    },
    name: "Main"
}
</script>

<style scoped>

</style>
