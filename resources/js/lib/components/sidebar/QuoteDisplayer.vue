<script setup>
import { computed, reactive, ref } from "vue";
import { usePage } from "@inertiajs/vue3";

const quotes = usePage().props.quotes ?? [];
const index = ref(Math.floor(Math.random() * quotes.length));
const quote = computed(() => quotes[index.value]);
const previous = reactive([]);

function getQuote() {
  index.value = Math.floor(Math.random() * quotes.length);
  if (previous.includes(index.value)) {
    getQuote();
  }
  if (previous.length >= 3) {
    previous.shift();
  }
  previous.push(index.value);
}
</script>

<template>
  <div class="quote-wrapper" data-allow-mismatch @click="getQuote">
    <h2 class="quote-content">{{ quote.quote }}</h2>
    <h3 class="quote-info">- {{ quote.author }}, {{ quote.source }}</h3>
  </div>
</template>

<style lang="scss" scoped>
.quote-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2px;
  margin-bottom: 8px;
  padding-bottom: 4px;
  border-bottom: 2px solid var(--white6);
  cursor: pointer;
  user-select: none;
  .quote-content {
    font-size: 4.5cqi;
    text-align: center;
  }
  .quote-info {
    font-size: 4cqi;
    font-weight: 300;
  }
}
</style>
