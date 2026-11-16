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
  width: min(80vw, 3400px);
}

.main {
  gap: clamp(1.5rem, 2.2vw, 4rem);
  padding: clamp(2rem, 4.4vw, 8rem) clamp(3rem, 10.4vw, 18rem);
}

.settings-top {
  display: flex;
  justify-content: space-between;
}
</style>
