<template>
    <div class="preloader">
        <div class="loader"></div>
    </div>
</template>
  
<script>

export default {
    name: 'Preloader'
}
</script>

<style scoped>
.preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.8); /* fundo branco translúcido */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999; /* z-index alto para garantir que fique acima de todos os outros elementos */
}

.loader {
    border: 8px solid #f3f3f3; /* cinza claro */
    border-top: 8px solid #3498db; /* azul */
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite; /* animação de rotação */
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
  