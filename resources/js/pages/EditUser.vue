<script setup>
import { usePage, Link } from "@inertiajs/vue3";

const page = usePage();
let url = page.url;
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
          <label for="oldUsername">Current Username</label>
          <input id="oldUsername" name="oldUsername" required />
        </div>
        <div class="input-box form-field">
          <label for="oldPassword">Current Password</label>
          <input id="oldPassword" name="oldPassword" required type="password" />
        </div>
        <div class="input-box form-field">
          <label for="newUsername">New Username</label>
          <input id="NewUsername" name="newUsername" required />
        </div>
        <div class="input-box form-field">
          <label for="newPassword">New Password</label>
          <input id="newPassword" name="newPassword" required type="password" />
        </div>
        <button class="update-button">Update</button>
        <p v-for="(val, key) in errors" :key="key" class="form-error">{{ val }}</p>
      </form>
    </div>
  </div>
</template>
<style lang="scss" scoped>
.input-box input {
  background-color: var(--white5);
}
#newUsername {
  margin-top: 32px;
}
.update-button {
  width: 100%;
  margin: auto;
  padding: 8px 16px;
  font-size: 22px;
  color: var(--text-light);
  background-color: var(--secondary);
  border-radius: 8px;
}
</style>
