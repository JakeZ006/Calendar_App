<script setup>
import { ImageUp, Trash, Image, Upload } from "@lucide/vue";
import { computed, ref, watchEffect } from "vue";
import { usePage, Form, router } from "@inertiajs/vue3";

const page = usePage();
const photos = computed(() => page.props.photos ?? []);
const selectedPhoto = ref("");
const uploadedPhoto = ref(false);

const errors = computed(() => page.props.errors ?? []);

const refresh = () => {
  selectedPhoto.value = "";
  uploadedPhoto.value = false;
  router.reload({
    only: ["photos"],
  });
};
</script>
<template>
  <div class="photo-settings settings-card">
    <div class="settings-title">
      <Image size="32" stroke-width="2.5" />
      <h1>Photos</h1>
    </div>

    <div class="photo-settings-wrapper">
      <div class="list-wrapper">
        <ul>
          <li
            class="list-item"
            v-for="photo in photos"
            :key="photo.id"
            :class="{ 'selected-photo': selectedPhoto === photo.url ?? photo.path }"
          >
            <button @click="selectedPhoto = photo.url ?? photo.path">{{ photo.name }}</button>
            <Form :action="`/deletePhoto/${photo.id}`" method="delete" @success="refresh">
              <input type="hidden" name="id" :value="photo.id" />
              <button class="delete-photo-button"><Trash /></button>
            </Form>
          </li>
          <li class="works-better">(Works better with more photos)</li>
        </ul>
      </div>

      <div class="upload-photo-box">
        <div class="photo-box">
          <img class="photo" v-if="selectedPhoto" :src="`storage/${selectedPhoto}`" />
        </div>

        <Form
          action="/uploadPhoto"
          enctype="multipart/form-data"
          method="post"
          @success="refresh"
          @change="uploadedPhoto = true"
          resetOnSuccess
        >
          <div class="photo-form-wrapper">
            <div class="upload-button-wrapper">
              <label class="upload-button" for="photo">
                <Upload />
                <p>Upload</p>
              </label>
              <input class="photo-input" id="photo" accept="photo/*" name="photo" type="file" />
            </div>
            <button :class="['upload-button', 'submit-button', { uploaded: uploadedPhoto }]">
              <ImageUp />
              <p>Submit</p>
            </button>
          </div>
        </Form>
        <p class="upload-errors">{{ errors.photo }}</p>
      </div>
    </div>
  </div>
</template>
<style lang="scss" scoped>
.upload-errors {
  margin-top: 1vh;
  font-size: clamp(0.875rem, 1.5cqi, 2rem);
  color: var(--red);
}

.photo-settings {
  container-type: inline-size;
}

.photo-settings-wrapper {
  display: flex;
  margin-top: 2cqi;
}

.list-wrapper {
  margin-right: clamp(1rem, 2.75cqi, 4rem);
  padding-right: clamp(1rem, 1.375cqi, 2.5rem);
  border-right: clamp(2px, 0.25cqi, 4px) solid var(--primary);
}

.list-item {
  display: flex;
  gap: clamp(1rem, 1.375cqi, 2.5rem);
  justify-content: space-between;
  margin-bottom: clamp(0.5rem, 0.6875cqi, 1.25rem);
  padding: 0 clamp(0.25rem, 0.7cqi, 1.25rem);
  border-radius: clamp(0.5rem, 0.75cqi, 1.25rem);
  font-size: clamp(1rem, 2.5cqi, 2rem);
  background-color: var(--white6);

  &:hover {
    background-color: var(--white5);
  }
}

.selected-photo {
  outline: clamp(2px, 0.25cqi, 5px) solid var(--primary);
}

.upload-photo-box {
  display: flex;
  flex-direction: column;
  justify-content: end;
}

.photo {
  max-height: 45vh;
  margin-bottom: 1vh;
}

.photo-form-wrapper {
  display: flex;
  justify-content: space-between;
}

.upload-button-wrapper {
  display: flex;
  gap: clamp(0.5rem, 0.75cqi, 1.25rem);
  align-items: end;
}

.delete-photo-button {
  height: 100%;

  svg {
    stroke: var(--red);
  }
}

.works-better {
  font-size: clamp(0.875rem, 1.5cqi, 2rem);
}

.upload-button {
  cursor: pointer;
  display: flex;
  gap: clamp(0.5rem, 0.75cqi, 1.25rem);
  align-items: center;
  padding: 1cqi;
  border: clamp(1px, 0.2cqi, 3px) solid black;
  border-radius: clamp(0.5rem, 0.75cqi, 1.25rem);
  font-size: clamp(0.75rem, 2cqi, 2rem);

  &.uploaded {
    border: clamp(1px, 0.2cqi, 3px) solid var(--secondary);
    background-color: var(--white6);
  }
}

.photo-input {
  width: fit-content;
  font-size: clamp(0.65rem, 1.5cqi, 2rem);
}

.list-item svg {
  width: clamp(1rem, 1.75cqi, 2.5rem);
  height: clamp(1rem, 1.75cqi, 2.5rem);
}

.upload-button svg {
  width: 1.2em;
  height: 1.2em;
}
</style>
