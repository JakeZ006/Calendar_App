<script setup>
import { usePage, Link, Form } from "@inertiajs/vue3";
import { computed } from "vue";


const page = usePage();
let url = page.url;
const errors = computed(() =>page.props.errors);

if (url === "/") {
  url = "/register";
}

const title = url.charAt(1).toUpperCase() + url.slice(2);
</script>

<template>
  <div class="account-form-card">
    <header class="account-form-header">
      <h1 class="account-form-title">{{ title }}</h1>
      <div class="redirect-wrapper" v-if="url === '/login'">
        <p>Don't have an account?</p>
        <Link class="redirect-button" href="/register">Register here</Link>
      </div>
      <div class="redirect-wrapper" v-else>
        <p>Already have an account?</p>
        <Link class="redirect-button" href="login">Log in here</Link>
      </div>
    </header>
    <Form class="form-stack" method="post" :action="url">
      <div class="input-box form-field">
        <label for="username">Username</label>
        <input id="username" name="username" required />
        <p class="form-error">{{ errors.username}}</p>
      </div>
      <div class="input-box form-field">
        <label for="password">Password</label>
        <input id="password" name="password" required type="password" />
        <p class="form-error" >{{ errors.password }}</p>
      </div>
      <button class="login-button button-primary">
        {{ url === "/register" ? "Register" : "Log in" }}
      </button>
    </Form>
  </div>
</template>
<style lang="scss" scoped>
.redirect-wrapper {
  display: flex;
  gap: clamp(0.375rem, 0.6vw, 1.25rem);
}

.redirect-button {
  font-weight: 700;
  text-decoration: underline;
}

.input-box input {
  background-color: var(--white6);
}

.login-button {
  width: fit-content;
  margin-left: auto;
  padding: clamp(0.375rem, 0.55vw, 1.25rem) clamp(0.75rem, 1.1vw, 2.5rem);
  border-radius: clamp(0.375rem, 0.6vw, 1.25rem);
  font-size: clamp(0.875rem, 1.5vw, 2.0625rem);
}
</style>
