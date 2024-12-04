<template>
  <div>
    <Header>
    </Header>

    <div class="max-w-3xl flex items-center justify-center flex-col border-[0.5px] border-[#314b87] mx-auto py-12 px-4 sm:px-6 mt-[12vw]  mb-[2vw] lg:px-8">
      <h2 class="text-3xl font-extrabold text-gray-900">Visa Application Form</h2>

      <form @submit.prevent="visaForm" class="mt-8 space-y-6">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" v-model="email" class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <div>
          <label for="surname" class="block text-sm font-medium text-gray-700">Surname (Family Name)</label>
          <input type="text" name="surname" v-model="surname" class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <div>
          <label for="first_name" class="block text-sm font-medium text-gray-700">First name(s) (Given name(s))</label>
          <input type="text" name="first_name" v-model="first_name" class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <div>
          <label for="residence" class="block text-sm font-medium text-gray-700">Residence in a country other than the country of current nationality:</label>
          <div class="mt-1">
            <input type="radio" name="residence" value="No" v-model="residence" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
            <label for="residence-no" class="ml-3 block text-sm font-medium text-gray-700">No</label>
          </div>
          <div class="mt-1">
            <input type="radio" name="residence" value="Yes" v-model="residence" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
            <label for="residence-yes" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
          </div>
        </div>

        <div>
          <label for="marital_status" class="block text-sm font-medium text-gray-700">Marital Status:</label>
          <div class="mt-1">
            <input type="radio" name="marital_status" value="Single" v-model="marital_status" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
            <label for="single" class="ml-3 block text-sm font-medium text-gray-700">Single</label>
          </div>
          <div class="mt-1">
            <input type="radio" name="marital_status" value="Married" v-model="marital_status" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
            <label for="married" class="ml-3 block text-sm font-medium text-gray-700">Married</label>
          </div>
          <div class="mt-1">
            <input type="radio" name="marital_status" value="Divorced" v-model="marital_status" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
            <label for="divorced" class="ml-3 block text-sm font-medium text-gray-700">Divorced</label>
          </div>
        </div>

        <div>
          <label for="national_identity_number" class="block text-sm font-medium text-gray-700">National identity number, where applicable:</label>
          <input type="text" name="national_identity_number" v-model="national_identity_number" class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <div>
          <label for="travel_document" class="block text-sm font-medium text-gray-700">Type of travel document:</label>
          <div class="mt-1">
            <input type="radio" name="travel_document" value="Ordinary" v-model="travel_document" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
            <label for="ordinary" class="ml-3 block text-sm font-medium text-gray-700">Ordinary Passport</label>
          </div>
          <div class="mt-1">
            <input type="radio" name="travel_document" value="Diplomatic" v-model="travel_document" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
            <label for="diplomatic" class="ml-3 block text-sm font-medium text-gray-700">Diplomatic</label>
          </div>
        </div>

    <div>
      <label for="journey_purpose" class="block text-sm font-medium text-gray-700">Main purpose(s) of the journey:</label>
      <div class="mt-1">
        <input type="radio" name="journey_purpose" value="Tourism" v-model="selectedJourneyPurpose" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
        <label for="tourism" class="ml-3 block text-sm font-medium text-gray-700">Tourism</label>
      </div>
      <div class="mt-1">
        <input type="radio" name="journey_purpose" value="Business" v-model="selectedJourneyPurpose" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
        <label for="business" class="ml-3 block text-sm font-medium text-gray-700">Business</label>
      </div>
      <div class="mt-1">
        <input type="radio" name="journey_purpose" value="Family or Friends" v-model="selectedJourneyPurpose" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
        <label for="family_or_friends" class="ml-3 block text-sm font-medium text-gray-700">Visiting family or friends</label>
      </div>
      <div class="mt-1">
        <input type="radio" name="journey_purpose" value="Cultural" v-model="selectedJourneyPurpose" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
        <label for="cultural" class="ml-3 block text-sm font-medium text-gray-700">Cultural</label>
      </div>
      <div class="mt-1">
        <input type="radio" name="journey_purpose" value="Sports" v-model="selectedJourneyPurpose" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
        <label for="sports" class="ml-3 block text-sm font-medium text-gray-700">Sports</label>
      </div>
      <div class="mt-1">
        <input type="radio" name="journey_purpose" value="Official Visit" v-model="selectedJourneyPurpose" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
        <label for="official_visit" class="ml-3 block text-sm font-medium text-gray-700">Official visit</label>
      </div>
      <div class="mt-1">
        <input type="radio" name="journey_purpose" value="Medical Reasons" v-model="selectedJourneyPurpose" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
        <label for="medical_reasons" class="ml-3 block text-sm font-medium text-gray-700">Medical reasons</label>
      </div>
      <div class="mt-1">
        <input type="radio" name="journey_purpose" value="Study" v-model="selectedJourneyPurpose" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
        <label for="study" class="ml-3 block text-sm font-medium text-gray-700">Study</label>
      </div>
      <div class="mt-1">
        <input type="radio" name="journey_purpose" value="Airport Transit" v-model="selectedJourneyPurpose" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
        <label for="airport_transit" class="ml-3 block text-sm font-medium text-gray-700">Airport transit</label>
      </div>
      <div class="mt-1">
        <input type="radio" name="journey_purpose" value="Other" v-model="selectedJourneyPurpose" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
        <label for="other" class="ml-3 block text-sm font-medium text-gray-700">Other</label>
      </div>
    </div>

        <div>
          <label for="intended-date-of-arrival" class="block text-sm font-medium text-gray-700">Intended date of arrival of the first intended stay in the Schengen area:</label>
          <input type="date" name="intended-date-of-arrival" v-model="arrival" class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <div>
          <label for="intended-date-of-departure" class="block text-sm font-medium text-gray-700">Intended date of departure from the Schengen area after the first intended stay:</label>
          <input type="date" name="intended-date-of-departure" v-model="departure" class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <div>
          <label for="travel_companion" class="block text-sm font-medium text-gray-700">Are there other persons traveling with you?</label>
          <div class="mt-1">
            <input type="radio" name="travel_companion" value="No" v-model="travel_companion_no" @change="travel_companion_yes = false" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
            <label for="travel_companion-no" class="ml-3 block text-sm font-medium text-gray-700">No</label>
          </div>
          <div class="mt-1">
            <input type="radio" name="travel_companion" value="Yes" @change="travel_companion_yes = true" v-model="travel_companion_yes" class="focus:ring-indigo-500 h-4 w-4 text-blue-600 border-gray-300">
            <label for="travel_companion-yes" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
          </div>
        </div>

        <div class="flex items-center justify-end mt-4">
          <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">Submit</button>
        </div>
      </form>
      <div v-if="travel_companion_yes" class="w-full bg-red-200 h-auto m-5">

        <h1>Travel Companion Details</h1>
        <table>
            <thead>  
                <tr>
                  <th>S/N</th>
                  <th>Name</th>
                  <th>Relationship</th>
                  <th>Action</th>
                </tr>
            </thead>
            <tbody>
              <tr v-for="(tour, index) in travel_companion" :key="index">
                  <td>{{index + 1}}</td>
                  <td>{{tour.firstName}}</td>
                  <td>{{tour.relationship}}</td>
                  <td>
                    <button class="bg-red-500 rounded-md text-white p-2">del</button>
                  </td>
              </tr>
            </tbody>
        </table>


        <div>
          <label for="traveling-companion-first-name" class="block text-sm font-medium text-gray-700">Given Names of Person Traveling With You:</label>
          <input type="text" name="traveling-companion-first-name" v-model="companion_firstName" class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
    
        <div>
          <label for="traveling-companion-relationship" class="block text-sm font-medium text-gray-700">Relationship with Person:</label>
          <input type="text" name="traveling-companion-relationship" v-model="companion_relationship" class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <button @click="companions" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded mt-4">Save Companion</button>
      </div>
    </div>

   <div class="w-full flex flex-col items-center justify-center bg-gradient-to-t from-[rgb(0,83,176)] via-[rgb(0,98,242)] to-[rgb(112,194,239)] py-12 px-6">
  <p class="text-2xl font-bold text-white mb-8" id="about2">Available Tours and Itinerary</p>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6 w-full max-w-7xl">
    <div 
      @click="bookTour(tour.id)" 
      v-for="(tour, index) in tours" 
      :key="index" 
      class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transform transition duration-300 hover:scale-105 border border-gray-200">
      
      <!-- Image Section -->
      <img class="w-full h-48 object-cover" :src="'/storage/' + tour.images" alt="Tour Image">

      <!-- Card Content -->
      <div class="p-4">
        <p class="text-lg font-semibold text-gray-800" id="tours1">{{ tour.tour_name }}</p>
        <p class="text-sm text-gray-600 my-2" id="tours2">{{ tour.tour_decs }}</p>
        <p class="text-xl font-bold text-blue-600" id="tours1">{{ tour.tour_prices }}</p>
      </div>

      <!-- Button Section -->
      <div class="p-4 pt-0">
        <button 
          class="w-full py-2 text-center text-white bg-blue-500 hover:bg-blue-600 rounded-md transition">
          Book Tour
        </button>
      </div>
    </div>
  </div>
