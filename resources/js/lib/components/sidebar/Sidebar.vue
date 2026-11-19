<script setup>
import DateTime from "./DateTime.vue";
import TodoDisplay from "./TodoDisplay.vue";
import Other from "./Other.vue";

const { sidebarOpen } = defineProps(["sidebarOpen"]);
</script>

<template>
  <div :class="['sidebar-wrapper', { 'sidebar-closed': !sidebarOpen }]">
    <DateTime />
    <TodoDisplay />
    <Other />
  </div>
</template>

<style lang="scss" scoped>
.sidebar-wrapper {
  container-type: inline-size;
  display: grid;
  grid-template-rows: auto 1.25fr 1fr;
  gap: 3vh;
  align-items: center;
  max-width: 18vw;
  height: 100vh;
  padding: 12px;
  transition: all cubic-bezier(0.16, 1, 0.3, 1) 400ms;

  & > * {
    max-width: calc(min(22vw, 700px) - 24px);
  }
}
</style>
