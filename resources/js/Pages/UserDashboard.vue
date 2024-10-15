<template> 
    <div  class="w-[90vw] bg-blue-500 text-sm h-[100vh]">
    <table class="w-[100%] bg-white text-[16px] border border-gray-300">
      <thead>
        <tr class="bg-[rgb(59,83,145)] w-[100%] text-white uppercase text-sm">
          <th class="py-3 px-4 text-left">Email</th>
          <th class="py-3 px-4 text-left">Surname</th>
          <th class="py-3 px-4 text-left">First Name</th>
          <th class="py-3 px-4 text-left">Residence</th>
          <th class="py-3 px-4 text-left">Marital Status</th>
          <th class="py-3 px-4 text-left">National ID</th>
          <!-- <th class="py-3 px-4 text-left">Travel Document</th> -->
          <th class="py-3 px-4 text-left">Journey Purpose</th>
          <th class="py-3 px-4 text-left">Arrival</th>
          <th class="py-3 px-4 text-left">Departure</th>
          <th class="py-3 px-4 text-left">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in user" :key="index" class="border-b bg-blue-500 text-white hover:bg-gray-100">
          <td class="py-2 px-4">{{ item.email }}</td>
          <td class="py-2 px-4">{{ item.surname }}</td>
          <td class="py-2 px-4">{{ item.first_name }}</td>
          <td class="py-2 px-4">{{ item.residence }}</td>
          <td class="py-2 px-4">{{ item.marital_status }}</td>
          <td class="py-2 px-4">{{ item.national_identity_number }}</td>
          <!-- <td class="py-2 px-4">{{ item.travel_document }}</td> -->
          <td class="py-2 px-4">{{ item.journey_purpose }}</td>
          <td class="py-2 px-4">{{ item.arrival }}</td>
          <td class="py-2 px-4">{{ item.departure }}</td>
          <td class="py-2 px-4">{{ item.status }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";
import Userlayout from "@/Layouts/Userlayout.vue";
import Header from "./Header.vue";

export default {
  layout: Userlayout,
    components: {
    Header,
  },
    data(){
      return {
          user:[],

        }
    },
    mounted(){
        this.fetchApplications();
    },
    methods:{
        fetchApplications(){
            axios.get(route("user.fetch_application")).then((res)=>{
              console.log(res);
                this.user= res.data.applications
            }).catch((err)=>{
                console.log(err);
            })
        }
    }
}
</script>