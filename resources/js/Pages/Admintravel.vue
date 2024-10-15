<template>
   <Header></Header>
   <form @submit.prevent="createTour" enctype="multipart/form-data" class="max-w-md mt-[10vh] mx-auto p-4 pt-6 md:p-6 lg:p-12">
     <h1 class="text-3xl font-bold mb-4">Create a Tour</h1>
     <div>
       <div class="mb-4">
         <label for="image" class="block text-sm font-medium mb-2">Upload Image</label>
         <input type="file" @change="pickfile($event)" id="image" class="w-full p-2 pl-10 text-sm text-gray-700" />
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
         <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded" type="submit" >Create Tour</button>
       </div>
     </div>
    </form>
 </template>
 
 <script>
 import axios from 'axios';
import Header from './Header.vue';
 
 export default {
   components: {
      Header,
   },
   data() {
     return {
       tourName: '',
       tourDescription: '',
       price: '',
       destination: '',
       tourDate: '',
       img: null,
       tours: JSON.parse(localStorage.getItem('Tours')) || [],

     }
   },
   methods: {
      pickfile(e){
          console.log(e.target.files[0]);
          this.img = e.target.files[0]
          
      },
     createTour() {
      //  let tourDetail = {
      //    tour_name: this.tourName,
      //    tour_prices: this.price,
      //    tour_decs: this.tourDescription,
      //    destination: this.destination,
      //    tourDuration:this.tourDate,  
      //  }
      let formData= new FormData();
      formData.append('tour_name', this.tourName)
      formData.append('tour_prices', this.price)
      formData.append('tour_decs', this.tourDescription)
      formData.append('destination', this.destination)
      formData.append(' tourDuration', this.tourDate)
      formData.append('images', this.img)
      
       axios.post(route("tour.create"), formData).then((res)=>{
           console.log(res);
       }).catch((err)=>{
           console.log(err);
       })

       // const tourExist = this.tours.find(tour => tour.tour_name === tourDetail.tour_name);

       // if (tourExist) {
       //         alert('Tour already exists');
       //     } else {
       //         this.tours.push(tourDetail)
       //         localStorage.setItem('Tours', JSON.stringify(this.tours));
       //         alert('success')
       //     }

     }
   }
 }
 </script>