<template>
    <div class="container">
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
        <ul class="list-group">
            <li class="list-group-item d-flex align-items-center justify-content-sm-between flex-grow">
                <div>
                    <h3>Adauga domeniu</h3>
                </div>
                <input type="text" v-model="domeniu">
                <button @click="adauga">Adauga</button>
            </li>
        </ul>
    </div>
</template>

<script>



import {CREATE_CATEGORII} from "../store/action.types";

export default {

name: "Admin",
   data(){
    return{
    domeniu:"",
        dismissSecs: 3,
        dismissCountDown: 0,
        showDismissibleAlert: false,
        alertMessages:[],
        alertType:''
    }
   },
    methods:{
    adauga(){
      this.$store.dispatch(CREATE_CATEGORII,{nume:this.domeniu}).then(({data})=>{
          this.alertType='success';
       this.showAlert(data.message);
       this.sleep(3000).then(()=>{
           this.$router.push('/');
       })
        })

    },
        sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        },
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        showAlert(message) {
            this.alertMessages=[message];
            this.dismissCountDown = this.dismissSecs
        }
    }
}
</script>

<style scoped>

</style>
