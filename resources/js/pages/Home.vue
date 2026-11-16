<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { Settings } from "@lucide/vue";
import Sidebar from "@/lib/components/sidebar/Sidebar.vue";
import Calendar from "@/lib/components/calendar/Calendar.vue";

const sidebarOpen = ref(true);
</script>

<template>
  <Link class="settings-button icon-circle" href="/settings"
    ><Settings color="var(--text-light)" :size="32"
  /></Link>

  <main :class="['layout', { 'sidebar-closed': !sidebarOpen }]">
    <Sidebar :sidebar-open />
    <Calendar :sidebar-open @toggle-sidebar="sidebarOpen = !sidebarOpen" />
  </main>
</template>
<style lang="scss" scoped>
.layout {
  display: grid;
  grid-template-columns: min(22vw, 700px) auto;
  align-items: center;
  transition: all cubic-bezier(0.16, 1, 0.3, 1) 400ms;
}

.sidebar-closed {
  transform: translateX(calc(-1 * min(25vw, 700px)));
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
