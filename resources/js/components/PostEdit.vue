<template>
    <div class="container page" >
        <div class="d-flex justify-content-center"  v-if="isLoading" style="margin-top: 25em">
            <fa-icon :icon="['fas','spinner']" size="4x" spin></fa-icon>
        </div>
        <div v-else class="row">
            <div class="col-md-6 offset-md-3 col-xs-12">
                <h1 class="text-xs-center">Actualizeaza Postare</h1>
                <div>
                    <b-alert
                        :show="dismissCountDown"
                        dismissible
                        :variant='this.alertType'
                        @dismissed="dismissCountDown=0"
                        @dismiss-count-down="countDownChanged"
                    >
                        <p v-for="message in alertMessages">{{message}}</p>

                        <b-progress
                            variant="success"
                            :max="dismissSecs"
                            :value="dismissCountDown"
                            height="4px"
                        ></b-progress>
                    </b-alert>
                    <fieldset class="form-group">
                        <input
                            class="form-control form-control-lg"
                            type="text"
                            style="font-weight: bold"
                            v-model="this.article.titlu"
                            placeholder="Titlu"
                        />
                    </fieldset>
                    <fieldset class="form-group">
                <textarea
                    class="form-control form-control-lg"
                    rows="8"
                    v-model="this.article.descriere"
                    placeholder="Descriere"
                />
                    </fieldset>
                    <fieldset class="form-group">
                        <b-form-select v-model="selectedCategory" :options="categorii"></b-form-select>
                    </fieldset>

                    <button  class="btn btn-lg btn-primary pull-xs-right" @click="update()">
                        Actualizeaza Postare
                    </button>
                </div>
                <!-- Line break for logout button -->

            </div>
        </div>

    </div>


</template>

<script>
import {
    ARTICLE_EDIT,
    FETCH_CATEGORII,
    FETCH_CURRENTUSER_ARTICLE,
} from "../store/action.types";
import {mapGetters} from "vuex";
import store from "../store";

export default {
    name: "PostForm",
    data:()=>{
        return{
            selectedCategory:'',
            dismissSecs: 3,
            dismissCountDown: 0,
            showDismissibleAlert: false,
            alertMessages:[],
            alertType:''
        }
    },
        props: {
            slug: {
                type: String,
                required: true
            },
        selectedProperty:{default:0},
        isEdit:{default:true}
    },
    watch:{
        selectedCat:function (){
            console.log(this.selectedCat)
        }
    },
    beforeRouteEnter(to, from, next) {
        Promise.all([
            store.dispatch(FETCH_CURRENTUSER_ARTICLE, to.params.slug),
        ]).then(() => {
            next();
        });
    },
    methods:{
        update(){
            const payload={
                titlu:this.article.titlu,
                descriere:this.article.descriere,
                categorii_id:this.selectedCategory,
                id:this.article.id
            }

            this.$store.dispatch(ARTICLE_EDIT,payload).then(({ data }) => {
                if(data.success){
                    this.alertType='success';
                    this.dismissSecs=3;
                    this.showAlert(["Postarea a fost actualizata cu success"]);
                    this.sleep(3000).then(() => { this.$router.push({name:'UserPosts'}) });
                }
            })
        },
        fetchAllCategories(){
            this.$store.dispatch(FETCH_CATEGORII)
        },
        sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        },
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        showAlert(message) {
            this.alertMessages=message
            this.dismissCountDown = this.dismissSecs
        }
    },
    created() {
        this.fetchAllCategories();
        this.selectedCategory=this.selectedProperty;
    },
    computed:{
        ...mapGetters(['categorii','isLoading','article'])
    },

}
</script>

<style scoped>

</style>
