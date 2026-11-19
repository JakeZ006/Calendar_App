<script setup>
import QuoteDisplayer from "./QuoteDisplayer.vue";
import PhotoBanner from "./PhotoBanner.vue";
</script>

<template>
  <div class="other-wrapper">
    <QuoteDisplayer />
    <PhotoBanner />
  </div>
</template>

<style lang="scss" scoped>
.other-wrapper {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%;
  padding: 16px;
  padding-top: 8px;
  border-radius: var(--radius-sidebar);
  background-color: var(--white2);
}
</style>
