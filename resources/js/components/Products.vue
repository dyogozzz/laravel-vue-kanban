<script setup>
import {ref} from 'vue';

const name = ref('')
</script>
<template>

{{ name }}
<br>
<input type="text" v-model="name">

</template>