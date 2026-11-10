<script setup>
import { usePage, Link } from "@inertiajs/vue3";

const page = usePage();
let url = page.url;
const errors = page.props.errors;
</script>

<template>
  <div class="body">
    <div class="form-box">
      <header class="form-box-header">
        <h1 class="title">Edit Account</h1>
      </header>
      <form class="form" method="post" action="/updateUser">
        <div class="input-box">
          <label for="oldUsername">Current Username</label>
          <input id="oldUsername" name="oldUsername" required />
        </div>
        <div class="input-box">
          <label for="oldPassword">Current Password</label>
          <input id="oldPassword" name="oldPassword" required type="password" />
        </div>
        <div class="input-box">
          <label for="newUsername">New Username</label>
          <input id="NewUsername" name="newUsername" required />
        </div>
        <div class="input-box">
          <label for="newPassword">New Password</label>
          <input id="newPassword" name="newPassword" required type="password" />
        </div>
        <button class="update-button">Update</button>
        <p v-for="(val, key) in errors" :key="key" class="error-message">{{ val }}</p>
      </form>
    </div>
  </div>
</template>
<style lang="scss" scoped>
.body {
  display: grid;
  grid-template-rows: auto 1fr;
  min-height: 100vh;
  max-width: clamp(800px, 70vw, 1200px);
  margin: auto;
  background-color: var(--white2);
}
.main {
  display: flex;
  flex-direction: column;
  gap: 32px;
  padding: 64px 150px;
}
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
    background-color: var(--white5);
    width: 60cqi;
    padding: 0 12px;
    font-size: 22px;
    border-radius: 4px;
  }
}
#newUsername {
  margin-top: 32px;
}
.update-button {
  width: fit-content;
  margin: auto;
  width: 100%;
  padding: 8px 16px;
  font-size: 22px;
  color: var(--text-light);
  background-color: var(--secondary);
  border-radius: 8px;
}
.error-message {
  color: var(--red);
}
</style>
