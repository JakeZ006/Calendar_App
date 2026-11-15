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
        class="banner-scroll-track"
        v-if="images.length > 1"
        :style="`animation-duration: ${scrollspeed}s`"
      >
        <div class="image-wrapper" v-for="image in images" :key="`${image.id}-1`">
          <img class="image" :src="image.path" />
        </div>
        <div class="image-wrapper" v-for="image in images" :key="`${image.id}-2`">
          <img class="image" :src="image.path" />
        </div>
      </div>
      <div v-else>
        <img class="image" v-if="firstImage" :src="firstImage" />
      </div>
      <div class="overlay" :class="{ empty: images.length === 0 }">
        <h1>Upload images</h1>
        <ImageUp color="var(--text-light)" size="32" />
      </div>
    </Link>
  </div>
</template>

<style lang="scss" scoped>
.banner-box {
  position: relative;
  container-type: size;
  overflow: hidden;
  width: 100%;
  height: 100%;
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
  z-index: 50;
  inset: 0;
  display: flex;
  gap: 8px;
  align-items: center;
  justify-content: center;
  opacity: 0;
  background-color: hsl(0 0% 0% / 50%);

  h1 {
    font-size: 32px;
    color: var(--text-light);
  }

  &:hover {
    opacity: 1;
  }

  &.empty {
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
