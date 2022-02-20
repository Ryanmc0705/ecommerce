<template>
  <div>
    <v-alert outlined :type="type" text>
        {{message}}
    </v-alert>
  </div>
</template>
<script>
export default {
  props: { type: String, message: String },
};
</script>