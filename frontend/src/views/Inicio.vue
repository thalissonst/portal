<script setup>
import { onMounted, reactive, ref, watch } from 'vue';

const nome = ref(null);

onMounted(() => {
    nome.value = sessionStorage.getItem("nome");
});

</script>

<template>
    <h6>Seja bem-vindo {{ nome }}!</h6>
</template>
