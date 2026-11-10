<script setup>
import SettingsNav from "@/lib/components/settings/SettingsNav.vue";
import ThemeCard from "@/lib/components/settings/ThemeCard.vue";
import AccountCard from "@/lib/components/settings/AccountCard.vue";
import PhotoCard from "@/lib/components/settings/PhotoCard.vue";
</script>

<template>
  <div class="body app-page">
    <header>
      <SettingsNav />
    </header>
    <main class="main app-page-main">
      <div class="settings-top">
        <ThemeCard />
        <AccountCard />
      </div>
      <PhotoCard />
    </main>
  </div>
</template>

<style lang="scss" scoped>
.body {
  --page-max-width: min(90vw, 1200px);
}
.settings-top {
  display: flex;
  justify-content: space-between;
}
</style>
