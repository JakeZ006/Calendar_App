<script setup>
import { ImageUp, Trash, Image, Upload } from "@lucide/vue";
import { computed, ref } from "vue";
import { usePage, Form, router } from "@inertiajs/vue3";

const page = usePage();
const images = computed(() => page.props.images ?? []);
const selectedImage = ref("");
const uploadedImage = ref(false);

const refresh = () => {
  selectedImage.value = "";
  router.reload({
    only: ["images"],
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
            v-for="image in images"
            :key="image.id"
            :class="{ 'selected-photo': selectedImage === image.path }"
          >
            <button @click="selectedImage = image.path">{{ image.name }}</button>
            <Form action="/deleteImage" method="delete" @success="refresh">
              <input v-show="false" name="id" :value="image.id" />
              <button><Trash color="red" /></button>
            </Form>
          </li>
          <li>(Works better with more images)</li>
        </ul>
      </div>

      <div class="upload-photo-box">
        <div class="photo-box">
          <img v-if="selectedImage" :src="selectedImage" class="image" />
        </div>

        <Form
          action="/uploadImage"
          enctype="multipart/form-data"
          method="post"
          @success="refresh"
          @change="uploadedImage = true"
        >
          <div class="photo-form-wrapper">
            <div class="upload-button-wrapper">
              <label class="upload-button" for="image">
                <Upload />
                <p>Upload</p>
              </label>
              <input class="image-input" id="image" accept="image/*" name="image" type="file" />
              <br />
            </div>
            <button :class="['upload-button', 'submit-button', { uploaded: uploadedImage }]">
              <ImageUp />
              <p>Submit</p>
            </button>
          </div>
        </Form>
      </div>
    </div>
  </div>
</template>
<style lang="scss" scoped>
.photo-settings {
  container-type: inline-size;
}

.photo-settings-wrapper {
  display: flex;
}

.list-wrapper {
  margin-right: clamp(1rem, 2.2vw, 4rem);
  padding-right: clamp(1rem, 1.1vw, 2.5rem);
  border-right: clamp(2px, 0.2vw, 4px) solid var(--primary);
}

.list-item {
  display: flex;
  gap: clamp(1rem, 1.1vw, 2.5rem);
  justify-content: space-between;
  margin-bottom: clamp(0.5rem, 0.55vw, 1.25rem);
  padding: clamp(0.25rem, 0.3vw, 0.625rem) clamp(0.5rem, 0.6vw, 1.25rem);
  border-radius: clamp(0.5rem, 0.6vw, 1.25rem);
  font-size: clamp(1.2rem, 1.8cqi, 3rem);
  background-color: var(--white6);

  &:hover {
    background-color: var(--white5);
  }
}

.selected-photo {
  outline: clamp(2px, 0.2vw, 5px) solid var(--primary);
}

.upload-photo-box {
  display: flex;
  flex-direction: column;
  gap: clamp(1rem, 1.1vw, 2.5rem);
  justify-content: end;
  width: 100%;
}

.image{
  max-height: 40vh;
}

.photo-form-wrapper {
  display: flex;
  justify-content: space-between;
}

.upload-button-wrapper {
  display: flex;
  gap: clamp(0.5rem, 0.6vw, 1.25rem);
  align-items: end;
}

.upload-button {
  cursor: pointer;
  display: flex;
  gap: clamp(0.5rem, 0.6vw, 1.25rem);
  align-items: center;
  padding: clamp(0.5rem, 0.4vw, 1rem) clamp(1rem, 0.8vw, 2rem);
  border: clamp(1px, 0.15vw, 3px) solid black;
  border-radius: clamp(0.5rem, 0.6vw, 1.25rem);
  font-size: clamp(1rem, 1.5vw, 2rem);

  &.uploaded {
    border: clamp(1px, 0.15vw, 3px) solid var(--secondary);
    background-color: var(--white6);
  }
}

.image-input {
  font-size: clamp(0.5rem, 0.75vw, 2rem);
}

.list-item svg {
  width: clamp(1rem, 1.4vw, 2.5rem);
  height: clamp(1rem, 1.4vw, 2.5rem);
}

.upload-button svg {
  width: 1.2em;
  height: 1.2em;
}
</style>
