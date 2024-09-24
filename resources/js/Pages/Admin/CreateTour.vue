<template>
    <Header></Header>
    <div class="max-w-md mx-auto p-4 pt-6 md:p-6 lg:p-12">
      <h1 class="text-3xl font-bold mb-4">Create a Tour</h1>
      <form @submit.prevent="createTour" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="image" class="block text-sm font-medium mb-2">Upload Image</label>
          <input @change="pickFile($event)" type="file" id="image" class="w-full p-2 pl-10 text-sm text-gray-700" />
        </div>
        <div class="mb-4">
          <label for="tour-name" class="block text-sm font-medium mb-2">Tour Name</label>
          <input type="text" id="tour-name" v-model="tourName" class="w-full p-2 pl-10 text-sm text-gray-700" />
        </div>
        <div class="mb-4">
          <label for="tour-description" class="block text-sm font-medium mb-2">Tour Description</label>
          <input type="text" id="tour-description" v-model="tourDescription" class="w-full p-2 pl-10 text-sm text-gray-700" />
        </div>
        <div class="mb-4">
          <label for="price" class="block text-sm font-medium mb-2">Price</label>
          <input type="text" id="price" v-model="price" class="w-full p-2 pl-10 text-sm text-gray-700" />
        </div>
        <div class="mb-4">
          <label for="destination" class="block text-sm font-medium mb-2">Destination</label>
          <input type="text" id="destination" v-model="destination" class="w-full p-2 pl-10 text-sm text-gray-700" />
        </div>
        <div class="mb-4">
          <label for="tour-date" class="block text-sm font-medium mb-2">Tour Duration</label>
          <input type="text" id="tour-date" v-model="tourDate" class="w-full p-2 pl-10 text-sm text-gray-700" />
        </div>
        <div class="flex justify-end">
          <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">Create Tour</button>
        </div>
      </form>
    </div>
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
  import axios from 'axios';
  import Header from '../Header.vue';
  
  export default {
    components: {
      Header
    },
    data() {
      return {
        tourName: '',
        tourDescription: '',
        price: '',
        destination: '',
        tourDuration:'',
        tourDate: '',
        img: null,
        tours: [],
       

      }
    },
    methods: {
      pickFile(e){
        this.img = e.target.files[0];
      },
      createTour() {
        // let data = {
        //   tour_name: this.tourName,
        //   tour_prices: this.price,
        //   tour_decs: this.tourDescription,
        //   destination: this.destination,
        //   tourDuration:this.tourDate, 
        //   duration:this.duration 

        // }
        let formData = new FormData();
        formData.append("tour_name", this.tourName)
        formData.append("tour_prices", this.price)
        formData.append("tour_decs", this.tourDescription)
        formData.append("destination", this.destination)
        formData.append("tourDuration", this.tourDate)
        formData.append("tourImg", this.img)

        axios.post(route("tour.create"), formData).then((res)=>{
            console.log(res);
            this.fetching();
        }).catch((err)=>{
            console.log(err);
        })


      },

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
  }
  </script>