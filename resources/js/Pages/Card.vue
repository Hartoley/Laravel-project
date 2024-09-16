<template>
    <div class=" shadow-md rounded-md p-5 w-[24%]">
        <h1 class=" text-[24px]">{{ header }}</h1>
        <p class=" text-[16px]">{{ message }}</p>
        <button class="border-2">Click me</button>
    </div>
</template>

<script>
    export default{
        props:{
            header: String,
            message: String,
        }
    }
</script>