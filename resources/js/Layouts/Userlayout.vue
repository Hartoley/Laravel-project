<template>
    <div class="flex">
        <div  class="w-[10%] px-3 py-3 bg-[rgb(59,83,145)] text-white h-screen">
            <ul>
               <li>
                    <a :href="route('user.dashboard')" class="text-sm hover:text-blue-500">Dashboard</a>
                </li>
                <li>
                    <a :href="route('user.application')" class="text-sm hover:text-blue-500">Applications</a>
                </li>
            </ul>
        </div>
        <div class="w-8/12">
            <slot></slot>
        </div>
    </div>
</template>

<script>

</script>
