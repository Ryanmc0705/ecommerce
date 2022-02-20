<template>
    <div>
        <small style="color:red" v-for="(error,keys) in errors" :key="keys">{{error}}</small>
    </div>
</template>
<script>
export default {
    props:["errors"]
}
</script>