<script setup>
import { UserPen, User, Trash } from "@lucide/vue";
import { usePage, Link } from "@inertiajs/vue3";

const user = usePage().props.auth.user;
</script>
<template>
  <div class="theme-settings settings-top-card">
    <div class="settings-title">
      <User size="32" stroke-width="2.5" />
      <h1>Account</h1>
    </div>
    <p>{{ user.username }}</p>
    <div class="button-wrapper">
      <Link class="account-button edit-account-button" href="/editUser">
        <UserPen />
        <p>Edit</p>
      </Link>
      <Link class="account-button delete-account-button" href="/deleteUser">
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
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 16px;
  padding: 8px 16px;
  font-size: 24px;
  border: 1px solid black;
  border-radius: 32px;
  p {
    font-size: 22px;
  }
}
</style>
