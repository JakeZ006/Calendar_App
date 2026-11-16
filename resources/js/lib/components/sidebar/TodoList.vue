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
    only: ["notes"],
  });
};
</script>

<template>
  <ul class="list" v-if="notes.length > 0">
    <li class="list-item" v-for="note in notes" :id="`note-${note.id}`" :key="note.id">
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
              <Form
                class="delete"
                :action="`/deleteNote/${note.id}`"
                method="delete"
                @success="refresh"
              >
                <input v-show="false" name="id" :value="note.id" />
                <button class="delete-button">
                  <Trash color="var(--primary)" size="min(7cqi, 48px)" />
                </button>
              </Form>
            </div>
          </div>
        </div>
      </details>
    </li>
  </ul>
  <p class="empty-message" v-else>
    Nothing to do. Add a note by clicking a day on the calendar, or sit back and enjoy the peace.
  </p>
</template>

<style lang="scss" scoped>
.list {
  .list-item {
    display: flex;
    justify-content: space-between;
    margin: 2px 8px 6px;
    padding: 4px 12px;
    border-radius: 8px;
    font-size: clamp(0.875rem, 7cqi, 4rem);
    background-color: var(--white5);
  }
}

.details {
  cursor: pointer;
  width: 100%;
}

.details-open {
  display: flex;
  flex-direction: column;
  margin-inline: 8cqi;
}

.content {
  padding-bottom: 8px;
  font-size: clamp(0.875rem, 6cqi, 2.4rem);
  font-weight: 500;
  line-height: 8cqi;
}

.bottom {
  display: flex;
  gap: 4px;
  align-items: center;
  width: 100%;
  padding: 8px;
  border-top: 2px solid var(--white1);
}

.date,
.type {
  font-size: clamp(0.75rem, 5cqi, 2rem);
  font-weight: 400;
}

.type {
  margin-left: 16px;
}

.delete-button-wrapper {
  margin-left: auto;
}

.delete-button {
  display: flex;
  align-items: center;
}

.note-important {
  color: var(--secondary);

  &::marker {
    color: var(--secondary);
  }
}

.empty-message {
  padding: 8px 16px;
  font-size: clamp(0.75rem, 5cqi, 1.5rem);
  color: var(--grey);
}
</style>
