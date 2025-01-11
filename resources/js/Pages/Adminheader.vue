<template>
    <nav
        class="bg-[#003399] h-[10vh] flex items-center fixed top-0 left-0 w-full z-10 text-white border-b border-gray-200">
        <div class="container flex items-center justify-between h-16 px-10 mx-auto">
            <img class="h-8 mr-3" src="https://i.pinimg.com/474x/c2/45/31/c245311698a8e4801bc402c592714e92.jpg"
                alt="Logo" @click="loadContent" />
            <div class="flex items-center">
                <div class="w-[60vw] opacity-100 text-white text-[0.8vw] hidden md:flex space-x-10">
                    <!-- <a
                        :href="route('cheapFligths')"
                        class="tw-[30px] hover:text-blue-500"
                        >ADMIN FLIGHTS</a
                    > -->
                    <!-- <a
                        :href="route('travel')"
                        class="tw-[30px] hover:text-blue-500"
                        >FLIGHTS</a
                    > -->
                    <a :href="route('admin.travel')" class="tw-[30px] hover:text-blue-500">UPLOAD HOLIDAYS</a>
                    <a :href="route('ManagwT')" class="tw-[30px] hover:text-blue-500">MANAGE HOLIDAYS</a>
                    <a :href="route('visaAdmin') + '#visaApplication'" class="tw-[30px] hover:text-blue-500">VISA
                        SERVICES</a>
                    <a :href="route('visaAdmin')" class="tw-[30px] hover:text-blue-500">MANAGE APPLICATION STATUS</a>
                </div>
            </div>
            <div class="md:hidden flex items-center">
                <button @click="toggleMenu" class="focus:outline-none text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
            <div class="hidden md:flex items-center">
                <div class="flex items-center mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0 1 14 0z" />
                    </svg>
                </div>
                <a href="whatsapp://send"
                    class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 text-white font-bold rounded-full hover:bg-blue-700">
                    Open WhatsApp
                </a>
            </div>
        </div>
        <div v-if="isMenuOpen" class="md:hidden bg-white text-black w-full absolute top-[10vh] left-0 shadow-lg z-20">
            <a :href="route('admin.travel')" class="block py-3 px-4 border-b hover:bg-blue-100 hover:text-blue-500">
                UPLOAD HOLIDAYS
            </a>
            <a :href="route('ManagwT')" class="block py-3 px-4 border-b hover:bg-blue-100 hover:text-blue-500">
                MANAGE HOLIDAYS
            </a>
            <a :href="route('visaAdmin') + '#visaApplication'"
                class="block py-3 px-4 border-b hover:bg-blue-100 hover:text-blue-500">
                VISA SERVICES
            </a>
            <a :href="route('visaAdmin')" class="block py-3 px-4 hover:bg-blue-100 hover:text-blue-500">
                MANAGE APPLICATION STATUS
            </a>
        </div>
    </nav>
</template>
<script>
export default {
    data() {
        return {
            isMenuOpen: false, // State for menu visibility
        };
    },
    methods: {
        loadContent() {
            console.log("Loading content dynamically...");
            window.location.href = "/adminTravel";
        },
        toggleMenu() {
            this.isMenuOpen = !this.isMenuOpen; // Toggle menu visibility
        },
    },
};
</script>