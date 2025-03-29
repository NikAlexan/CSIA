<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <svg width="128" height="128" viewBox="0 0 128 128" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Hexagonal background shield -->
        <path d="M64 12L116 36V92L64 116L12 92V36L64 12Z" fill="url(#gradient)"/>

        <!-- Gradient definition -->
        <defs>
            <linearGradient id="gradient" x1="64" y1="12" x2="64" y2="116" gradientUnits="userSpaceOnUse">
                <stop stop-color="#003366"/> <!-- Dark blue (tech) -->
                <stop offset="1" stop-color="#228833"/> <!-- Green (agro) -->
            </linearGradient>
        </defs>

        <!-- Circuit pattern (top tech half) -->
        <path d="M40 40H48M64 32V40M88 40H80M56 48H72M64 56V48" stroke="#FFD700" stroke-width="2" stroke-linecap="round"/>
        <circle cx="64" cy="40" r="4" fill="#FFD700"/>

        <!-- Wheat stalks (bottom agro half) -->
        <path d="M56 80L60 68M64 80L68 68M72 80L76 68" stroke="#FFD700" stroke-width="2" stroke-linecap="round"/>
        <path d="M58 88L62 76M66 88L70 76M74 88L78 76" stroke="#FFD700" stroke-width="2" stroke-linecap="round"/>

        <!-- CSIA text -->
        <text x="64" y="60" text-anchor="middle" font-family="Arial" font-size="16" font-weight="bold" fill="white">CSIA</text>
        <text x="64" y="78" text-anchor="middle" font-family="Arial" font-size="8" fill="#FFD700">AITU</text>

        <!-- Kazakhstan stars -->
        <circle cx="64" cy="28" r="3" fill="#FFD700"/>
        <circle cx="52" cy="32" r="2" fill="#FFD700"/>
        <circle cx="76" cy="32" r="2" fill="#FFD700"/>
    </svg>
</template>
