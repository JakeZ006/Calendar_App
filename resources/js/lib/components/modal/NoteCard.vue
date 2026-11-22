<script setup>
import { Form } from "@inertiajs/vue3";
import { Trash, SquarePen } from "@lucide/vue";

const { note } = defineProps(["note"]);

const emit = defineEmits(["edit-note", "delete"]);
</script>

<template>
  <div :class="['card', { important: note.important }]">
    <header class="card-header">
      <div class="card-button-wrapper">
        <button class="card-button edit-button" @click="$emit('edit-note', note.id)">
          <SquarePen />
          <p>Edit</p>
        </button>
        <Form :action="`/deleteNote/${note.id}`" method="delete" @success="$emit('delete')">
          <input type="hidden" name="id" :value="note.id" />
          <button class="card-button delete-button">
            <Trash />
            <p>Delete</p>
          </button>
        </Form>
      </div>
    </header>
    <div class="content-wrapper">
      <h1 class="title">{{ note.title }}</h1>
      <p class="content">{{ note.content }}</p>
    </div>
    <div class="tag-wrapper">
      <div :class="['note-tag', 'type-tag', note.type.toLowerCase()]">{{ note.type }}</div>
      <div class="note-tag important-tag" v-if="note.important">important</div>
      <div class="note-tag expirable-tag" v-if="note.expirable">expirable</div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.card {
  container-type: size;
  display: flex;
  flex-direction: column;
  gap: 2cqb;
  padding: 2cqb;
  border-radius: clamp(0.75rem, 0.85vw, 2rem);
  font-size: clamp(0.875rem, 1vh, 2rem);
  background-color: var(--white1);
  box-shadow: -3px 2px 5px 1px var(--white6);
}

.card-header {
  display: flex;
  justify-content: space-between;
}

.title {
  font-size: clamp(1rem, 7cqi, 3rem);
  text-decoration: underline;
}

.card-button-wrapper {
  display: flex;
  justify-content: space-between;
  width: 100%;
}

.card-button {
  cursor: pointer;
  display: flex;
  gap: clamp(0.25rem, 0.4vw, 0.75rem);
  align-items: center;
  justify-content: center;
  height: fit-content;
  padding: clamp(0.2rem, 0.2vw, 0.4rem) clamp(0.5rem, 0.6vw, 1.5rem);
  border-radius: 99px;
  font-size: clamp(1rem, 4cqi, 3rem);

  svg {
    width: 1em;
    height: 1em;
    stroke: var(--text-dark);
  }
}

.edit-button {
  border: clamp(2px, 0.25vh, 5px) solid var(--mix);
  background-color: var(--white6);

  &:hover {
    background-color: var(--secondary-l);
  }

  &:active {
    background-color: var(--mix);
  }
}

.delete-button {
  border: clamp(2px, 0.25vh, 5px) solid var(--red);
  background-color: var(--red-l2);

  &:hover {
    background-color: var(--red-l1);
  }
}

.content-wrapper {
  margin-left: 3cqi;
}

.content {
  font-size: clamp(0.5rem, 5cqi, 3rem);
  font-weight: 400;
}

.tag-wrapper {
  display: flex;
  gap: clamp(0.5rem, 0.6vw, 1.25rem);
  margin-top: auto;
}

.note-tag {
  display: flex;
  padding: clamp(0.25rem, 0.3vw, 0.625rem) clamp(0.5rem, 0.6vw, 1.25rem);
  border: clamp(1px, 0.08vw, 2px) solid var(--text-dark);
  border-radius: 99px;
}

.type-tag {
  margin-right: auto;
}

.expirable-tag {
  border: clamp(1px, 0.08vw, 2px) solid var(--expirable);
}

.important-tag {
  border: clamp(1px, 0.08vw, 2px) solid var(--red);
}

.important {
  border: clamp(2px, 0.2vw, 5px) solid var(--secondary);
}

.todo {
  background-color: var(--todo-l);
}

.event {
  background-color: var(--event-l);
}

.birthday {
  background-color: var(--birthday-l);
}

.holiday {
  background-color: var(--holiday-l);
}

.misc {
  background-color: var(--misc-l);
}
</style>
