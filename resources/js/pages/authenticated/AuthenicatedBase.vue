<template>
    <div>
        <div style="display: flex;">
            <div class="w-100 py-3 d-flex align-content-center justify-content-start" v-if="$route.name !== 'dashboard'">
                <router-link :to="{name: 'dashboard'}" class="ms-auto">Dashboard</router-link>
            </div>
            <div class="w-100 py-3 d-flex align-content-center justify-content-end">
                <router-link :to="{name: 'logout'}" class="ms-auto">Logout</router-link>
            </div>
        </div>

        <router-view></router-view>
    </div>
</template>

<script>
export default {

}
</script>
