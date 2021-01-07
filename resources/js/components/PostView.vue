<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <h1 class="mt-4">{{this.article.titlu}}</h1>
                <div class="ftr d-flex align-items-center justify-content-start">
                    <div class="disable mr-4"><fa-icon :icon="['fas','user']" ></fa-icon> {{getName}}</div>
                    <div><fa-icon :icon="['fas','folder']" class="mr-1" ></fa-icon>{{article.categorie.nume}}</div>
                </div>
                <hr>
                    <p class="lead">{{this.article.descriere}}</p>
                        <hr>
                <div v-if="this.rated" class="d-flex justify-content-end" style="color: Green">
                   <h5>You have already rated this post.</h5>
                </div>

                <div class="card my-4" v-show="!this.rated">

                    <h6 class="card-header d-flex align-items-center justify-content-between">Leave a Rating:
                        <star-rating :item-size="20"
                                     :increment="0.5"
                                     :show-rating="false"
                                     v-model="ratingValue">

                        </star-rating>
                    </h6>

                    <div class="card-body">
                        <div>
                            <div class="form-group">
                                <textarea v-model="ratingText" class="form-control" rows="2"></textarea>
                            </div>
                            <button class="btn btn-primary" @click="submitRating">Submit</button>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column mt-2" v-if="!(this.ratings.length == 0)">
                 <div style="font-size: 1rem" class="mb-2">Ratings:</div>
                <user-rating v-for="rating in ratings"
                        :userRating="rating"
                ></user-rating>
                </div>
            </div>
        </div>

    </div>


</template>

<script>

import UserRating from "./UserRating";
import store from '../store'
import {FETCH_ARTICLE, FETCH_RATINGS, RATINGS_CREATE} from "../store/action.types";
import {mapGetters} from "vuex";
import {API_URL, IMAGE_PATH} from "../common/config";

export default {
name: "PostView",
    data(){
    return{
        ratingValue:0,
        ratingText:'',
        rated:''
    }
    },
    components:{
        UserRating
    },
    props: {
        slug: {
            type: String,
            required: true
        }
    },
    beforeRouteEnter(to, from, next) {
        Promise.all([
            store.dispatch(FETCH_ARTICLE, to.params.slug),
            store.dispatch(FETCH_RATINGS, to.params.slug)
        ]).then(() => {
            next();
        });
    },
methods:{
    getProfilePhoto(){
        return IMAGE_PATH+ this.article.utilizator.imagine
    },
    submitRating2(){
      this.rated=!this.rated;
    },
    submitRating(){
        const payload={
            text:this.ratingText,
            rating:this.ratingValue,
            slug:this.article.id
        }

        this.$store.dispatch(RATINGS_CREATE,payload).then(result=>{
            this.submitRating2();
        })
    }
},

    mounted() {
        this.rated=this.article.isRated;
    },

    computed:{
    ...mapGetters(['ratings','article']),
     getName(){
        return this.article.utilizator.nume+ ' ' + this.article.utilizator.prenume
     }
 }
}
</script>

<style scoped>

.disable{
    color: #888;
}
</style>
