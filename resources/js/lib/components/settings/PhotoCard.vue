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
  router.reload();
};
</script>
<template>
  <div class="photo-settings">
    <div class="settings-title">
      <Image size="32" stroke-width="2.5" />
      <h1>Photos</h1>
    </div>

    <div class="photo-settings-wrapper">
      <div class="list-wrapper">
        <ul>
          <li
            v-for="image in images"
            :key="image.id"
            class="list-item"
            :class="selectedImage === image.path ? 'selected-photo' : null"
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
          <img v-if="selectedImage" :src="selectedImage" />
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
              <input id="image" accept="image/*" name="image" type="file" />
            </div>
            <button
              class="upload-button"
              :style="uploadedImage ? 'background-color: var(--secondary-l)' : null"
            >
              <ImageUp />
              <p>submit</p>
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
  padding: 16px;
  background-color: var(--white1);
  border-radius: 16px;
  box-shadow: 1px 1px 20px var(--grey1);
}
.photo-settings-wrapper {
  display: flex;
}
.list-wrapper {
  margin-right: 32px;
  padding-right: 16px;
  border-right: 3px solid var(--primary);
}
.list-item {
  display: flex;
  justify-content: space-between;
  gap: 16px;
  margin-bottom: 8px;
  padding: 4px 8px;
  font-size: 22px;
  background-color: var(--white6);
  border-radius: 8px;
  &:hover {
    background-color: var(--white5);
  }
}
.selected-photo {
  outline: 3px solid var(--primary);
}

.upload-photo-box {
  display: flex;
  flex-direction: column;
  justify-content: end;
  gap: 16px;
}
.photo-form-wrapper {
  display: flex;
  justify-content: space-between;
}
.upload-button-wrapper {
  display: flex;
  align-items: end;
  gap: 8px;
}
.upload-button {
  display: flex;
  gap: 16px;
  width: 130px;
  height: 44px;
  padding: 8px 16px;
  border: 2px solid black;
  border-radius: 8px;
  cursor: pointer;
}
</style>
