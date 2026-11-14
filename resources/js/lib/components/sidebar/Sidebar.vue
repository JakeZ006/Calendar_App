<script setup>
import DateTime from "./DateTime.vue";
import TodoDisplay from "./TodoDisplay.vue";
import Other from "./Other.vue";

const { sidebarOpen } = defineProps(["sidebarOpen"]);
</script>

<template>
  <div class="sidebar-wrapper" :class="{ 'sidebar-closed': !sidebarOpen }">
    <DateTime />
    <TodoDisplay />
    <Other />
  </div>
</template>

<style lang="scss" scoped>
.sidebar-wrapper {
  container-type: inline-size;
  display: grid;
  align-items: center;
  gap: 16px;
  height: 100vh;
  padding: 12px;
  transition: all cubic-bezier(0.16, 1, 0.3, 1) 400ms;
  &.sidebar-closed {
    transform: translateX(-100%);
  }
}
</style>
