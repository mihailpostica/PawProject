<template>
<div class="container">
    <ul class="list-group">

        <div class="d-flex justify-content-center"  v-if="shouldSpin" style="margin-top: 25em">
            <fa-icon :icon="['fas','spinner']" size="4x" spin></fa-icon>
        </div>
        <div v-else>
        <user-post
            v-for="(post, index) in userPosts"
            :post="post"
            :key="post.titlu + index" @showModal="confirmDeletion($event)">
        </user-post>
        </div>
    </ul>

</div>
</template>

<script>
import Content from "./Content";
import {ARTICLE_DELETE, FETCH_USER_ARTICLES} from "../store/action.types";
import UserPost from "./UserPost";
import {mapGetters} from "vuex";
import PostForm from "./PostForm";

export default {
    name: "PostList",
    components: {Content,UserPost,PostForm},
    data() {
        return {
            boxTwo: '',
            selectedPost: '',

        }
    },
    watch:{
        boxTwo:function (){
            if(this.boxTwo){
                this.deletePost(this.selectedPost);
            }
        }
    },
    methods:{
        fetchUserArticles(){
            const payload={page:1};
            this.$store.dispatch(FETCH_USER_ARTICLES,payload);
        },
        confirmDeletion(postId){
            this.selectedPost=postId;
            this.showMsgBoxTwo();
        },
        deletePost(postId){
          this.$store.dispatch(ARTICLE_DELETE,postId).then(value => {
              const removeIndex =this.userPosts.map(item => item.id)
                  .indexOf(postId);
              ~removeIndex && this.userPosts.splice(removeIndex, 1);
          })
        },

        showMsgBoxTwo() {
            this.boxTwo = ''
            this.$bvModal.msgBoxConfirm('Sunteti sigur?', {
                size: 'sm',
                buttonSize: 'sm',
                okVariant: 'danger',
                okTitle: 'Da',
                cancelTitle: 'Nu',
                footerClass: 'p-2',
                hideHeaderClose: false,
                centered: true
                    })
                        .then(value => {
                            this.boxTwo = value
                        })
                        .catch(err => {
                            // An error occurred
                        })
                }
    },

    mounted() {
        this.fetchUserArticles();
    },
    computed:{
        ...mapGetters(['userPosts','isUserPostsLoading','isArticleLoading']),
        shouldSpin(){
            if(this.isUserPostsLoading){
                return true;
            }
            return this.isArticleLoading;
        }
    }
}
</script>

<style scoped>

</style>
