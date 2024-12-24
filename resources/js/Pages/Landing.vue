<template>
    <Header></Header>
    <div class="relative w-full h-[90vh] overflow-hidden mt-[10vh]">
        <h1>My Holidats</h1>
    </div>

    <Footer></Footer>
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
            visApplicants: [],
            companions: [],
            selectedVisitor: null,
        };
    },
    methods: {
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
            if (carousel) {
                carousel.style.transform = `translateX(${
                    this.currentIndex * -100
                }%)`;
            } else {
                console.warn("Carousel element is not available.");
            }
        },

        fetching() {
            axios
                .get(route("tour.fetch"))
                .then((res) => {
                    // console.log(res);
                    this.tours = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },

        fetchingUserTours() {
            axios
                .get(route("usertour.fetch"))
                .then((res) => {
                    console.log(res);
                })
                .catch((err) => {
                    console.log(err);
                });
        },

        openVisitorModal(visitor) {
            this.selectedVisitor = visitor;
        },

        closeVisitorModal() {
            this.selectedVisitor = null;
        },

        startAutoSlide() {
            this.slideInterval = setInterval(() => {
                this.nextSlide();
            }, 90000);
        },

        stopAutoSlide() {
            clearInterval(this.slideInterval);
        },

        bookTour(id) {
            console.log(id);
            window.location.href = `/bookTour/${id}`;
        },

        fetchApplications() {
            axios
                .get(route("user.fetch_application"))
                .then((res) => {
                    // console.log(res);
                    this.visApplicants = res.data.applications;
                    // console.log("visa applicants", this.visApplicants);
                    // console.log(Array.isArray(this.visApplicants));
                    // console.log(this.visApplicants.length);
                    status = this.visApplicants.status;
                })
                .catch((err) => {
                    console.log("user error", err);
                });
        },
    },

    mounted() {
        this.fetching();
        this.$nextTick(() => {
            this.updateCarousel();
        });
        this.startAutoSlide();
        this.fetchApplications();
        this.fetchingUserTours();
    },
    beforeDestroy() {
        this.stopAutoSlide();
    },
};
</script>

<style>
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
