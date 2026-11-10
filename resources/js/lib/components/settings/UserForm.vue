<script setup>
import { usePage, Link } from "@inertiajs/vue3";

const page = usePage();
let url = page.url;
const errors = page.props.errors;

if (url === "/") {
  url = "/register";
}

const title = url.charAt(1).toUpperCase() + url.slice(2);
</script>

<template>
  <div class="account-form-card">
    <header class="account-form-header">
      <h1 class="account-form-title">{{ title }}</h1>
      <div v-if="url === '/login'" class="redirect-wrapper">
        <p>Don't have an account ?</p>
        <Link class="redirect-button" href="/register">Register here</Link>
      </div>
      <div v-else class="redirect-wrapper">
        <p>Already have an account ?</p>
        <Link class="redirect-button" href="login">Login here</Link>
      </div>
    </header>
    <form class="form-stack" method="post" :action="url">
      <div class="input-box form-field">
        <label for="username">Username</label>
        <input id="username" name="username" required />
      </div>
      <div class="input-box form-field">
        <label for="password">password</label>
        <input id="password" name="password" required type="password" />
      </div>
      <button class="login-button button-primary">{{ url === "/register" ? "Register" : "Login" }}</button>
      <p v-for="(val, key) in errors" :key="key" class="form-error">{{ val }}</p>
    </form>
  </div>
</template>
<style lang="scss" scoped>
.redirect-wrapper {
  display: flex;
  gap: 8px;
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
  padding: 8px 16px;
  font-size: 22px;
  border-radius: 8px;
}
</style>
