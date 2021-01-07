
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
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
            </div>
        </div>

        <div class="row justify-content-center " style="">
            <div class="col-md-8">

                <div class="d-flex justify-content-center"  v-if='this.isLoading' style="margin-top: 25em">
                    <fa-icon :icon="['fas','spinner']" size="4x" spin></fa-icon>
                </div>
                <div v-else class="card">
                <div class="login-box">
                    <div class="login-snip"> <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab" style="cursor: pointer" ref="logRef">Login</label> <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab" style="cursor: pointer">Sign Up</label>
                        <div class="login-space">

                            <div class="login">
                                <div class="group"> <label for="userLogin" class="label">Username</label> <input id="userLogin" type="text" class="input" placeholder="Enter your username" v-model="email"> </div>
                                <div class="group"> <label for="passLogin" class="label">Password</label> <input id="passLogin" type="password" class="input" data-type="password" placeholder="Enter your password" v-model="password"> </div>
                                <div class="group"> <input type="submit" class="button" value="Sign In" @click="onSubmit(email,password)" v-on:keyup="enter"> </div>
                                <div class="hr"></div>

                            </div>
                            <div class="sign-up-form">
                                <div class="group">  <input id="userRegister" type="text" class="input" placeholder="Username" v-model="username"> </div>
                                <div class="group">  <input id="nume" type="text" class="input" placeholder="Nume" v-model="nume"> </div>
                                <div class="group">  <input id="prenume" type="text" class="input" placeholder="Prenume" v-model="prenume"> </div>
                                <div class="group">  <input id="passRegister" type="password" class="input" data-type="password" placeholder="Parola" v-model="password"> </div>
                                <div class="group">  <input id="passRegisterConfirm" type="password" class="input" data-type="password" placeholder="Repeta parola" v-model="password_confirmation"> </div>
                                <div class="group">  <input id="emailRegister" type="text" class="input" placeholder="Adresa email" v-model="email"> </div>
                                <vue-multi-select
                                    name="maybe"
                                    placeholder="Alege Preferinte"
                                    v-model="value"
                                    :options="this.categorii"
                                    option-key="value"
                                    option-label="text"
                                    class="mb-3"
                                ></vue-multi-select>
                                <div class="group"> <input type="submit" class="button" value="Sign Up" @click="onRegisterSubmit"> </div>
                                <div class="hr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
