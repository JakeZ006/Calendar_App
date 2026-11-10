<script setup>
import { Home, LogOut } from "@lucide/vue";
import { Link } from "@inertiajs/vue3";
</script>
<template>
  <nav class="navbar">
    <div class="navbar-left">
      <Link class="nav-button" href="/home">
        <Home color="var(--text-light)" />
        <p>Home</p>
      </Link>
      <Link class="nav-button" as="button" href="/logout" method="post">
        <LogOut color="var(--text-light)" />
        <p>Logout</p>
      </Link>
    </div>
  </nav>
</template>
<style lang="scss" scoped>
.navbar {
  display: flex;
  align-items: center;
  justify-content: end;
  width: 100%;
  height: 64px;
  background-image: var(--gradient-primary);
}
.navbar-left {
  display: flex;
  gap: 16px;
  padding: 0 8px;
}
.nav-button {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 4px 8px;
  font-size: 20px;
  border: 2px solid var(--text-light);
  border-radius: 16px;
  &:hover {
    background-color: var(--mix);
  }
  &:active {
    background-color: var(--primary);
  }
  p {
    color: var(--text-light);
  }
}
</style>