</div>


    
  </div>
  <Footer></Footer>
</template>

<script>
import Header from './Header.vue';
import axios from 'axios';
import "@fortawesome/fontawesome-free/css/all.min.css";
import Footer from './Footer.vue';

export default {
  components: {
    Header,
    Footer
  },
  data() {
    return {
     
      tours: [],
        email: '',
        surname: '',
        first_name: '',
        residence: '',
        marital_status: '',
        national_identity_number: '',
        travel_document: '',
        selectedJourneyPurpose: '',
        arrival: '',
        departure: '',
        travel_companion: [],
        travel_companion_yes: false,
        travel_companion_no: false,
        companion_firstName: '',
        companion_relationship: ''
      
    };
  },
  methods: {
    companions(){
      this.travel_companion.push({
          firstName: this.companion_firstName,
          relationship: this.companion_relationship
        });

        console.log(this.travel_companion);
        
        this.companion_firstName= '',
        this.companion_relationship= ''
    }
    ,
    visaForm() {
      let data ={
        email:this.email,
        surname: this.surname,
        first_name: this.first_name,
        residence: this.residence,
        marital_status: this.marital_status,
        national_identity_number: this.national_identity_number,
        travel_document: this.travel_document,
        journey_purpose: this.selectedJourneyPurpose,
        arrival: this.arrival,
        departure: this.departure,
        travel_companion: this.travel_companion

      }

      console.log(data);
      axios.post(route("visa.create", data))
      .then(response => {
          alert('Visa for submitted successfully')
          console.log('Form submitted successfully:', response);
          this.email = '';
          this.surname = '';
          this.first_name = '';
          this.residence = '';
          this.marital_status = '';
          this.national_identity_number = '';
          this.travel_document = '';
          this.selectedJourneyPurpose = '';
          this.arrival = '';
          this.departure = '';
          this.travel_companion = '';
        })
        .catch(error => {
          console.error('There was an error submitting the form:', error);
          
        });
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
  mounted() {
    this.fetching();
  },
};
</script>
