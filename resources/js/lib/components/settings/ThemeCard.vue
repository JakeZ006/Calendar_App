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
  <div class="theme-settings settings-top-card">
    <div class="settings-title">
      <Palette size="32" stroke-width="2.5" />
      <h1>Theme</h1>
    </div>

    <form>
      <div class="form-wrapper">
        <label
          :class="['theme-radio-button', selectedTheme === 'light' ? 'selected-radio' : null]"
          for="light"
        >
          <Sun />
          <p>Light</p>
        </label>

        <label :class="['theme-radio-button', selectedTheme === 'dark' ? 'selected-radio' : null]" for="dark">
          <Moon />
          <p>Dark</p>
        </label>
      </div>
      <input v-show="false" id="light" v-model="selectedTheme" name="theme" type="radio" value="light" />
      <input v-show="false" id="dark" v-model="selectedTheme" name="theme" type="radio" value="dark" />
    </form>
  </div>
</template>
<style lang="scss" scoped>
.form-wrapper {
  display: flex;
  gap: 16px;
}
.theme-radio-button {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 16px;
  padding: 8px 16px;
  font-size: 24px;
  border: 1px solid var(--text-dark);
  border-radius: 32px;
  cursor: pointer;
  p {
    font-size: 22px;
  }
}
.selected-radio {
  background-color: var(--white6);
}
</style>
