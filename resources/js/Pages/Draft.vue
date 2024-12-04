<template>
    <Header>
     
    </Header>
 
  
 <h1>Welcome to my Dashboard</h1>
    <div class=" w-full overflow-x-auto">
    <table class="w-full bg-white border border-gray-300">
      <thead>
        <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
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
          <th class="py-3 px-4 text-left">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in visApplicants" :key="index" class="border-b text-[15px] hover:bg-gray-100">
          <td class="py-2 px-4">{{ item.email }}</td>
          <td class="py-2 px-4">{{ item.surname }}</td>
          <td class="py-2 px-4">{{ item.first_name }}</td>
          <td class="py-2 px-4">{{ item.residence }}</td>
          <td class="py-2 px-4">{{ item.marital_status }}</td>
          <td class="py-2 px-4">{{ item.national_identity_number }}</td>
          <td class="py-2 px-4">{{ item.travel_document }}</td>
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
  import Header from './Header.vue';
  
  export default {
    components: {
      Header,
    },
    data(){
       return{
        visApplicants:[],
          tours: [],
         companions: [],
selectedVisitor: null,          
          
       }
    },
    methods: {
     openVisitorModal(visitor) {
      this.selectedVisitor = visitor;
    },
    // Close the modal
    closeVisitorModal() {
      this.selectedVisitor = null;
    },
    
    fetching(){
        axios.get(route("tour.fetch")).then((res)=>{
          console.log(res);
          this.tours= res.data
          
        }).catch((err)=>{
            console.log(err);

        })
      },
      fetchingCompanions(){
        axios.get(route("fetch.Companions")).then((res)=>{
          console.log(res);
          this.companions= res.data
          
        }).catch((err)=>{
            console.log(err);

        })
      },

      fetchApplications(){
            axios.get(route("user.fetch_application")).then((res)=>{
                console.log(res);
                this.visApplicants = res.data.applications
                console.log(this.visApplicants);
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
        }
   },
   mounted(){
      this.fetching()
      this.fetchApplications();
      this.fetchingCompanions();
   }
  };
  </script>