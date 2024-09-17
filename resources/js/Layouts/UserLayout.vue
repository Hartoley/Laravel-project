<template>
    <nav class="py-4 bg-blue-300"></nav>
    <div class="flex">
        <div class="w-3/12 bg-orange-300 h-screen">
            <ul>
                <li>
                    <Link href="user_dashboard">Dashboard</Link>
                </li>
                <li>
                    <Link href="user_application">Applications</Link>
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