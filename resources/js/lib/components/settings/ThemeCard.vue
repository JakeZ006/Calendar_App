<script setup>
import { Palette, Sun, Moon } from "@lucide/vue";
import { computed } from "vue";
import { useDark } from "@vueuse/core";

const isDark = useDark({
  storageKey: "theme",
});

const selectedTheme = computed({
  get: () => (isDark.value ? "dark" : "light"),
  set: (theme) => {
    isDark.value = theme === "dark";
  },
});
</script>
<template>
  <div class="theme-settings settings-top-card settings-card">
    <div class="settings-title">
      <Palette size="32" stroke-width="2.5" />
      <h1>Theme</h1>
    </div>

    <form>
      <div class="form-wrapper">
        <label
          :class="[
            'theme-radio-button',
            'pill-button',
            { 'selected-radio': selectedTheme === 'light' },
          ]"
          for="light"
        >
          <Sun />
          <p>Light</p>
        </label>

        <label
          :class="[
            'theme-radio-button',
            'pill-button',
            { 'selected-radio': selectedTheme === 'dark' },
          ]"
          for="dark"
        >
          <Moon />
          <p>Dark</p>
        </label>
      </div>
      <input
        id="light"
        v-show="false"
        v-model="selectedTheme"
        name="theme"
        type="radio"
        value="light"
      />
      <input
        id="dark"
        v-show="false"
        v-model="selectedTheme"
        name="theme"
        type="radio"
        value="dark"
      />
    </form>
  </div>
</template>
<style lang="scss" scoped>
.form-wrapper {
  display: flex;
  gap: clamp(1rem, 1.1vw, 2.5rem);
}

.theme-radio-button {
  cursor: pointer;
  margin-top: clamp(1rem, 1.1vw, 2.5rem);
}

.selected-radio {
  background-color: var(--white6);
}
</style>
