<script setup>
import { ref, watchEffect } from "vue";
import { OnClickOutside } from "@vueuse/components";
import { router } from "@inertiajs/vue3";
import { useDate } from "../../composables/date";
import { X, CirclePlus, ArrowLeft, NotepadText } from "@lucide/vue";
import NoteForm from "./NoteForm.vue";
import NoteCard from "./NoteCard.vue";

const { open, day, notes } = defineProps(["open", "day", "notes"]);
const emit = defineEmits(["close-modal", "success"]);

const date = useDate(day.split("-"));

const modal = ref(null);
const formOpen = ref(false);
const mode = ref("create");

const noteId = ref();

function editNote(id) {
  formOpen.value = true;
  mode.value = "edit";
  noteId.value = id;
}

function addNote() {
  formOpen.value = true;
  mode.value = "create";
}

function handleClose() {
  emit("close-modal");
  formOpen.value = false;
}

watchEffect(() => {
  open ? modal.value?.showModal() : modal.value?.close();
});

const refresh = () => {
  router.reload({
    only: ["notes"],
  });
  formOpen.value = false;
};
</script>

<template>
  <dialog class="modal" ref="modal" @close="handleClose">
    <OnClickOutside @trigger="modal.close()">
      <div class="modal-body">
        <header class="modal-header">
          <button :class="['back-button', { visible: formOpen }]" @click="formOpen = false">
            <ArrowLeft color="var(--text-light)" size="52" stroke-width="1.5" />
          </button>
          <h1 class="date-display">
            {{ date.dayName }} {{ date.day }}<sup>{{ date.daySuffix }}</sup> {{ date.monthName }}
            {{ date.year }}
          </h1>
          <div class="close-form">
            <form method="dialog">
              <button class="close-button">
                <X color="var(--text-light)" size="52" stroke-width="1.5" />
              </button>
            </form>
          </div>
        </header>

        <div class="notes-container" v-if="!formOpen">
          <div class="notes-container-title">
            <NotepadText size="3.5cqi" />
            <h2>Notes:</h2>
          </div>
          <div class="notes-grid">
            <NoteCard
              v-for="note in notes"
              :key="note.id"
              :note="note"
              @delete="refresh"
              @edit-note="editNote"
            />

            <button class="add-note-card" @click="addNote">
              <CirclePlus color="var(--mix)" size="128" />
              <h1 class="add-note-title">Add note</h1>
            </button>
          </div>
        </div>

        <NoteForm v-if="formOpen" :day="day" :mode="mode" :note-id="noteId" @success="refresh" />
      </div>
    </OnClickOutside>
  </dialog>
</template>

<style lang="scss" scoped>
.modal-body {
  scrollbar-width: none;
  position: fixed;
  inset: 12vh 10vw;
  container-type: size;
  overflow: auto;
  max-width: 1600px;
  margin: auto;
  border-radius: 32px;
  background-color: var(--white3);
}

.modal::backdrop {
  background-color: hsl(0 0% 0% / 40%);
}

.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px;
  background-image: radial-gradient(
    ellipse 200% 300% at 50% -50%,
    var(--primary),
    var(--secondary)
  );

  .date-display {
    font-size: clamp(1.75rem, 2.5vw, 3.75rem);
    color: var(--text-light);

    sup {
      color: var(--text-light);
    }
  }
}

.back-button {
  visibility: hidden;

  &.visible {
    visibility: visible;
  }
}

.notes-container {
  padding: 8px 64px;
}

.notes-container-title {
  display: flex;
  gap: 8px;
  align-items: center;
  margin-bottom: 8px;

  h2 {
    font-size: clamp(1.25rem, 3.5cqi, 3.375rem);
    text-decoration: underline;
    text-decoration-thickness: 3px;
    text-underline-offset: 6px;
  }
}

.notes-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
  gap: 2%;
  padding: 16px;
}

.add-note-card {
  display: flex;
  flex-direction: column;
  gap: 16px;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 256px;
  border: 6px dashed var(--white6);
  border-radius: 12px;
  background-color: var(--white3);
}

.add-note-title {
  font-size: clamp(1.5rem, 2.2vw, 3rem);
  font-weight: 600;

  &:hover {
    color: var(--mix);
    text-decoration: underline;
    text-decoration-thickness: 3px;
    text-underline-offset: 3px;
  }
}
</style>
