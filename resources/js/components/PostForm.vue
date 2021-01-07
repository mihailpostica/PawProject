<template>
        <div class="container page" >
            <div class="d-flex justify-content-center"  v-if="isLoading" style="margin-top: 25em">
                <fa-icon :icon="['fas','spinner']" size="4x" spin></fa-icon>
            </div>
            <div v-else class="row">
                <div class="col-md-6 offset-md-3 col-xs-12">
                    <h1 class="text-xs-center" v-show="!isEdit">Adauga Postare Noua</h1>
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
                                    v-model="post.titlu"
                                    placeholder="Titlu"
                                />
                            </fieldset>
                            <fieldset class="form-group">
                <textarea
                    class="form-control form-control-lg"
                    rows="8"
                    v-model="post.descriere"
                    placeholder="Descriere"
                />
                            </fieldset>
                            <fieldset class="form-group">
                                    <b-form-select v-model="selectedCategory" :options="categorii"></b-form-select>
                            </fieldset>

                            <button v-show="!isEdit" class="btn btn-lg btn-primary pull-xs-right" @click="save()">
                                Adauga Postare
                            </button>
                    </div>
                    <!-- Line break for logout button -->

                </div>
            </div>

        </div>


</template>

<script>
import { ARTICLE_PUBLISH, FETCH_CATEGORII} from "../store/action.types";
import {mapGetters} from "vuex";

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
    props:{
        post: {
            type: Object,
            default() {
                return {
                    titlu:'',
                    descriere:'',
                    id:''
                }
            }
        },
        selectedProperty:{default:0},
        isEdit:{default:true}
    },
    watch:{
    selectedCat:function (){
        console.log(this.selectedCat)
    }
    },
    methods:{
    save(){
        const payload={
            titlu:this.post.titlu,
            descriere:this.post.descriere,
            categorii_id:this.selectedCategory,
        }
        this.$store.dispatch(ARTICLE_PUBLISH,payload).then(({data})=>{
            console.log(data);
            if(data.success){
                this.alertType='success';
                this.dismissSecs=3;
                let array=[]
                array.push(data.message);
                this.showAlert(array);
                this.sleep(3000).then(() => { this.$router.push({name:'UserPosts'}) });
            }
        }).catch(error => {
            let alertMessages=[]
            error.response.data.errors.forEach(element =>{alertMessages.push(element)});
            console.log(alertMessages);
            this.alertType='danger';
            this.dismissSecs=5;
            this.showAlert(alertMessages);
        });
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
    ...mapGetters(['categorii','isLoading'])
    },

}
</script>

<style scoped>

</style>
