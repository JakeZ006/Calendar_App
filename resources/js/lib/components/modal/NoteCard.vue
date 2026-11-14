<script setup>
import { Form } from "@inertiajs/vue3";
import { Trash, SquarePen } from "@lucide/vue";

const { note } = defineProps(["note"]);

const emit = defineEmits(["editNote", "delete"]);
</script>

<template>
  <div :class="['card', { important: note.important }]">
    <header class="card-header">
      <h1 class="title">{{ note.title }}</h1>
      <div class="card-button-wrapper">
        <button class="card-button edit-button" @click="$emit('editNote', note.id)">
          <SquarePen color="var(--text-light)" />
          <p>Edit</p>
        </button>
        <Form :action="`deleteNote/${note.id}`" method="delete" @success="$emit('delete')">
          <input type="hidden" name="id" :value="note.id" />
          <button class="card-button delete-button">
            <Trash color="var(--black1)" />
            <p>Delete</p>
          </button>
        </Form>
      </div>
    </header>
    <p class="content">{{ note.content }}</p>
    <div class="tag-wrapper">
      <div :class="['note-tag', 'type-tag', note.type.toLowerCase()]">{{ note.type }}</div>
      <div v-if="note.important" class="note-tag important-tag">important</div>
      <div v-if="note.expirable" class="note-tag expirable-tag">expirable</div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.card {
  container-type: size;
  display: flex;
  flex-direction: column;
  gap: 16px;
  height: 256px;
  padding: 16px;
  background-color: var(--white1);
  border-radius: 12px;
  box-shadow: -3px 2px 5px 1px var(--white6);
}
.card-header {
  display: flex;
  justify-content: space-between;
}
.title {
  font-size: 7cqi;
}
.card-button-wrapper {
  display: flex;
  gap: 8px;
}
.card-button {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 8px;
  height: 42px;
  padding: 8px 12px;
  border-radius: 99px;
  cursor: pointer;
}
.edit-button {
  background-color: var(--secondary);
  &:hover {
    background-color: var(--secondary-l);
  }
  &:active {
    background-color: var(--mix);
  }
  p {
    color: var(--text-light);
  }
}
.delete-button {
  background-color: var(--red-l2);
  border: 3px solid var(--red);
  &:hover {
    background-color: var(--red-l1);
  }
  p {
    color: var(--black1);
  }
}
.tag-wrapper {
  display: flex;
  gap: 8px;
  margin-top: auto;
}
.note-tag {
  display: flex;
  padding: 4px 8px;
  border: 1px solid var(--text-dark);
  border-radius: 99px;
}
.type-tag {
  margin-right: auto;
}
.expirable-tag {
  border: 1px solid var(--expirable);
}
.important-tag {
  border: 1px solid var(--red);
}
.important {
  border: 3px solid var(--secondary);
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
