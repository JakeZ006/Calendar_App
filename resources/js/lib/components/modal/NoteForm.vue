<script setup>
import { computed, reactive } from "vue";
import { usePage, Form } from "@inertiajs/vue3";
import { NotebookPen, Send } from "@lucide/vue";

const { mode, day, noteId } = defineProps(["mode", "day", "noteId"]);
defineEmits(["success"]);
const page = usePage();
const errors = computed(() => page.props.errors ?? []);

const form = reactive({
  title: "",
  content: "",
  type: "Todo",
  important: false,
  expirable: true,
});

const formAttrs =
  mode === "edit"
    ? { action: `/updateNote/${noteId}`, method: "patch" }
    : { action: "/createNote", method: "post" };

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
          <NotebookPen size="4cqi" />
        </div>
        <h1 class="form-header-title">
          {{ mode === "edit" ? "Edit note for:" : "Create note for:" }}
          {{ day.replaceAll("-", "/") }}
        </h1>
      </div>
      <Form
        class="form"
        resetOnSuccess
        :action="formAttrs.action"
        :method="formAttrs.method"
        @success="$emit('success')"
      >
        <div class="form-inputs-wrapper">
          <input v-if="mode === 'create'" name="for_date" type="hidden" :value="day" />
          <input v-else name="id" type="hidden" :value="noteId" />

          <div class="note-info-wrapper">
            <div class="note-info-container">
              <div class="title-wrapper">
                <label for="title">Title *</label>
                <div class="title-input-box">
                  <input
                    id="title"
                    v-model="form.title"
                    maxlength="15"
                    name="title"
                    placeholder="Enter a title"
                  />
                  <p :class="['title-input-count', { 'over-limit': form.title.length > 15 }]">
                    {{ form.title.length }}/15
                  </p>
                </div>
              </div>

              <div class="type-wrapper">
                <label for="type">Type *</label>
                <select class="type-input-box" id="type" v-model="form.type" name="type">
                  <option value="Todo">Todo</option>
                  <option value="Event">Event</option>
                  <option value="Birthday">Birthday</option>
                  <option value="Holiday">Holiday</option>
                  <option value="Misc">Misc</option>
                </select>
              </div>
            </div>
            <p class="note-info-errors form-error">{{ errors.title }}{{ errors.type }}</p>
          </div>

          <div class="content-wrapper">
            <label for="content">Content</label>
            <textarea
              class="content-input-box"
              id="content"
              v-model="form.content"
              name="content"
            />
            <p class="form-error">{{ errors.content }}</p>
          </div>

          <div class="options-wrapper">
            <div>
              <label
                :class="['option-button', { 'expirable-selected': form.expirable }]"
                for="expirable"
                title="Note expires after its due date"
                >Expirable</label
              >
              <input
                id="expirable"
                v-show="false"
                v-model="form.expirable"
                name="expirable"
                type="checkbox"
                value="1"
              />
            </div>
            <div>
              <label
                :class="['option-button', { 'important-selected': form.important }]"
                for="important"
                title="Highlight this note as important"
              >
                Important
              </label>
              <input
                id="important"
                v-show="false"
                v-model="form.important"
                name="important"
                type="checkbox"
                value="1"
              />
            </div>
          </div>

          <button class="submit-button button-primary" type="submit">
            <Send size="6cqb" />
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
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 87%;
}

.form-box {
  container-type: size;
  width: clamp(22rem, 61cqi, 72rem);
  height: clamp(28rem, 65cqh, 60rem);
  border-radius: clamp(1.5rem, 2.2vw, 3.5rem);
  background-color: var(--white1);
  box-shadow: 0 6px 15px 4px var(--white6);
}

.form-header {
  display: flex;
  gap: clamp(0.5rem, 0.6vw, 1.25rem);
  align-items: center;
  justify-content: center;
  padding: clamp(0.5rem, 0.55vw, 1.25rem) 0;
  border-bottom: clamp(2px, 0.2vw, 5px) solid var(--white6);
}

.form-header-title {
  font-size: clamp(1.25rem, 4cqi, 2.625rem);
}

.form {
  height: 100%;
}

.form-inputs-wrapper {
  display: grid;
  grid-template-rows: auto 1fr auto;
  gap: clamp(1rem, 1.1vw, 2.5rem);
  width: 78cqi;
  height: 100%;
  max-height: 80cqh;
  margin: auto;
  margin-top: clamp(0.5rem, 0.55vw, 1.25rem);
}

.note-info-container {
  display: flex;
  gap: clamp(1rem, 2.2vw, 4rem);
  justify-content: space-between;
  width: 100%;
}

.title-wrapper,
.type-wrapper,
.content-wrapper {
  label {
    font-size: clamp(0.9375rem, 1.25vw, 1.6875rem);
    font-weight: 700;
  }
}

.notebook-icon {
  padding: 1cqi;
  border-radius: 50%;
  background-color: var(--mix);

  svg {
    stroke: var(--text-light);
  }
}

.title-input-box {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 42cqi;
  height: 6cqi;
  padding: 0 clamp(0.5rem, 0.55vw, 1.25rem);
  border: clamp(2px, 0.2vw, 5px) solid var(--white6);
  border-radius: clamp(0.75rem, 0.85vw, 2rem);
  font-size: clamp(1rem, 1.5vw, 2.0625rem);
  background-color: var(--white3);

  .title-input-count {
    font-size: clamp(0.75rem, 2.5cqi, 1.5rem);
    color: var(--grey1);

    &.over-limit {
      color: var(--red);
    }
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
  padding: 0 clamp(0.5rem, 0.55vw, 1.25rem);
  border: clamp(2px, 0.2vw, 5px) solid var(--white6);
  border-radius: clamp(0.75rem, 0.85vw, 2rem);
  font-size: clamp(1rem, 1.5vw, 2.0625rem);
  background-color: var(--white3);
}

.note-info-errors {
  width: 100%;
}

.content-input-box {
  flex: 1;
  width: 100%;
  margin-bottom: clamp(1rem, 1.1vw, 2.5rem);
  padding: clamp(0.25rem, 0.3vw, 0.625rem) clamp(0.5rem, 0.55vw, 1.25rem);
  border: clamp(2px, 0.2vw, 5px) solid var(--white6);
  border-radius: clamp(0.75rem, 0.85vw, 2rem);
  font-size: clamp(1rem, 1.5vw, 2.0625rem);
  background-color: var(--white3);
}

.options-wrapper {
  display: flex;
  gap: clamp(1rem, 1.1vw, 2.5rem);
  align-self: start;
  margin-top: calc(clamp(0.5rem, 0.55vw, 1.25rem) * -1);
}

.option-button {
  cursor: pointer;
  user-select: none;
  padding: clamp(0.5rem, 0.55vw, 1.25rem) clamp(1rem, 1.1vw, 2.5rem);
  border-radius: clamp(0.625rem, 0.7vw, 1.5rem);
  font-size: clamp(0.875rem, 3cqb, 1.6875rem);
  outline: clamp(1px, 0.15vw, 3px) solid var(--primary);
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
  cursor: pointer;
  display: flex;
  gap: clamp(0.5rem, 0.6vw, 1.25rem);
  align-items: center;
  justify-content: center;
  width: 100%;
  margin-top: auto;
  padding: clamp(0.5rem, 0.55vw, 1.25rem) clamp(1rem, 1.1vw, 2.5rem);
  border-radius: clamp(0.75rem, 0.85vw, 2rem);
  box-shadow: var(--shadow-button);

  svg {
    stroke: var(--text-light);
  }

  p {
    font-size: clamp(1rem, 5cqb, 2.25rem);
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
