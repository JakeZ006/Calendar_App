<script setup>
import { ref, watchEffect } from "vue";
import { OnClickOutside } from "@vueuse/components";
import { router } from "@inertiajs/vue3";
import { useDate } from "../../composables/date";
import { X, CirclePlus, ArrowLeft, NotepadText } from "@lucide/vue";
import NoteForm from "./NoteForm.vue";
import NoteCard from "./NoteCard.vue";

const { open, day, notes } = defineProps(["open", "day", "notes"]);
const emit = defineEmits(["closeModal", "success"]);

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
  emit("closeModal");
  formOpen.value = false;
}

watchEffect(() => {
  open ? modal.value?.showModal() : modal.value?.close();
});

const refresh = () => {
  router.reload({
    only: ['notes']
  });
  formOpen.value = false;
};
</script>

<template>
  <dialog ref="modal" class="modal" @close="handleClose">
    <OnClickOutside @trigger="modal.close()">
      <div class="modal-body">
        <header class="modal-header">
          <button class="back-button" :class="{ visible: formOpen }" @click="formOpen = false">
            <ArrowLeft color="var(--text-light)" size="52" strokeWidth="1.5" />
          </button>
          <h1 class="date-display">
            {{ date.dayName }} {{ date.day }}<sup>{{ date.daySuffix }}</sup> {{ date.monthName }}
            {{ date.year }}
          </h1>
          <div class="close-form">
            <form method="dialog">
              <button class="close-button">
                <X color="var(--text-light)" size="52" strokeWidth="1.5" />
              </button>
            </form>
          </div>
        </header>

        <div v-if="!formOpen" class="notes-container">
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
              <h1 class="add-note-title">Add Note</h1>
            </button>
          </div>
        </div>

        <NoteForm v-if="formOpen" :day="day" :mode="mode" :noteId="noteId" @success="refresh" />
      </div>
    </OnClickOutside>
  </dialog>
</template>

<style lang="scss" scoped>
.modal-body {
  container-type: size;
  position: fixed;
  inset: 12vh 10vw;
  max-width: 1600px;
  margin: auto;
  overflow: auto;
  scrollbar-width: none;
  background-color: var(--white3);
  border-radius: 32px;
}
.modal::backdrop {
  background-color: hsla(0, 0%, 0%, 0.4);
}
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px;
  background-image: radial-gradient(ellipse 200% 300% at 50% -50%, var(--primary), var(--secondary));
  .date-display {
    font-size: 2.5rem;
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
  align-items: center;
  gap: 8px;
  margin-bottom: 8px;
  h2 {
    font-size: 3.5cqi;
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
  justify-content: center;
  align-items: center;
  gap: 16px;
  width: 100%;
  height: 256px;
  background-color: var(--white3);
  border: 6px dashed var(--white6);
  border-radius: 12px;
  &:hover {
    background-color: var(--white1);
    .add-note-title {
      text-decoration: underline;
      text-decoration-thickness: 3px;
      text-underline-offset: 3px;
      color: var(--mix);
    }
  }
}
.add-note-title {
  font-size: 32px;
  font-weight: 600;
}
</style>
