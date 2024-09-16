<template>
    <button :class="color" class=" rounded-xl border-2 border-pink-500 bg-pink-500 px-8 py-2">{{ names }}</button>
    <!-- <button>Cake</button> -->
</template>

<script>
export default{
    props:{
        names: String
    },
    data(){
        return {

        }
    }
}
</script>