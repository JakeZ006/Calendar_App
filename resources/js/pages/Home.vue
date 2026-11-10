<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { Settings } from "@lucide/vue";
import Sidebar from "@/lib/components/sidebar/Sidebar.vue";
import Calendar from "@/lib/components/calendar/Calendar.vue";

const sidebarOpen = ref(true);
</script>

<template>
  <Head title="Calendar">
    <link href="https://rsms.me/" rel="preconnect" />
    <link href="https://rsms.me/inter/inter.css" rel="stylesheet" />
  </Head>

  <Link class="settings-button icon-circle" href="/settings"
    ><Settings color="var(--text-light)" :size="32"
  /></Link>

  <main class="layout">
    <Sidebar :sidebar-open="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen" />
    <Calendar :sidebar-open="sidebarOpen" />
  </main>
</template>
<style lang="scss" scoped>
.layout {
  display: grid;
  grid-template-columns: min(25vw, 440px) auto;
  align-items: center;
  gap: 64px;
  background-color: var(--white5);
}
.settings-button {
  position: fixed;
  top: 16px;
  right: 16px;
  width: 48px;
  &:hover {
    background-color: var(--mix);
  }
}
</style>
