<template>
<nav class="bg-[rgb(59,83,145)] text-white border-b border-gray-200">
  <div class="container flex items-center justify-between h-16 px-6 mx-auto">
    <img class="h-8 mr-3" src="https://i.pinimg.com/474x/9b/51/b6/9b51b691dfcb3dfc03fd2225d3a5b347.jpg" alt="Logo">
    <div class="flex items-center">
     
      <div class="w-[60vw] opacity-100 text-white text-[0.6vw] hidden md:flex space-x-10">
        <a href="#"  class=" tw-[30px] hover:text-blue-500">BOOK CHEAP FLIGHTS</a>
        <a href="#" class="tw-[30px] hover:text-blue-500">FLIGHTS</a>
        <a href="#" class="tw-[30px] hover:text-blue-500">HOLIDAYS</a>
        <a href="#" class="tw-[30px] hover:text-blue-500">ASPOM SERVICES</a>
        <a :href="route('travel')" class="tw-[30px] hover:text-blue-500">VISA SERVICES</a>
        <a href="#" class="tw-[30px] hover:text-blue-500">CONTACT US</a>
        <a href="#" class="tw-[30px] hover:text-blue-500">CONTACT US</a>
        <a href="#" class="tw-[30px] hover:text-blue-500">BLOG</a>
      </div>
    </div>
    <div class="hidden md:flex items-center">
      <div class="flex items-center mr-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0 1 14 0z" />
        </svg>
      </div>
      <a href="#" class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 text-white font-bold rounded-full hover:bg-blue-700">
        Get WhatsApp
      </a>
    </div>
  </div>
</nav>
    
</template>
<script>

export default{

}


</script>