<script setup>
import { usePage, Form, router } from "@inertiajs/vue3";
import { computed } from "vue";
import { useDate } from "@/lib/composables/date";
import { Trash } from "@lucide/vue";
const { filter, important } = defineProps(["filter", "important"]);

const date = useDate();
const page = usePage();

const today = Temporal.PlainDate.from(date.dateString);
const week = today.add({ days: 7 });
const month = today.add({ days: 30 });
const todayString = today.toString();

const notes = computed(() => {
  const groupedNotes = page.props.notes ?? {};

  let filteredNotes = Object.entries(groupedNotes)
    .filter(([forDate]) => forDate >= todayString)
    .flatMap(([forDate, dayNotes]) => dayNotes.map((note) => ({ for_date: forDate, ...note })));

  if (filter === "today") {
    filteredNotes = filteredNotes.filter((note) => note.for_date === todayString);
  } else if (filter === "week") {
    filteredNotes = filteredNotes.filter((note) => note.for_date < week.toString());
  } else if (filter === "month") {
    filteredNotes = filteredNotes.filter((note) => note.for_date < month.toString());
  }

  if (important) {
    return filteredNotes.filter((note) => note.important);
  }

  return filteredNotes;
});

const refresh = () => {
  router.reload({
    only: ['notes']
  });
};
</script>

<template>
  <ul v-if="notes.length > 0" class="list">
    <li v-for="note in notes" :id="`note-${note.id}`" :key="note.id" class="list-item">
      <details class="details">
        <summary :class="['title', { 'note-important': note.important }]" :title="note.title">
          {{ note.title }}
        </summary>
        <div class="details-open">
          <p class="content">{{ note.content }}</p>
          <div class="bottom">
            <p class="date">{{ note.for_date }}</p>
            <p class="type">● {{ note.type }}</p>
            <div class="delete-button-wrapper">
              <Form class="delete" :action="`/deleteNote/${note.id}`" method="delete" @success="refresh">
                <input v-show="false" name="id" :value="note.id" />
                <button><Trash color="var(--primary)" /></button>
              </Form>
            </div>
          </div>
        </div>
      </details>
    </li>
  </ul>
  <p v-else class="empty-message">
    Nothing to do, add a note by clicking a day on the calendar... or sit back and enjoy the peace.
  </p>
</template>

<style lang="scss" scoped>
.list {
  .list-item {
    display: flex;
    justify-content: space-between;
    margin: 2px 8px 6px 8px;
    padding: 4px 12px;
    font-size: 7cqi;
    background-color: var(--white5);
    border-radius: 8px;
  }
}
.details {
  width: 100%;
  cursor: pointer;
}
.details-open {
  display: flex;
  flex-direction: column;
  margin-left: 26px;
}
.content {
  font-size: 6cqi;
  font-weight: 500;
  line-height: 8cqi;
}
.bottom {
  display: flex;
  gap: 4px;
  width: 100%;
  margin-top: 4px;
  padding-top: 4px;
  border-top: 2px solid var(--white1);
}
.date,
.type {
  font-size: 5cqi;
  font-weight: 400;
}
.type {
  margin-left: 16px;
}
.delete-button-wrapper {
  margin-left: auto;
}
.note-important {
  color: var(--secondary);
  &::marker {
    color: var(--secondary);
  }
}
.empty-message {
  padding: 8px 16px;
  font-size: 5cqi;
  color: var(--grey);
}
</style>
