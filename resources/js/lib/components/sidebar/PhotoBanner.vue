<script setup>
import { usePage, Link } from "@inertiajs/vue3";
import { ImageUp } from "@lucide/vue";
import { computed, onMounted, ref } from "vue";

const page = usePage();
const photos = computed(() => page.props.photos ?? []);
const firstPhoto = ref();

const scrollspeed = computed(() => photos.value.length * 10);

onMounted(() => {
  firstPhoto.value = photos.value.length === 1 ? photos.value[0].url : null;
});
</script>

<template>
  <div class="banner-box">
    <Link href="/settings">
      <div
        class="banner-scroll-track"
        v-if="photos.length > 1"
        :style="`animation-duration: ${scrollspeed}s`"
      >
        <div class="photo" v-for="photo in photos" :key="`${photo.id}-1`">
          <img class="photo" :src="photo.url" />
        </div>
        <div class="photo-wrapper" v-for="photo in photos" :key="`${photo.id}-2`">
          <img class="photo" :src="photo.url" />
        </div>
      </div>
      <div v-else>
        <img class="photo-singular" v-if="firstPhoto" :src="firstPhoto" />
      </div>
      <div :class="['overlay', { empty: photos.length === 0 }]">
        <h1>Upload photos</h1>
        <ImageUp c size="32" />
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

.photo {
  max-width: none;
  height: 100%;
}

.photo-singular {
  width: 100cqi;
  height: 100cqh;
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

  svg {
    stroke: var(--text-light);
  }

  h1 {
    font-size: clamp(1.25rem, 8cqi, 3rem);
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
