<template>
    <div>
        <button @click="test">Test Only</button>
    </div>
</template>

<script>
export default {
    methods:{
        test(){
            this.$emit("testEmit","test data");
        }
    }
}
</script>

<style>

</style>