<template>
    <div>
        <Header />
        <div
            class="w-full h-[100vh] relative flex flex-col items-center justify-center"
        >
            <div class="h-full w-full">
                <img class="w-full h-full" :src="image.src" :alt="image.alt" />
            </div>
            <div class="w-[70%] absolute flex items-center top-[12vh] h-[85%]">
                <img
                    class="w-[50%] h-full rounded-bl-md rounded-tl-md"
                    :src="images.src"
                    :alt="image.alt"
                />
                <div
                    class="w-[50%] h-full rounded-br-md rounded-tr-md bg-[rgba(59,83,145,0.96)] flex flex-col"
                >
                    <div
                        class="w-[40%] h-[15%] ml-[60%] flex items-center justify-center"
                    >
                        <button
                            class="w-[45%] h-[60%] rounded-tl-[20px] rounded-bl-[20px] text-white bg-[rgb(46,61,84)] hover:bg-[rgb(169,196,219)] transition duration-100"
                        >
                            Sign up
                        </button>
                        <button
                            class="w-[45%] h-[60%] rounded-tr-[20px] rounded-br-[20px] bg-[rgb(218,211,167)] hover:bg-[rgb(200,188,113)] transition duration-100"
                        >
                            Sign in
                        </button>
                    </div>
                    <div class="grid w-full h-[auto] place-items-center">
                        <img
                            class="w-[3vw]"
                            src="https://i.pinimg.com/474x/c2/45/31/c245311698a8e4801bc402c592714e92.jpg"
                            alt=""
                        />
                    </div>
                    <div
                        class="w-[100%] flex flex-col items-center justify-center text-white gap-5 h-[80%]"
                    >
                        <input
                            type="text"
                            v-model="first_name"
                            class="w-[70%] border-b-white border-l-[rgba(59,83,145,0.96)] border-r-[rgba(59,83,145,0.96)] border-t-[rgba(59,83,145,0.96)] placeholder-white outline-none bg-[rgba(59,83,145,0.96)] text-white"
                            placeholder="FIRST NAME"
                        />
                        <input
                            type="text"
                            v-model="surname"
                            class="w-[70%] border-b-white border-l-[rgba(59,83,145,0.96)] border-r-[rgba(59,83,145,0.96)] border-t-[rgba(59,83,145,0.96)] placeholder-white outline-none bg-[rgba(59,83,145,0.96)] text-white"
                            placeholder="LAST NAME"
                        />
                        <input
                            type="email"
                            v-model="email"
                            class="w-[70%] border-b-white border-l-[rgba(59,83,145,0.96)] border-r-[rgba(59,83,145,0.96)] border-t-[rgba(59,83,145,0.96)] placeholder-white outline-none bg-[rgba(59,83,145,0.96)] text-white"
                            placeholder="EMAIL"
                        />
                        <div class="relative w-[70%]">
                            <input
                                :type="showPassword ? 'text' : 'password'"
                                v-model="password"
                                class="w-full border-b-white border-l-[rgba(59,83,145,0.96)] border-r-[rgba(59,83,145,0.96)] border-t-[rgba(59,83,145,0.96)] placeholder-white outline-none bg-[rgba(59,83,145,0.96)] text-white"
                                placeholder="PASSWORD"
                            />
                            <button
                                @click="togglePassword"
                                class="absolute right-0 top-1/2 transform -translate-y-1/2 pr-3 text-white"
                            >
                                <span v-if="showPassword">Hide</span>
                                <span v-else>Show</span>
                            </button>
                        </div>
                        <button
                            @click="signup"
                            class="w-[60%] h-[10%] rounded-[25px] rounded-bl-[20px] text-white bg-[rgb(46,61,84)] hover:bg-[rgb(169,196,219)] transition duration-100"
                            :disabled="loading"
                        >
                            <span v-if="loading">Signing up...</span>
                            <span v-else>Sign up</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "./Header.vue";
import axios from "axios";

export default {
    components: {
        Header,
    },
    data() {
        return {
            email: "",
            surname: "",
            first_name: "",
            password: "",
            showPassword: false,
            loading: false,
            image: {
                src: "https://i.pinimg.com/474x/1f/90/01/1f9001b701284c5e51f7caa614b1fdaa.jpg",
                alt: "Picture 1",
            },
            images: {
                src: "https://i.pinimg.com/474x/ab/2e/ab/ab2eab9c2bee1c3890f7525d7ef698dc.jpg",
                alt: "Picture 2",
            },
        };
    },
    methods: {
        togglePassword() {
            this.showPassword = !this.showPassword;
        },
        signup() {
            this.loading = true;
            let data = {
                email: this.email,
                surname: this.surname,
                first_name: this.first_name,
                password: this.password,
            };

            axios
                .post(route("register", data))
                .then((response) => {
                    alert("User Data submitted successfully");
                    console.log("User Data submitted successfully:", response);
                    this.email = "";
                    this.surname = "";
                    this.first_name = "";
                    this.password = "";
                })
                .catch((error) => {
                    console.error(
                        "There was an error submitting the form:",
                        error
                    );
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    },
};
</script>
