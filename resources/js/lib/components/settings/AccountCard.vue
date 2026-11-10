<script setup>
import { UserPen, User, Trash } from "@lucide/vue";
import { usePage, Link } from "@inertiajs/vue3";

const user = usePage().props.auth.user;
</script>
<template>
  <div class="theme-settings settings-top-card settings-card">
    <div class="settings-title">
      <User size="32" stroke-width="2.5" />
      <h1>Account</h1>
    </div>
    <p>{{ user.username }}</p>
    <div class="button-wrapper">
      <Link class="account-button pill-button edit-account-button" href="/editUser">
        <UserPen />
        <p>Edit</p>
      </Link>
      <Link class="account-button pill-button delete-account-button" href="/deleteUser">
        <Trash color="var(--red)" />
        <p>Delete</p>
      </Link>
    </div>
  </div>
</template>
<style lang="scss" scoped>
.button-wrapper {
  display: flex;
  gap: 16px;
}

.account-button {
  margin-top: 16px;
  border-color: black;
}
</style>
