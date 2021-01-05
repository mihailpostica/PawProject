<template>
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div style="margin-bottom: 1rem" class="d-flex justify-content-between align-items-center">
                                <router-link  to="/Login"> <button class="numberCircle" style="color: white; background: #51ADC4 " @mouseover="mouseOver" @mouseleave="mouseLeave" :class="{example_b:this.hover}"  > {{post.categorie.nume}}</button></router-link>
                                <span style="color:#989898"><fa-icon :icon="['far','clock']" style="margin-right: 1px"></fa-icon>{{getdate}}</span>
                            </div>
                            <router-link :to="articleLink" style="color: #1b1e21; font-weight:bold">
                                <h2 class="card-title">{{post.titlu}}</h2>
                            </router-link>
                            <p class="card-text" style="margin-top: 1rem; margin-bottom:2rem;color:#989898" >{{displayData(post.descriere)}}</p>
                            <div class="ftr d-flex justify-content-between">
                                <div class="author">
                                    <a href="#"> <img v-bind:src="getProfilePhoto()" alt="" class="avatar img-raised"> <span>{{getFullName}}</span> </a>
                                </div>
                                <star-rating :item-size="10"
                                             :show-rating="false"
                                             :read-only='true'
                                             v-model="this.getRating"
                                >
                                </star-rating>
                            </div>
                        </div>
                    </div>
                </div>
</template>

<script>
import moment from 'moment';
import {IMAGE_PATH} from "../common/config";
export default {

    data:()=>{
        return{
            hover:false,
        }
    },
    methods:{
        getProfilePhoto(){
            return IMAGE_PATH+this.post.utilizator.imagine
        },

        displayData(textData){
            if (textData.length >100){
                return textData.substring(0,100)
            }else {
                return textData
            }
        },
        mouseOver: function(){
            this.hover=true
        },
        mouseLeave:function(){
            this.hover=false;
        },

    },
    props:{
        post: {type: Object, required:true}
    },
    computed:{
        getFullName(){
            return (this.post.utilizator.nume + ' ' + this.post.utilizator.prenume);
        },
        getRating(){
          return this.post.avgRating;
        },
        getdate(){
            return moment(this.post.data).fromNow()
        },

            articleLink() {
                return {
                    name: "PostView",
                    params: {
                        slug: this.post.id.toString()
                    }
            }
        }
    }
}


</script>

<style scoped>
#header {
    background: url(https://images.unsplash.com/photo-1415795854641-f4a487a0fdc8?ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80) center center / cover no-repeat ;
}
.card .ftr {
    margin-top: 15px;
}

.card .ftr div {
    display: inline-block;
}

.card .ftr .author {
    color: #888;
}
.card .author .avatar {
    width: 36px;
    height: 36px;
    overflow: hidden;
    border-radius: 50%;
    margin-right: 5px;
}
.card{
    border-radius: 4px;
    background: #fff;
    box-shadow: 0 6px 10px rgba(0,0,0,.08), 0 0 6px rgba(0,0,0,.05);
    transition: .3s transform cubic-bezier(.155,1.105,.295,1.12),.3s box-shadow,.3s -webkit-transform cubic-bezier(.155,1.105,.295,1.12);
}

.card .author a {
    color: #333;
    text-decoration: none;
}

.card .author a .ripple-cont {
    display: none;
}
.numberCircle {
    border-radius: 35px;
    -moz-border-radius: 35px;
    -webkit-border-radius: 35px;
    border: 1px transparent;
    padding-left: 30%;
    padding-right: 30%;
}

.example_b {
    text-shadow: 100px 100px 100px rgba(240, 255, 255, 1);
    -webkit-box-shadow: 0px 5px 40px -10px rgba(0,0,0,0.57);
    -moz-box-shadow: 0px 5px 40px -10px rgba(0,0,0,0.57);
    transition: all 0.4s ease 0s;
    font-size:102%;
}
.card:hover{
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
}
</style>
<style>
.numberCircle {
    border-radius: 35px;
    -moz-border-radius: 35px;
    -webkit-border-radius: 35px;
    border: 1px transparent;
    padding-left: 30%;
    padding-right: 30%;
}
</style>

