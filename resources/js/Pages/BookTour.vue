<template>
<Header></Header>
<div class="bg-blue-500 mt-[10vh] px-[5vw] text-white">
    <div v-for="(tour, index) in tourDetails" :key="index" class="w-[100%] bg-white h-[120vh] flex ">
        <div class="w-[65%] h-[100%]">
            <img class="w-[100%] h-[100%]" src="https://i.pinimg.com/474x/c8/88/27/c8882734b7cf604e1942eb4fcb5d0bef.jpg" alt="">
            <!-- <img class="w-[100%] h-[100%]" :src="'storage/' + tour.images" alt=""> -->
        </div>
        <div  class="w-[35%] text-black">
            <div class="w-[100%] h-[10%] text-white flex px-5 flex-col  bg-blue-900">
                <p class="text-red-700 text-[1.5rem] font-bold">From:</p>
                <p class="pt-[0.5vw]" id="tours1">{{ tour.tour_name }}</p>
            </div>
            <div class="px-5 w-[100%] text-[1rem] text-gray-700 font-bold">
                <p class="pt-[0.5vw]" id="tours2">{{ tour.tour_decs }}</p>
                <p class="pt-[0.5vw]" id="tours1">{{ tour.tour_prices }}</p>
            
            </div>
            <button class="w-[100%] h-[10vh] text-white bg-black">
                BOOK TOUR NOW
            </button>
            <div class="flex flex-col gap-4 w-full px-5 py-5 ">
            <div class="flex space-x-4">
                <input v-model="first_name" type="text" placeholder="First Name*" class="border border-gray-400 px-4 py-2 rounded-md w-full" />
                <input v-model="surname" type="text" placeholder="Last Name" class="border border-gray-400 px-4 py-2 rounded-md w-full" />
            </div>
                <input v-model="email" type="email" placeholder="Email Address*" class="border border-gray-400 px-4 py-2 rounded-md" />
                <input v-model="mobileNum" type="tel" placeholder="Mobile Number*" class="border border-gray-400 px-4 py-2 rounded-md" />
                <input v-model="tourName" type="text" readonly placeholder="Name Of Tour You Are Booking*" class="border border-gray-400 px-4 py-2 rounded-md" />
                <textarea v-model="instructions" placeholder="Additional Instructions" class="border border-gray-400 px-4 py-2 rounded-md resize-none" rows="4"></textarea>
                <button @click="bookTour"class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                    BOOK NOW
                </button>
            </div>
        </div>
    </div>
</div>
<Footer></Footer>
</template>
<script>
import axios from 'axios';
import Header from './Header.vue';
import Footer from './Footer.vue';
export default {
    props: {
        email: String,
        id: {
            type: [String, Number],
            required: true
        },
       
    },
    components: {
        Header
    },
    data() {
        return {
            tourDetails: [],
            first_name: '',
            surname:'',
            email: this.email,
            tourName: '',
            mobileNum: '',
            instructions: '',
            mainTour: {},
            
      }  
    },
    methods: {
        fetchTourDetails() {
            axios.post(route("fetch.tour"), {id: this.id}).then((res)=>{
                this.tourDetails=[...this.tourDetails, ...res.data.applications];
                // console.log(this.tourDetails);
                this.mainTour = this.tourDetails[0];
                console.log(this.mainTour);
                this.tourName = this.mainTour.tour_name;
                
            }).catch((err) => {
                console.log(err);
                
            })
        },

        bookTour() {
           let travelPlan = {
                first_name: this.first_name,
                surname: this.surname,
                email: this.email,
                tourName: this.tourName,
                mobileNum: this.mobileNum,
                instructions:this.instructions
            }

            axios.post(route("travelPlan.create"),travelPlan).then((res) => {
                console.log(travelPlan);  
                console.log(res);
                alert("Success")
                window.location.href = `/makePayment/${this.id}`

                
                
            }).catch((err) => {
                alert("Failed")
                console.log(err);
                
            })
        }
    },
       mounted() {
           console.log("Tour ID:", this.id);
            this.fetchTourDetails()
            

        
    }
}

</script>