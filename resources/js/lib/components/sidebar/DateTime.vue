<script setup>
import { useDate } from "../../composables/date";
import { onMounted, onUnmounted, ref } from "vue";

const date = useDate();

const timeString = ref(date.timeString);
let clock;

onMounted(() => {
  clock = setInterval(() => {
    timeString.value = Temporal.Now.instant().toString().substring(11, 19);
  }, 1000);
});

onUnmounted(() => clearInterval(clock));
</script>

<template>
  <div class="datetime-wrapper">
    <h1 class="digital-clock" data-allow-mismatch>{{ timeString }}</h1>
    <div class="date-wrapper">
      <h2 class="date-text">
        {{ date.dayName }}
        {{ date.day }}<sup>{{ date.daySuffix }}</sup>
      </h2>
      <h2 class="date-text">
        {{ date.monthName }}
        {{ date.year }}
      </h2>
    </div>
  </div>
</template>

<style lang="scss">
.datetime-wrapper {
  container-name: datetime;
  display: flex;
  flex-direction: column;
  height: fit-content;
  padding: 0 32px;
  background-image: radial-gradient(circle at -100% -150%, var(--secondary), var(--primary));
  border-radius: 32px;
  padding-bottom: 16px;
  & > * {
    z-index: 2;
  }
}
.digital-clock {
  display: flex;
  align-self: center;
  font-family: var(--font-datetime);
  font-size: clamp(64px, 20cqi, 82px);
  font-weight: 500;
  letter-spacing: -5px;
  color: var(--text-light);
}
.date-wrapper {
  font-family: var(--font-datetime);
  font-size: clamp(18px, 7cqi, 32px);
  font-weight: 500;
  white-space: nowrap;
  h2 {
    margin-top: -6px;
    color: var(--text-light);
  }
  sup {
    font-size: clamp(11px, 3cqi, 16px);
    vertical-align: 1.5cqi;
    color: var(--text-light);
  }
}
</style>
