<template>
    <Header></Header>
    <div class="relative w-full h-[90vh] overflow-hidden mt-[10vh]">
        <div class="flex w-full h-full transition-transform duration-[1000ms]" ref="carousel">
            <div v-for="(image, index) in images" :key="index" class="flex-shrink-0 w-full h-full scale-on-scroll">
                <img class="w-full h-full" :src="image.src" :alt="image.alt" />
            </div>
        </div>

        <div
            class="absolute bottom-[10vh] duration-200 hover:scale-70 hover:brightness-125 text-blue-500 left-1/2 transform -translate-x-1/2 flex justify-center items-center w-full px-4">
            <div
                class="bg-black bg-opacity-25 hover:scale-110 duration-200 hover:text-blue-500 w-[50vw] text-white h-[40vh] p-4 rounded shadow-lg flex flex-col justify-evenly items-center scale-on-scroll">
                <p class="text-center text-[25px] fw-extrabold">
                    The Berlin Travel And Tours
                </p>
                <p class="text-center text-[14px] font-thin">
                    We own an 81 rooms Hotel in the heart of Berlin
                </p>
                <div class="text-center">
                    <div class="flex text-gray-800 text-[1vw] font-thin">
                        <div class="w-[7vw] h-[20px] bg-white">
                            <p>Arrival</p>
                        </div>
                        <div class="w-[7vw] h-[20px] bg-white">
                            <p>Departure</p>
                        </div>
                        <div class="w-[7vw] h-[20px] bg-white">
                            <p>2 Adults</p>
                        </div>
                        <div class="w-[7vw] h-[20px] bg-white">
                            <p>1 Room</p>
                        </div>
                        <div class="w-[7vw] h-[20px] bg-white">
                            <p>0 Children</p>
                        </div>
                        <div class="w-[7vw] h-[20px] bg-red-200">
                            <p>Find a room</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="w-full flex justify-center items-center h-[70vh] bg-[rgb(237,233,238)]">
        <div class="w-[60vw] h-[60%] flex justify-center items-center">
            <div class="w-[50%] h-[100%] pt-[20px] about-section scale-on-scroll" id="aboutSection">
                <p class="text-[#b73a04] flex justify-center items-center">
                    ESTABLISHED 2018
                </p>
                <p class="pt-[1vw]" id="about2">About The Berlin Travels</p>
                <p class="pt-[1vw]" id="about3">
                    At The Berlin travels, we transform your travel dreams into
                    unforgettable experiences. Whether you're seeking a relaxing
                    beach getaway, an adventurous mountain trek, or a cultural
                    city tour, our expert team is dedicated to crafting
                    personalized itineraries that suit your unique interests and
                    budget.
                </p>
            </div>
            <div class="w-[48%] ml-[1vw] h-[100%] bg-purple-500 scale-on-scroll">
                <img class="w-[100%] duration-200 transform hover:scale-110 hover:brightness-125 h-[100%]"
                    src="https://i.pinimg.com/474x/8e/08/42/8e0842284dd4fc3888591ebb3d1bdb5d.jpg" alt="" />
            </div>
        </div>
    </div>

    <div class="w-full flex justify-center items-center h-[45vh] bg-white">
        <div
            class="w-[50vw] h-[100%] flex justify-center transition duration-300 ease-in-out transform hover:scale-10 items-center">
            <div
                class="w-[50%] h-[100%] flex rounded-md justify-center items-center transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg hover:bg-gray-200">
                <img class="w-[10vw] h-[90%] rounded-md mx-2 transition duration-300 ease-in-out transform hover:scale-125 hover:z-10 hover:brightness-125"
                    src="https://i.pinimg.com/564x/a8/a5/61/a8a5619a67d3502ff7eb1057137a784f.jpg" alt="" />
                <img class="w-[10vw] h-[90%] rounded-md mx-2 transition duration-300 ease-in-out transform hover:scale-125 hover:z-10 hover:brightness-125"
                    src="https://i.pinimg.com/474x/c3/c3/ae/c3c3ae776cebbfda4f22db92a64dbe52.jpg" alt="" />
            </div>

            <div class="w-[48%] ml-[1vw] h-[100%] scale-on-scroll">
                <p class="pt-[1vw]" id="about2">
                    Travel is here, Pleasure to the heart
                </p>
                <p class="pt-[1vw]" id="about3">
                    Let us handle the details while you focus on creating
                    lasting memories. From flight bookings and accommodations to
                    local tours and activities, we provide seamless and
                    stress-free travel planning. Discover new destinations,
                    embrace new cultures, and embark on your next adventure with
                    confidence.
                </p>
            </div>
        </div>
    </div>
    <div v-if="loading" class="absolute inset-0 flex justify-center items-center z-50 bg-black bg-opacity-50">
        <div class="text-white text-xl animate-spin">
            <svg class="w-12 h-12 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 2.577 1.004 4.911 2.635 6.635l1.365-1.344z">
                </path>
            </svg>
        </div>
    </div>
    <div class="travel-section flex flex-col md:flex-row items-start justify-evenly px-8 py-16 bg-gray-50">
        <!-- Left Content -->
        <div class="content md:w-1/3 mb-8 md:mb-0 md:pr-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4 hover:text-blue-500 transition duration-300">
                Travel to make sweet memories
            </h1>
            <p class="text-lg text-gray-600 mb-8 hover:text-gray-800 transition duration-300">
                Find trips that fit a flexible lifestyle
            </p>
            <div class="features space-y-6">
                <div v-for="(feature, index) in features" :key="index"
                    class="feature flex items-start space-x-4 group hover:scale-105 transition duration-300">
                    <div
                        class="feature-number flex items-center justify-center w-12 h-12 bg-blue-500 text-white font-bold rounded-full group-hover:bg-blue-600 transition duration-300">
                        {{ feature.number }}
                    </div>
                    <div>
                        <h2
                            class="text-xl font-semibold text-gray-700 mb-2 group-hover:text-blue-500 transition duration-300">
                            {{ feature.title }}
                        </h2>
                        <p class="text-gray-600 group-hover:text-gray-800 transition">
                            {{ feature.description }}
                        </p>
                    </div>
                </div>
            </div>
            <button
                class="mt-8 px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 hover:scale-110 transition duration-300"
                @click="startExplore">
                Start your explore
            </button>
        </div>


        <div class="image-container relative md:w-1/3">
            <img class="w-full rounded-lg shadow-lg hover:scale-105 transition duration-300"
                src="https://i.pinimg.com/474x/9c/38/ea/9c38ead092b560475aebeaa7cc0294a5.jpg" alt="Scenic Mountain" />
            <div v-for="(profile, index) in profiles" :key="index"
                class="profile-badge absolute flex items-center bg-white border w-[13vw] border-gray-200 shadow-lg rounded-3xl p-2 hover:shadow-xl hover:scale-110 transition duration-300"
                :style="{ top: profile.top, left: profile.left }">
                <img :src="profile.image" :alt="profile.name"
                    class="w-10 h-10 rounded-full hover:scale-110 transition duration-300" />
                <div class="ml-2 w-50">
                    <p class="text-sm font-semibold text-gray-800 hover:text-blue-500 transition duration-300">
                        {{ profile.name }}
                    </p>
                    <p class="text-sm text-blue-500 font-medium">
                        {{ profile.rating }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div id="holidays"
        class="w-full flex flex-col items-center justify-center bg-gradient-to-t from-[rgb(0,83,176)] via-[rgb(0,98,242)] to-[rgb(112,194,239)] py-12 px-6">
        <p class="text-2xl font-bold text-white mb-8" id="about2">
            Available Tours and Itinerary
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6 w-full max-w-7xl">
            <div v-for="(tour, index) in tours" :key="index"
                class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transform transition duration-300 hover:scale-105 border border-gray-200 scale-on-scroll"
                :class="{ 'opacity-90': isExpired(tour.boarding_date) }">
                <!-- Image Section -->
                <img class="w-full h-48 object-cover" :src="'/storage/' + tour.images" alt="Tour Image" />

                <!-- Card Content -->
                <div class="p-4">
                    <p class="text-lg font-semibold text-gray-800" id="tours1">
                        {{ tour.tour_name }}
                    </p>
                    <p class="text-sm text-gray-600 my-2" id="tours2">
                        {{ tour.tour_decs }}
                    </p>
                    <p class="text-xl font-bold text-blue-600" id="tours1">
                        {{ tour.tour_prices }}
                    </p>
                    <p v-if="isExpired(tour.boarding_date)" class="text-red-500 font-semibold mt-2">
                        Expired
                    </p>
                </div>

                <!-- Button Section -->
                <div class="p-4 pt-0">
                    <button :disabled="isExpired(tour.boarding_date)" @click="bookTour(tour.id)"
                        class="w-full py-2 text-center text-white rounded-md transition" :class="isExpired(tour.boarding_date)
                            ? 'bg-gray-400 cursor-not-allowed'
                            : 'bg-blue-500 hover:bg-blue-600'">
                        Book Tour
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="w-full flex items-center justify-evenly my-10 h-[65vh]">
        <div class="relative w-full md:w-3/4 h-[60vh]">
            <button
                class="absolute top-2 right-2 px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition duration-300 z-10">
                Book now
            </button>

            <div class="relative overflow-hidden rounded-lg shadow-md h-full">
                <video muted ref="videoPlayer" class="w-full h-full object-cover" :src="videoSrc" controls
                    poster="https://i.pinimg.com/474x/b1/5f/d9/b15fd9c6a0f08e8b9b750f1034bad8cc.jpg"
                    playsinline></video>

                <div v-if="!isPlaying"
                    class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 cursor-pointer"
                    @click="togglePlay">
                    <div class="bg-white w-12 h-12 rounded-full shadow-md flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.5 4.5L13.5 10L6.5 15.5V4.5Z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <Footer id="footer"></Footer>
</template>






<script>
import Header from "./Header.vue";
import axios from "axios";
import Footer from "./Footer.vue";

export default {
    components: {
        Header,
        Footer,
    },
    data() {
        return {
            features: [
                {
                    number: "01",
                    title: "Find trips that fit your freedom",
                    description:
                        "Traveling offers freedom and flexibility, solitude and spontaneity, and privacy and purpose.",
                },
                {
                    number: "02",
                    title: "Get back to nature by travel",
                    description:
                        "The world is a playground, and you can finally explore Mother Nature's immaculate canvas.",
                },
                {
                    number: "03",
                    title: "Reignite those travel tastebuds",
                    description:
                        "There are infinite reasons to love travel, one of them being the food, glorious food.",
                },
            ],
            profiles: [
                {
                    name: "Kamala Diana",
                    rating: "4.8",
                    image: "https://i.pinimg.com/474x/9c/38/ea/9c38ead092b560475aebeaa7cc0294a5.jpg",
                    top: "10%",
                    left: "65%",
                },
                {
                    name: "Heikki Adem",
                    rating: "4.9",
                    image: "https://i.pinimg.com/736x/c8/a0/25/c8a0250751a6fc050c6a13d62bdde8fa.jpg",
                    top: "45%",
                    left: "80%",
                },
                {
                    name: "Joe Zetano",
                    rating: "4.5",
                    image: "https://i.pinimg.com/474x/c8/6f/58/c86f580cfaed6259c3d921660b5f98e8.jpg",
                    top: "75%",
                    left: "20%",
                },
            ],

            tours: [],
            images: [
                {
                    src: "https://i.pinimg.com/474x/ef/c6/62/efc662ad7d783e588fcf5f8a2f28693f.jpg",
                    alt: "Picture 1",
                },
                {
                    src: "https://i.pinimg.com/474x/29/43/3e/29433e8d66c542e12cf8817531a3097d.jpg",
                    alt: "Picture 2",
                },
                {
                    src: "https://i.pinimg.com/474x/8c/b4/fc/8cb4fc604e2249a8ea7ea946693e2c94.jpg",
                    alt: "Picture 3",
                },
                {
                    src: "https://i.pinimg.com/474x/af/0e/a9/af0ea91a19c8d44060c47bf1de8727fa.jpg",
                    alt: "Picture 4",
                },
                {
                    src: "https://i.pinimg.com/474x/d4/db/b7/d4dbb7c0e7503fe94e051e304ae7746d.jpg",
                    alt: "Picture 5",
                },
                {
                    src: "https://i.pinimg.com/474x/31/e5/7d/31e57daab0bdb3345ed06febcd2f1977.jpg",
                    alt: "Picture 6",
                },
                {
                    src: "https://i.pinimg.com/474x/7a/a1/94/7aa19415266b8ad0ad570b7d2ecc3e8e.jpg",
                    alt: "Picture 7",
                },
                {
                    src: "https://i.pinimg.com/474x/5f/9f/5d/5f9f5d0cf485d26df837a303204e1ee7.jpg",
                    alt: "Picture 8",
                },
                {
                    src: "https://i.pinimg.com/474x/5c/db/7c/5cdb7ca5916f7704b74c3ccf32f26703.jpg",
                    alt: "Picture 9",
                },
                {
                    src: "https://i.pinimg.com/474x/66/82/f1/6682f1dacfadb9e33b2316516f9be132.jpg",
                    alt: "Picture 10",
                },
                {
                    src: "https://i.pinimg.com/474x/5a/c7/3a/5ac73ac3b27ab9cfc25b139eb4d52218.jpg",
                    alt: "Picture 11",
                },
                {
                    src: "https://i.pinimg.com/474x/f9/53/67/f95367c4ab318843d77c79a7216b9701.jpg",
                    alt: "Picture 12",
                },
            ],
            currentIndex: 0,
            slideInterval: null,
            loading: false,
            isPlaying: false,
            videoSrc:
                "https://youtu.be/eLPVDaaQybY?si=AA1oJNzyvcSk9jCa"
        };
    },
    methods: {
        startExplore() {
            alert("Explore button clicked!");
        },
        togglePlay() {
            const video = this.$refs.videoPlayer;

            if (this.isPlaying) {
                video.pause();
            } else {
                video.play();
            }

            this.isPlaying = !this.isPlaying;
        },

        observeElements() {
            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('scale-in');
                        } else {
                            entry.target.classList.remove('scale-in');
                        }
                    });
                },
                {
                    threshold: 0.1,
                }
            );

            const scaleElements = document.querySelectorAll('.scale-on-scroll');

            scaleElements.forEach((element) => {
                observer.observe(element);
            });
        },

        isExpired(boardingDate) {
            const currentDate = new Date();
            const tourDate = new Date(boardingDate);
            return tourDate < currentDate;
        },
        prevSlide() {
            this.currentIndex =
                (this.currentIndex - 1 + this.images.length) %
                this.images.length;
            this.updateCarousel();
        },
        nextSlide() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
            this.updateCarousel();
        },
        updateCarousel() {
            const carousel = this.$refs.carousel;
            carousel.style.transform = `translateX(${this.currentIndex * -100
                }%)`;
        },
        fetching() {
            this.loading = true;
            axios
                .get(route("tour.fetch"))
                .then((res) => {
                    console.log(res);
                    this.tours = res.data;
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err);
                    this.loading = false;
                });
        },
        startAutoSlide() {
            this.slideInterval = setInterval(() => {
                this.nextSlide();
            }, 6500);
        },
        stopAutoSlide() {
            clearInterval(this.slideInterval);
        },

        bookTour(id) {
            console.log(id);
            window.location.href = `/bookTour/${id}`;
        },
    },
    mounted() {
        this.fetching();
        this.updateCarousel();
        this.startAutoSlide();
        this.observeElements();


        const hash = window.location.hash;
        if (hash === "#holidays") {
            const section = document.querySelector(hash);
            if (section) {
                section.scrollIntoView({ behavior: "smooth" });
            }
        }

        if (hash === "#footer") {
            const footer = document.querySelector(hash);
            if (footer) {
                footer.scrollIntoView({ behavior: "smooth" });
            }
        }
    },
    beforeDestroy() {
        this.stopAutoSlide();
    },
};
</script>

<style>
.scale-on-scroll {
    transform: scale(1);
    transition: transform 0.5s ease-out;
}

.scale-in {
    transform: scale(1.05);
}

#aboutSection {
    font-family: "Playwrite CU", cursive;
    font-size: 0.8vw;
    font-weight: 400;
    font-style: normal;
}

#about2 {
    font-family: Georgia, "Times New Roman", Times, serif;
    font-weight: 600;
    font-size: 21px;
}

#tours {
    font-family: Georgia, "Times New Roman", Times, serif;
    font-weight: 600;
    font-size: 15px;
}

#tours1 {
    font-family: Georgia, "Times New Roman", Times, serif;
    font-weight: 600;
    font-size: 12px;
    height: 5.5vh;
    margin-bottom: 1px;
}

#tours2 {
    font-family: Georgia, "Times New Roman", Times, serif;
    font-weight: 200;
    font-size: 12px;
    height: 13vh;
    margin-bottom: 1px;
}

#about3 {
    font-size: 0.9vw;
}
</style>
