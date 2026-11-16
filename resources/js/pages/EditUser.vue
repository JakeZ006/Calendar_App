<script setup>
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const errors = page.props.errors;
</script>

<template>
  <div class="body app-page">
    <div class="account-form-card">
      <header class="account-form-header">
        <h1 class="account-form-title">Edit Account</h1>
      </header>
      <form class="form-stack" method="post" action="/updateUser">
        <div class="input-box form-field">
          <label for="old-username">Current Username</label>
          <input id="old-username" name="oldUsername" required />
        </div>
        <div class="input-box form-field">
          <label for="old-password">Current Password</label>
          <input id="old-password" name="oldPassword" required type="password" />
        </div>
        <div class="input-box form-field">
          <label for="new-sername">New Username</label>
          <input id="new-username" name="newUsername" required />
        </div>
        <div class="input-box form-field">
          <label for="new-password">New Password</label>
          <input id="new-password" name="newPassword" required type="password" />
        </div>
        <button class="update-button">Update</button>
        <p class="form-error" v-for="(val, key) in errors" :key="key">{{ val }}</p>
      </form>
    </div>
  </div>
</template>
<style lang="scss" scoped>
.input-box input {
  background-color: var(--white5);
}

#new-username {
  margin-top: clamp(0.75rem, 2.2vw, 4rem);
}

.update-button {
  width: 100%;
  margin: auto;
  padding: clamp(0.375rem, 0.55vw, 1.25rem) clamp(0.75rem, 1.1vw, 2.5rem);
  border-radius: clamp(0.375rem, 0.6vw, 1.25rem);
  font-size: clamp(0.875rem, 1.5vw, 2.0625rem);
  color: var(--text-light);
  background-color: var(--secondary);
}
</style>
