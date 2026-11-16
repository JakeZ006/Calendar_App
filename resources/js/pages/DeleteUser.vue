<script setup>
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const errors = page.props.errors;
</script>

<template>
  <div class="body app-page">
    <div class="account-form-card">
      <header class="account-form-header">
        <h1 class="account-form-title">Delete Account</h1>
      </header>
      <form class="form-stack" method="post" action="/deleteUser">
        <div class="input-box form-field">
          <label for="username">Username</label>
          <input id="username" name="username" required />
        </div>
        <div class="input-box form-field">
          <label for="password">Password</label>
          <input id="password" name="password" required type="password" />
        </div>
        <button class="delete-button">Delete</button>
        <p class="form-error" v-for="(val, key) in errors" :key="key">{{ val }}</p>
      </form>
    </div>
  </div>
</template>
<style lang="scss" scoped>
.delete-button {
  width: 100%;
  margin: auto;
  padding: 8px 16px;
  border-radius: 8px;
  font-size: clamp(1rem, 1.5vw, 2.0625rem);
  color: var(--text-light);
  background-color: var(--color-red-800);
}
</style>
