<template>

    <div  class="container col-lg-4">
        <div class="d-flex justify-content-center"  v-if="this.loadingUser" style="margin-top: 25em">
            <fa-icon :icon="['fas','spinner']" size="4x" spin></fa-icon>
        </div>
            <div v-else class="card" v-show="this.imageLoaded">
                <div class="d-flex justify-content-center">
                <div class="col-lg-8 mb-4 d-flex flex-column justify-content-center">
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
                <img :src="this.profilePicture" class="card-img avatar" v-if="this.profilePicture!=null" @load="imageLoaded=true" />
                    <div class="d-flex justify-content-center">
                    <button class="btn btn-primary btn-sm col-lg-4 mb-3" id="pick-avatar">Schimba imaginea</button>

                    <avatar-cropper
                        trigger="#pick-avatar"
                        :upload-url=this.imageUploadLink
                        upload-form-name="image"
                        :upload-headers='this.uploadHeader'
                        :withCredentials=true
                        :labels='this.options'
                        @uploaded="this.handleUploaded"
                                />
                    </div>

                    <div class="d-flex justify-content-center flex-column">
                    <input  v-model="currentUser.prenume" class="mt-4 wdth"  type="text"  placeholder="Prenume" >
                    <input  v-model="currentUser.nume" type="text" class="mt-4 wdth"  placeholder="Nume">
                    <div class="mt-4 d-flex justify-content-center flex-column" >
                        <vue-multi-select
                            name="maybe"
                            placeholder="Alege Preferinte"
                            v-model="value"
                            :options="this.categorii"
                            option-key="value"
                            option-label="text"
                            class="wdth"
                        ></vue-multi-select>
                    <button class="mt-4 btn btn-secondary btn-sm  mb-5 wdth" @click="this.updateSettings">Salveaza</button>
                    </div>
                    </div>
                </div>
            </div>
            </div>
    </div>

</template>

<script>
import { mapGetters } from "vuex";
import { mapState } from 'vuex';
import {FETCH_CATEGORII, UPDATE_USER} from "../store/action.types";
import AvatarCropper from "vue-avatar-cropper";
import {getToken} from "../common/auth.service";
import {IMAGE_PATH,API_URL} from "../common/config";
import VueMultiSelect from "vue-simple-multi-select";
import {SET_AUTH, SET_USER} from "../store/mutations.type";
export default {
    name: "Settings",
        data:()=>({
            imageLoaded:'',
            options:{
                submit:'ok',
                cancel:'cancel'
            },
            uploadHeader:{
                Authorization:'Bearer '+ getToken()
            },
            dismissSecs: 3,
            dismissCountDown: 0,
            showDismissibleAlert: false,
            alertMessages:[],
            alertType:'',
            value: [],
        }),
components:{
     AvatarCropper,VueMultiSelect
},
    mounted() {
        this.$store.dispatch(FETCH_CATEGORII)
    },

    computed: {
        ...mapGetters(["currentUser",'preferinte','categorii','loadingUser']),
        ...mapState(['isUserLoading']),
        fullName() {
            return this.currentUser.nume + ' ' + this.currentUser.prenume;
        },
        imageUploadLink(){
            return API_URL+"/posts/upload"
        },
        profilePicture(){
                return IMAGE_PATH+this.currentUser.imagine
            },


    },


    methods: {
        updateSettings() {
            let arr=[];
            let idx=0;
            this.value.forEach(function(v){arr[idx++]=v.value});
            let payload={
                nume:this.currentUser.nume,
                prenume:this.currentUser.prenume,
                preferinte:arr
            }
            this.$store.dispatch(UPDATE_USER, payload).then(() => {
                this.showAlert(["Informatia a fost actualizata cu success"])
                this.sleep(3000).then(()=>{
                    this.$router.push({ name: "home" });
                })

            });
        },
        sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        },
        handleUploaded(resp) {
            this.currentUser.imagine= resp.image;
        },
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        showAlert(message) {
            this.alertMessages=message
            this.dismissCountDown = this.dismissSecs
        }



    }
};
</script>

<style scoped>

.avatar {
    width: 160px;
    border-radius: 6px;
    display: block;
    margin: 20px auto;
}
.wdth{
    height: 2.5rem;
}
</style>
