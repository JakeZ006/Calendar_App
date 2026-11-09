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
  <div class="form-box">
    <header class="form-box-header">
      <h1 class="title">{{ title }}</h1>
      <div v-if="url === '/login'" class="redirect-wrapper">
        <p>Don't have an account ?</p>
        <Link class="redirect-button" href="/register">Register here</Link>
      </div>
      <div v-else class="redirect-wrapper">
        <p>Already have an account ?</p>
        <Link class="redirect-button" href="login">Login here</Link>
      </div>
    </header>
    <form class="form" method="post" :action="url">
      <div class="input-box">
        <label for="username">Username</label>
        <input id="username" name="username" required />
      </div>
      <div class="input-box">
        <label for="password">password</label>
        <input id="password" name="password" required type="password" />
      </div>
      <button class="login-button">{{ url === "/register" ? "Register" : "Login" }}</button>
      <p v-for="(val, key) in errors" :key="key" class="error-message">{{ val }}</p>
    </form>
  </div>
</template>
<style lang="scss" scoped>
.form-box {
  container-type: inline-size;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  height: 30%;
  padding: 32px;
  background-color: var(--white2);
  border-radius: 16px;
}
.form-box-header {
  display: flex;
  justify-content: space-between;
  width: 100%;
}
.title {
  font-size: 32px;
  text-decoration: underline;
}
.redirect-wrapper {
  display: flex;
  gap: 8px;
}
.redirect-button {
  font-weight: 700;
  text-decoration: underline;
}

.form {
  display: flex;
  flex-direction: column;
  gap: 24px;
  margin-top: 10%;
}
.input-box {
  display: flex;
  flex-direction: column;
  gap: 8px;
  input {
    width: 60cqi;
    padding: 0 12px;
    font-size: 22px;
    border-radius: 4px;
  }
}
.login-button {
  width: fit-content;
  margin-left: auto;
  padding: 8px 16px;
  font-size: 22px;
  color: var(--text-light);
  background-image: radial-gradient(circle at 30% 10%, var(--mix), var(--primary));
  border-radius: 8px;
}
.error-message {
  color: var(--red);
}
</style>
