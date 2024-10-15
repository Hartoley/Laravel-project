<template>
    <div class=" w-full overflow-x-auto">
    <table class="w-full bg-white border border-gray-300">
      <thead>
        <tr class="bg-[rgb(59,83,145)] text-white uppercase text-sm">
          <th class="py-3 px-4 text-left">Email</th>
          <th class="py-3 px-4 text-left">Surname</th>
          <th class="py-3 px-4 text-left">First Name</th>
          <th class="py-3 px-4 text-left">Residence</th>
          <th class="py-3 px-4 text-left">Marital Status</th>
          <th class="py-3 px-4 text-left">National ID</th>
          <th class="py-3 px-4 text-left">Travel Document</th>
          <th class="py-3 px-4 text-left">Journey Purpose</th>
          <th class="py-3 px-4 text-left">Arrival</th>
          <th class="py-3 px-4 text-left">Departure</th>
          <th class="py-3 px-4 text-left">Actions</th>
          <th class="py-3 px-4 text-left">Partners</th>

        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in visApplicants" :key="index" class="border-b text-[15px] text-white bg-blue-500 hover:bg-blue-200 hover:text-blue-500">
          <td class="py-2 px-2">{{ item.email }}</td>
          <td class="py-2 px-2">{{ item.surname }}</td>
          <td class="py-2 px-2">{{ item.first_name }}</td>
          <td class="py-2 px-2">{{ item.residence }}</td>
          <td class="py-2 px-2">{{ item.marital_status }}</td>
          <td class="py-2 px-2">{{ item.national_identity_number }}</td>
          <td class="py-2 px-2">{{ item.travel_document }}</td>
          <td class="py-2 px-2">{{ item.journey_purpose }}</td>
          <td class="py-2 px-2">{{ item.arrival }}</td>
          <td class="py-2 px-2">{{ item.departure }}</td>
          <td class="py-2 px-2 flex">
            <div v-if="item.status === 'P.lending'">
                <button @click="accept(item.id)" class="bg-red-500 hover:bg-red-600 text-white font-bold mx-1 rounded mt-4">Accept</button>
                <button @click="reject(item.id)" class="bg-red-500 hover:bg-red-600 text-white font-bold rounded mt-4">Delete</button>
            </div>
            <span v-else>{{ item.status }}</span>
        </td>
          <td class="py-2 px-2">
            <button @click="partner(item.transaction_id)" class="bg-blue-950 hover:bg-red-600 text-white font-bold rounded mt-4">Partners</button>
          </td>

        </tr>
      </tbody>
    </table>
  </div>

    <div class=" w-full overflow-x-auto">
    <table v-if="showCompanion" class="w-full bg-white border mt-2 border-gray-300">
      <thead>
        <tr class="bg-[rgb(59,83,145)] text-white uppercase text-sm">
          <th class="py-3 px-4 text-left">Name</th>
          <th class="py-3 px-4 text-left">Relationship</th>
          <th class="py-3 px-4 text-left">Status</th>
          <th class="py-3 px-4 text-left">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(items, index) in companions" :key="index" class="border-b text-[15px] text-white bg-blue-500 hover:bg-blue-200 hover:text-blue-500">
          <td class="py-2 px-2">{{ items.name }}</td>
          <td class="py-2 px-2">{{ items.relationship }}</td>
          <td class="py-2 px-2">{{ items.status }}</td>
          <td class="py-2 px-2 flex">
            <div v-if="items.status === 'Pending'">
                <button @click=" acceptCompanion(items.id)" class="bg-red-500 hover:bg-red-600 text-white font-bold mx-1 rounded mt-4">Accept</button>
                <button @click="rejectCompanion(items.id)" class="bg-red-500 hover:bg-red-600 text-white font-bold rounded mt-4">Decline</button>
            </div>
            <span v-else>{{ items.status }}</span>
        </td>

        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";



export default {
    data(){
        return{
            visApplicants: [],
            companions: [],
            showCompanion:false,
            
        }
    },
    mounted(){
        this.fetchApplications();
    },
    methods:{
        fetchApplications(){
            axios.get(route("all.fetch_application")).then((res)=>{
                // console.log(res);
                this.visApplicants = res.data.applications
                // console.log(this.visApplicants);
                status= this.visApplicants.status

                
                
            }).catch((err)=>{
                console.log(err);
            })
        },

        accept(id){
            console.log(id);
            axios.post(route("accept.applications"), { id: id })
                .then((response) => {
                    alert(response.data.message);
                    this.fetchApplications();
                    
                })
                .catch((error) => {
                    console.error('Error accepting application:', error);
                    alert('Failed to accept application.'); 
            });
        },

        reject(id){
            console.log(id);
            axios.post(route("reject.applications"), { id: id })
                .then((response) => {
                    alert(response.data.message);
                    this.fetchApplications();
                })
                .catch((error) => {
                    console.error('Error accepting application:', error);
                    alert('Failed to accept application.'); 
            });
        },

         rejectCompanion(id){
            console.log(id);
            axios.post(route("reject.companions"), { id: id })
                .then((response) => {
                    alert(response.data.message);
                    this.fetchApplications();
                    this.partner()
                })
                .catch((error) => {
                    console.error('Error accepting application:', error);
                    alert('Failed to accept application.'); 
            });
        },

         acceptCompanion(id){
            console.log(id);
            axios.post(route("accept.companions"), { id: id })
                .then((response) => {
                    alert(response.data.message);
                    this.fetchApplications();
                })
                .catch((error) => {
                    console.error('Error accepting application:', error);
                    alert('Failed to accept application.'); 
            });
        },

       partner(id) {
            console.log(id);
            axios.post(route("user.fetch_companion"), { id: id })
                .then((response) => {
                   if (Array.isArray(response.data.companions)) {
                            this.companions = [...this.companions, ...response.data.companions]; 
                            console.log(this.companions);
                            this.showCompanion = true;
                        }else {
                        alert('No companions found for this ID.');
                    }
                })
                .catch((error) => {
                    console.log(error);
                    alert('Failed to fetch companions.');
                });
        }



    }


}
</script>