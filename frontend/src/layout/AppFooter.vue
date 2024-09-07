<script setup>
import { useLayout } from '@/layout/composables/layout';
import { computed } from 'vue';

const { layoutConfig } = useLayout();

const logoUrl = computed(() => {
    return ``;
});
</script>

<template>
    <div class="layout-footer">
        <small class="font-medium ml-2">© Copyright | All rights reserved. </small>
    </div>
</template>

<style lang="scss" scoped></style>
