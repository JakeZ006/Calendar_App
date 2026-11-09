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
  height: 35cqh;
  padding: 16px;
  background-color: var(--white2);
  border-radius: 16px;
}
</style>
