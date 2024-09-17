<template>
    <h1>Welcome to my Dashboard</h1>
</template>

<script>
import axios from "axios";
import UserLayout from "../Layouts/UserLayout.vue";

export default {
    layout: UserLayout,
    data(){
        return{

        }
    },
    mounted(){
        this.fetchApplications();
    },
    methods:{
        fetchApplications(){
            axios.get(route("user.fetch_application")).then((res)=>{
                console.log(res);
            }).catch((err)=>{
                console.log(err);
            })
        }
    }
}
</script>