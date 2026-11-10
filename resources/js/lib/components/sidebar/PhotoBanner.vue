<script setup>
import { usePage, Link } from "@inertiajs/vue3";
import { ImageUp } from "@lucide/vue";
import { computed, onMounted, ref } from "vue";

const images = ref([]);
const firstImage = ref(null);

const scrollspeed = computed(() => images.value.length * 10 ?? 15);

onMounted(() => {
  images.value = usePage().props.images ?? [];
  firstImage.value = images.value[0]?.path ?? null;
});
</script>

<template>
  <div class="banner-box">
    <Link href="/settings">
      <div
        v-if="images.length > 1"
        class="banner-scroll-track"
        :style="`animation-duration: ${scrollspeed}s`"
      >
        <div v-for="image in images" :key="`${image.id}-1`" class="image-wrapper">
          <img class="image" :src="`storage/${image.path}`" />
        </div>
        <div v-for="image in images" :key="`${image.id}-2`" class="image-wrapper">
          <img class="image" :src="`storage/${image.path}`" />
        </div>
      </div>
      <div v-else>
        <img v-if="firstImage" class="image" :src="`storage/${firstImage}`" />
      </div>
      <div class="overlay" :style="images.length === 0 ? 'opacity:1' : null">
        <h1>Upload Images</h1>
        <ImageUp color="var(--text-light)" size="32" />
      </div>
    </Link>
  </div>
</template>

<style lang="scss" scoped>
.banner-box {
  container-type: size;
  position: relative;
  width: 100%;
  height: 70%;
  overflow: hidden;
  border-radius: 16px;
}
.banner-scroll-track {
  display: inline-flex;
  height: 100%;
  animation: banner-scroll linear infinite;
}
.image {
  max-width: none;
  height: 100%;
}
.overlay {
  position: absolute;
  inset: 0;
  z-index: 50;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 8px;
  background-color: hsla(0, 0%, 0%, 0.5);
  opacity: 0;
  h1 {
    font-size: 32px;
    color: var(--text-light);
  }
  &:hover {
    opacity: 1;
  }
}

@keyframes banner-scroll {
  from {
    transform: translateX(0);
  }
  to {
    transform: translateX(-50%);
  }
}
</style>
