<template>
    <div></div>
</template>

<script>
import User from '../../src/apis/User'
export default {
    async beforeMount() {
        await localStorage.removeItem('authToken');
        this.$router.push({name: 'login'});
    }
}
</script>
