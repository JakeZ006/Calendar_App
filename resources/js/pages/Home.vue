<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { Settings } from "@lucide/vue";
import Sidebar from "@/lib/components/sidebar/Sidebar.vue";
import Calendar from "@/lib/components/calendar/Calendar.vue";

const sidebarOpen = ref(true);
</script>

<template>
  <Link class="settings-button icon-circle" href="/settings">
    <Settings color="var(--text-light)" size="2vw"/>
  </Link>

  <main :class="['layout', { 'sidebar-closed': !sidebarOpen }]">
    <Sidebar :sidebar-open />
    <Calendar :sidebar-open @toggle-sidebar="sidebarOpen = !sidebarOpen" />
  </main>
</template>
<style lang="scss" scoped>
.layout {
  display: grid;
  grid-template-columns: min(18vw, 700px) auto;
  align-items: center;
  transition: all cubic-bezier(0.16, 1, 0.3, 1) 1000ms;
}

.sidebar-closed {
  transform: translateX(calc(-1 * min(18vw, 700px)));
}

.settings-button {
  position: fixed;
  top: 16px;
  right: 16px;
  padding: 0.25vw;

  &:hover {
    background-color: var(--mix);
  }
}
</style>
