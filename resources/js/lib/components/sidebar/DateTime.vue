<script setup>
import { useDate } from "../../composables/date";
import { onMounted, onUnmounted, ref } from "vue";

const date = useDate();

const timeString = ref(date.timeString);

onMounted(() => {
  setInterval(() => {
    timeString.value = Temporal.Now.instant().toString().substring(11, 19);
  }, 1000);
});
</script>

<template>
  <div class="datetime-box">
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
  </div>
</template>

<style lang="scss">
.datetime-box {
  container-name: datetime;
  height: fit-content;
  padding: 0 32px;
  padding-bottom: 16px;
  border-radius: 32px;
  background-image: radial-gradient(circle at -100% -150%, var(--secondary), var(--primary));
}

.datetime-wrapper {
  display: flex;
  flex-direction: column;
  width: fit-content;
  margin: auto;

  & > * {
    z-index: 2;
  }
}

.digital-clock {
  display: flex;
  align-self: center;
  font-family: var(--font-datetime);
  font-size: max(3rem, 18cqi);
  font-weight: 500;
  color: var(--text-light);
  letter-spacing: -0.08em;
}

.date-wrapper {
  font-family: var(--font-datetime);
  font-size: clamp(1.125rem, 7cqi, 4rem);
  font-weight: 500;
  white-space: nowrap;

  h2 {
    margin-top: -6px;
    color: var(--text-light);
  }

  sup {
    font-size: clamp(0.6875rem, 3cqi, 1.5rem);
    color: var(--text-light);
    vertical-align: 1.5cqi;
  }
}
</style>
