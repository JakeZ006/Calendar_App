<script setup>
import { usePage, Form } from "@inertiajs/vue3";
import { computed } from 'vue';

const page = usePage();
const errors = computed(() => page.props.errors);
</script>

<template>
  <div class="body app-page">
    <div class="account-form-card">
      <header class="account-form-header">
        <h1 class="account-form-title">Delete Account</h1>
      </header>
      <Form class="form-stack" method="post" action="/deleteUser" resetOnSuccess>
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
      </Form>
    </div>
  </div>
</template>
<style lang="scss" scoped>
.delete-button {
  width: 100%;
  margin: auto;
  padding: clamp(0.375rem, 0.55vw, 1.25rem) clamp(0.75rem, 1.1vw, 2.5rem);
  border-radius: clamp(0.375rem, 0.6vw, 1.25rem);
  font-size: clamp(0.875rem, 1.5vw, 2.0625rem);
  color: var(--text-light);
  background-color: var(--color-red-800);
}
</style>
