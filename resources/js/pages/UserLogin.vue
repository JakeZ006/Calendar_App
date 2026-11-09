<script setup>
import UserForm from "@/lib/components/settings/UserForm.vue";
</script>
<template>
  <div class="login-body">
    <UserForm />
  </div>
</template>

<style lang="scss" scoped>
.login-body {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 32px;
  min-height: 100vh;
  max-width: clamp(800px, 70vw, 1200px);
  margin: auto;
  padding: 64px 150px;
  background-color: var(--white6);
}
</style>
