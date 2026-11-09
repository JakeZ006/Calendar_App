<script setup>
import { reactive } from "vue";
import { usePage, Form } from "@inertiajs/vue3";
import { NotebookPen, Send } from "@lucide/vue";

const { mode, day, noteId } = defineProps(["mode", "day", "noteId"]);
defineEmits(["success"]);
const page = usePage();
const errors = page.props.errors;

const form = reactive({
  title: "",
  content: "",
  type: "Todo",
  important: false,
  expirable: true,
});

const formAttrs =
  mode === "edit" ? { action: `/updateNote/${noteId}` , method: "patch" } : { action: "/createNote", method: "post" };

if (mode === "edit") {
  const note = page.props.notes[day]?.find((i) => i.id === noteId);

  if (note) {
    Object.assign(form, {
      title: note.title,
      content: note.content,
      type: note.type,
      important: note.important,
      expirable: note.expirable,
    });
  }
}
</script>
<template>
  <div class="form-body">
    <div class="form-box">
      <div class="form-header">
        <div class="notebook-icon">
          <NotebookPen color="var(--text-light)" size="4cqi" />
        </div>
        <h1 class="form-header-title">
          {{ mode === "edit" ? "Edit note for:" : "Create note for:" }} {{ day.replaceAll("-", "/") }}
        </h1>
      </div>
      <Form resetOnSuccess :action="formAttrs.action" :method="formAttrs.method" @success="$emit('success')">
        <div class="form-inputs-wrapper">
          <input v-if="mode === 'create'" name="for_date" type="hidden" :value="day" />
          <input v-else name="id" type="hidden" :value="noteId" />

          <div class="note-info-container">
            <div class="title-wrapper">
              <label for="title">Title *</label>
              <div class="title-input-box">
                <input
                  id="title"
                  v-model="form.title"
                  maxlength="15"
                  minlength="3"
                  name="title"
                  placeholder="Enter A Title"
                />
                <p class="title-input-count" :style="form.title.length > 15 ? 'color: var(--red)' : null">
                  {{ form.title.length }}/15
                </p>
              </div>
            </div>

            <div class="type-wrapper">
              <label for="type">Type *</label>
              <select id="type" v-model="form.type" class="type-input-box" name="type">
                <option value="Todo">Todo</option>
                <option value="Event">Event</option>
                <option value="Birthday">Birthday</option>
                <option value="Holiday">Holiday</option>
                <option value="Misc">Misc</option>
              </select>
            </div>
          </div>

          <p class="note-info-errors">{{ errors.title }}{{ errors.type }}</p>

          <div class="content-wrapper">
            <label for="content">Content</label>
            <textarea id="content" v-model="form.content" class="content-input-box" name="content" />
          </div>

          <p class="content-errors">{{ errors.content }}</p>

          <div class="options-wrapper">
            <div>
              <label
                :class="['option-button', form.expirable ? 'expirable-selected' : null]"
                for="expirable"
                title="Note exprires after due date"
                >Expirable</label
              >
              <input
                v-show="false"
                id="expirable"
                v-model="form.expirable"
                name="expirable"
                type="checkbox"
                value="1"
              />
            </div>
            <div>
              <label
                :class="['option-button', form.important ? 'important-selected' : null]"
                for="important"
                title="Highlights note as important"
              >
                Important
              </label>
              <input
                v-show="false"
                id="important"
                v-model="form.important"
                name="important"
                type="checkbox"
                value="1"
              />
            </div>
          </div>

          <button class="submit-button" type="submit">
            <Send color="var(--text-light)" size="6cqb" />
            <p>Submit</p>
          </button>
        </div>
      </Form>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.form-body {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 87%;
}
.form-box {
  container-type: size;
  width: max(20%, 700px);
  height: clamp(530px, 70cqh, 650px);
  background-color: var(--white1);
  border-radius: 32px;
  box-shadow: 0 6px 15px 4px var(--white6);
}
.form-header {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 8px 0;
  border-bottom: 3px solid var(--white6);
}
.notebook-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  aspect-ratio: 1;
  padding: 8px;
  background-color: var(--primary);
  border-radius: 50%;
}
.form-header-title {
  font-size: 4cqi;
}
.form-inputs-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
  width: 70cqi;
  height: 80cqh;
  margin: auto;
  margin-top: 4cqi;
}

.note-info-container {
  display: flex;
  justify-content: space-between;
  gap: 32px;
  width: 100%;
}
.title-wrapper,
.type-wrapper,
.content-wrapper {
  label {
    font-size: 18px;
    font-weight: 700;
  }
}
.title-input-box {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 42cqi;
  height: 6cqi;
  padding: 0 8px;
  font-size: 22px;
  background-color: var(--white3);
  border: 3px solid var(--white6);
  border-radius: 12px;
  .title-input-count {
    font-size: 2.5cqi;
    color: var(--grey1);
  }
  input {
    width: 85%;
  }
}

.type-wrapper,
.content-wrapper {
  display: flex;
  flex-direction: column;
}
.type-input-box {
  height: 6cqi;
  padding: 0 8px;
  font-size: 22px;
  background-color: var(--white3);
  border: 3px solid var(--white6);
  border-radius: 12px;
}
.note-info-errors {
  width: 100%;
  margin-top: -12px;
  color: var(--red);
}

.content-errors {
  color: var(--red);
}

.content-input-box {
  width: 70cqi;
  height: 30cqb;
  padding: 4px 8px;
  font-size: 22px;
  background-color: var(--white3);
  border: 3px solid var(--white6);
  border-radius: 12px;
}

.options-wrapper {
  display: flex;
  align-self: start;
  gap: 16px;
  margin-top: -8px;
}
.option-button {
  padding: 8px 16px;
  font-size: 3cqb;
  border-radius: 10px;
  outline: 2px solid var(--primary);
  cursor: pointer;
  user-select: none;
}
.expirable-selected {
  color: var(--text-light);
  background-color: var(--expirable);
  outline: none;
}
.important-selected {
  color: var(--text-light);
  background-color: var(--red-l3);
  outline: none;
}
.submit-button {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 8px;
  width: 100%;
  margin-top: auto;
  padding: 8px 16px;
  background-image: radial-gradient(circle at 30% 10%, var(--mix), var(--primary));
  border-radius: 12px;
  box-shadow: 2px 2px 5px var(--grey1);
  cursor: pointer;
  p {
    font-size: 5cqb;
    color: var(--text-light);
  }
  &:hover {
    background-color: var(--mix);
    background-image: none;
  }
  &:active {
    background-color: var(--primary);
  }
}
</style>
