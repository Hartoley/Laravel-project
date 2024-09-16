<template>
    <Header>
     
    </Header>
 
    <div class=" w-full bg-red-200 h-[auto] m-[20px] ">
   <table class="w-3/4 bg-pink-200 h-[auto] m-[20px] shadow-md rounded-lg border border-gray-200">
     <thead class="text-left"> <tr>
         <th class="w-[50px] h-[40px] bg-gray-300 px-3 py-2">S/N</th> 
         <th class="bg-gray-300 px-3 py-2">Tour name</th>
         <th class="bg-gray-300 px-3 py-2">Tour Description</th>
         <th class="bg-gray-300 px-3 py-2">Price</th>
         <th  class="bg-gray-300 w-[20px] px-3 py-2">Destination</th>
         <th  class="bg-gray-300 w-[20px] px-3 py-2">More</th>
        
       </tr>
     </thead>
     <tbody class="text-left"> <tr v-for="(tour, index) in tours" class="hover:bg-gray-100 border-b border-gray-200"> 
       <td class="px-3 py-2">{{ index + 1 }}</td>
         <td class="px-3 py-2">{{ tour.tour_name}}</td>
         <td class="px-3 py-2">{{ tour.tour_decs }}</td>
         <td class="px-3 py-2">{{ Number(tour.tour_prices).toLocaleString() }}</td>
         <td class="px-3 py-2">{{ tour.destination }}</td>
         <td class="px-3 py-2">
          <a href="">More</a>

        </td>
        
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
          tours: [],
          
          
       }
    },
    methods:{
    fetching(){
        axios.get(route("tour.fetch")).then((res)=>{
          console.log(res);
          this.tours= res.data
          
        }).catch((err)=>{
            console.log(err);

        })
      }
   },
   mounted(){
      this.fetching()
   }
  };
  </script>