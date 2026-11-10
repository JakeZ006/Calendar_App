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
          :class="['theme-radio-button', 'pill-button', selectedTheme === 'light' ? 'selected-radio' : null]"
          for="light"
        >
          <Sun />
          <p>Light</p>
        </label>

        <label
          :class="['theme-radio-button', 'pill-button', selectedTheme === 'dark' ? 'selected-radio' : null]"
          for="dark"
        >
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
  margin-top: 16px;
  cursor: pointer;
}
.selected-radio {
  background-color: var(--white6);
}
</style>