import {mapGetters, mapState} from "vuex";
import VueMultiSelect from "vue-simple-multi-select";
import {FETCH_CATEGORII, LOGIN, REGISTER} from "../store/action.types";
import ApiService from "../common/api.service";
export default {
    data() {
        return {
            email: null,
            password: null,
            password_confirmation:null,
            nume:null,
            prenume:null,
            username:null,
            value:[],
            dismissSecs: 3,
            dismissCountDown: 0,
            showDismissibleAlert: false,
            alertMessages:[],
            alertType:''
        };
    },
    components:{
        VueMultiSelect
    },
    methods: {
        onSubmit(email, password) {
            this.$store
                .dispatch(LOGIN, { email, password })
                .then(() => {
                    console.log('should have pushed')
                    this.$router.push({ name: "home" })
                });
        },
        enter(e){
            if (e.keyCode === 13) {
                this.onSubmit(this.email,this.password)
            }
        },
        onRegisterSubmit() {
            let arr=[];
            let idx=0;
            this.value.forEach(function(v){arr[idx++]=v.value});
            ApiService.post('users/register',{
                email: this.email,
                password_confirmation:this.password_confirmation,
                nume:this.nume,
                prenume:this.prenume,
                password: this.password,
                username: this.username,
                preferinte:arr
            }).then(({data}) => {
                this.alertType='success';
                this.dismissSecs=3;
                let array=[]
                array.push('Registered successfully');
                this.showAlert(array);
                this.sleep(3000).then(() => {
                    const elem = this.$refs.logRef
                    elem.click() });
            }).
            catch(error => {
                let alertMessages=[]
                error.response.data.errors.forEach(element =>{alertMessages.push(element)});
                this.alertType='danger';
                this.dismissSecs=5;
                this.showAlert(alertMessages);
            })

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
    watch: {
        errori:function (newVal){
            if(Array.isArray(newVal)){
            let alertMessages=[]
            newVal.forEach(element =>{alertMessages.push(element)});
            this.alertType='danger';
            this.dismissSecs=5;
            this.showAlert(alertMessages);
        }

    },
    },
    computed: {
        ...mapState({
            errors: state => state.errors
        }),
        ...mapGetters(['categorii','errori','isLoading'])
    },
    created() {
            this.$store.dispatch(FETCH_CATEGORII)
    }

}

</script>

<style scoped>
body {
    margin: 0;
    color: #6a6f8c;
    background: #c8c8c8;
    font: 600 16px/18px 'Open Sans', sans-serif
}

.login-box {
    width: 100%;
    max-width: 525px;
    min-height: 670px;
    position: relative;
    box-shadow: 0 12px 15px 0 rgba(0, 0, 0, .24), 0 17px 50px 0 rgba(0, 0, 0, .19)
}
.wdth{
    max-width: 525px;
    padding: px 70px 50px 70px;
    width: 100%;
    padding-bottom: 5px;
    margin: 0 15px 20px 0;
}

.login-snip {
    width: 100%;
    height: 100%;
    position: absolute;
    padding: 95px 70px 50px 70px;
    background: rgba(255,255,255, 1)
}

.login-snip .login,
.login-snip .sign-up-form {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    position: absolute;
    transform: rotateY(180deg);
    backface-visibility: hidden;
    transition: all .4s linear
}

.login-snip .sign-in,
.login-snip .sign-up,
.login-space .group .check {
    display: none
}

.login-snip .tab,
.login-space .group .label,
.login-space .group .button {
    text-transform: uppercase
}

.login-snip .tab {
    font-size: 22px;
    margin-right: 15px;
    padding-bottom: 5px;
    margin: 0 15px 10px 0;
    display: inline-block;
    border-bottom: 2px solid transparent
}

.login-snip .sign-in:checked+.tab,
.login-snip .sign-up:checked+.tab {
    color: #000000;
    border-color: #1161ee;
    font-weight: bold;
}

.login-space {
    min-height: 345px;
    position: relative;
    perspective: 1000px;
    transform-style: preserve-3d
}

.login-space .group {
    margin-bottom: 15px
}

.login-space .group .label,
.login-space .group .input,
.login-space .group .button {
    width: 100%;
    color: #000000;
    display: block
}

.login-space .group .input,
.login-space .group .button {
    border: none;
    padding: 15px 20px;
    border-radius: 25px;
    background: rgba(236, 244, 255,1);

}

.login-space .group input[data-type="password"] {
    text-security: circle;
    -webkit-text-security: circle
}

.login-space .group .label {
    color: #000000;
    font-size: 12px
}

.login-space .group .button {
    background: #1161ee
}

.login-space .group label .icon {
    width: 15px;
    height: 15px;
    border-radius: 2px;
    position: relative;
    display: inline-block;
    background: rgba(255, 255, 255, .1)
}

.login-space .group label .icon:before,
.login-space .group label .icon:after {
    content: '';
    width: 10px;
    height: 2px;
    background: #fff;
    position: absolute;
    transition: all .2s ease-in-out 0s
}

.login-space .group label .icon:before {
    left: 3px;
    width: 5px;
    bottom: 6px;
    transform: scale(0) rotate(0)
}

.login-space .group label .icon:after {
    top: 6px;
    right: 0;
    transform: scale(0) rotate(0)
}

.login-space .group .check:checked+label {
    color: #000000;
    font-weight: bold;
}

.login-space .group .check:checked+label .icon {
    background: #1161ee
}

.login-space .group .check:checked+label .icon:before {
    transform: scale(1) rotate(45deg)
}

.login-space .group .check:checked+label .icon:after {
    transform: scale(1) rotate(-45deg)
}

.login-snip .sign-in:checked+.tab+.sign-up+.tab+.login-space .login {
    transform: rotate(0)
}

.login-snip .sign-up:checked+.tab+.login-space .sign-up-form {
    transform: rotate(0)
}

*,
:after,
:before {
    box-sizing: border-box
}

.clearfix:after,
.clearfix:before {
    content: '';
    display: table
}

.clearfix:after {
    clear: both;
    display: block
}

a {
    color: inherit;
    text-decoration: none
}

.hr {
    height: 2px;
    margin: 60px 0 50px 0;
    background: rgba(255, 255, 255, .2)
}

.foot {
    text-align: center
}

.card {
    width: 500px;
    left: 100px
}

::placeholder {
    color: #b3b3b3
}
</style>
