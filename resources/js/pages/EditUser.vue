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
  margin-top: 32px;
}

.update-button {
  width: 100%;
  margin: auto;
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 22px;
  color: var(--text-light);
  background-color: var(--secondary);
}
</style>
