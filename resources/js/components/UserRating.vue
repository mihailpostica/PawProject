<template>
    <div class="d-flex mb-4 flex-column rounded" style="background: 	#F5F5F5">

        <div class="author d-flex align-items-center" >
            <img v-bind:src="getProfilePhoto()" alt="" class="avatar img-raised">
            <span style="font-weight: bold">{{this.getName()}}</span>
        </div>

        <div class="media-body" style="margin-left:2rem">
            <star-rating :item-size="12"
                         :increment="0.5"
                         :show-rating="false"
                         :read-only='true'
            v-model="decimalRating">
            </star-rating>
            <div>
               {{this.userRating.descriere}}
            </div>

        </div>

    </div>
</template>

<script>
export default {
name: "UserRating",
    data() {
        return {
            decimalRating:''
        }
    },
    methods:{
        getProfilePhoto(){
            return 'http://localhost:8000/storage/'+ this.userRating.utilizator.imagine
        },
       getName(){

            return this.userRating.utilizator.nume+ ' ' +this.userRating.utilizator.prenume
       }

},
    props:{
        userRating:{
            type:Object,
            required: true
        },
    },
    created() {
        this.decimalRating=parseFloat(this.userRating.rating)
    }
}
</script>

<style scoped>
.author .avatar {
    width: 36px;
    height: 36px;
    overflow: hidden;
    border-radius: 50%;
    margin-right: 5px;
}
.ftr{
    margin-top: 15px;
    display: inline-block;
    color: #888;
}
.rounded{
    border-radius: 35px;
    -moz-border-radius: 35px;
    -webkit-border-radius: 35px;
}
</style>
