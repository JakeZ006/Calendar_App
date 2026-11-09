<script setup>
import SettingsNav from "@/lib/components/settings/SettingsNav.vue";
import ThemeCard from "@/lib/components/settings/ThemeCard.vue";
import AccountCard from "@/lib/components/settings/AccountCard.vue";
import PhotoCard from "@/lib/components/settings/PhotoCard.vue";
</script>

<template>
  <div class="body">
    <header>
      <SettingsNav />
    </header>
    <main class="main">
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
  display: grid;
  grid-template-rows: auto 1fr;
  min-height: 100vh;
  max-width: min(90vw, 1200px);
  margin: auto;
  background-color: var(--white2);
}
.main {
  display: flex;
  flex-direction: column;
  gap: 32px;
  padding: 64px 150px;
}
.settings-top {
  display: flex;
  justify-content: space-between;
}
</style>
