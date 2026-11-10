<script>
import { defineComponent } from "vue";
import { dragscroll } from "vue-dragscroll";

export default defineComponent({
  directives: {
    dragscroll,
  },
});
</script>

<script setup>
import { computed, onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useDate } from "../../composables/date.js";
import { ZoomIn, ZoomOut } from "@lucide/vue";

import ModalBody from "../modal/ModalBody.vue";

const { sidebarOpen } = defineProps(["sidebarOpen"]);
const page = usePage();

const date = useDate();
let calendar;

const cellZoom = ref(1);

const todayCellEl = ref(null);

const notes = computed(() => page.props.notes ?? {});
const selectedDay = ref();
const selectedNotes = computed(() => notes.value[selectedDay.value] ?? []);

const modalOpen = ref(false);
const dragging = ref(false);

function setCalendar() {
  calendar = useDate([date.year, 1, 1]);
}

function todayCellScroll() {
  if (!todayCellEl.value) {
    return;
  }

  todayCellEl.value.style.scrollSnapAlign = "start";
  setTimeout(() => {
    todayCellEl.value.style.scrollSnapAlign = "none";
  });
}

const stopDragging = () => {
  setTimeout(() => {
    dragging.value = false;
  }, 1);
};

const openModal = (event) => {
  if (!dragging.value) {
    selectedDay.value = event.currentTarget.id.substring(5);
    toggleModal();
  }
};

function toggleModal() {
  modalOpen.value = !modalOpen.value;
}

onMounted(() => {
  todayCellEl.value = document.getElementById(`cell-${date.dateString}`);
  todayCellScroll();
});
</script>

<template>
  <div
    class="calendar-wrapper"
    :style="!sidebarOpen ? { width: '100vw', transform: 'translateX(-380px)' } : null"
  >
    <div class="calendar-container">
      <div class="day-of-week-container">
        <div v-for="dayName in date.names.day" :key="dayName" class="day-of-week">
          <p>{{ dayName.substring(0, 3) }}</p>
        </div>
      </div>

      <div v-dragscroll class="calendar-grid" @dragscrollend="stopDragging" @dragscrollmove="dragging = true">
        <p v-show="false">{{ setCalendar() }}</p>

        <div v-for="i in calendar.dayOfWeek - 1" :key="`spacer-${i}`" class="cell"></div>

        <div
          v-for="i in calendar.daysInYear * 5"
          :id="'cell-' + calendar.toString().slice(0, 10)"
          :key="i"
          :class="[
            'cell',
            calendar.month % 2 === 0 ? 'even' : 'odd',
            calendar.toString().slice(0, 10) === date.dateString ? 'today-cell': null, //prettier-ignore
          ]"
          :title="`${calendar.day}/${calendar.month}/${calendar.year}`"
          @click="openModal"
        >
          <div class="date-wrapper">
            <p class="day">{{ calendar.day }}</p>
            <p v-if="calendar.day === 1" class="month">
              {{ date.names.month[calendar.month - 1].substring(0, 3) }}
            </p>
          </div>
          <div class="notes-dots-wrapper">
            <div
              v-for="note in notes[calendar.toString().slice(0, 10)] ?? []"
              :key="note.id"
              :class="['note-dot', note.type.toLowerCase(), note.important ? 'important' : null]"
            ></div>
          </div>

          <p v-show="false">{{ calendar = calendar.add({ days: 1 }) }}</p>
        </div>
      </div>
    </div>
    <div class="calendar-controls">
      <div class="zoom-controls">
        <button
          class="zoom-button"
          title="Zoom out calendar"
          @click="cellZoom >= 0.8 ? (cellZoom -= 0.2) : null"
        >
          <ZoomOut />
        </button>
        <button class="zoom-button reset-zoom-button" title="Reset calendar zoom" @click="cellZoom = 1">
          <svg
            fill="none"
            height="24"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            viewBox="0 0 24 24"
            width="24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path d="m22 21.5-4-4" />
            <path d="M7.52 17.761A8 8 0 104.5 11.5L2.065 8.002" />
            <path d="m8 9.5-3.5 2" />
          </svg>
        </button>
        <button
          class="zoom-button"
          title="Zoom in calendar"
          @click="cellZoom <= 3.6 ? (cellZoom += 0.2) : null"
        >
          <ZoomIn class="zoom-in-button" />
        </button>
      </div>
      <button class="reset-scroll-button button-primary" @click="todayCellScroll()">Reset Scroll</button>
    </div>
    <ModalBody
      v-if="modalOpen"
      :day="selectedDay"
      :notes="selectedNotes"
      :open="modalOpen"
      @closeModal="toggleModal()"
    />
  </div>
</template>

<style lang="scss" scoped>
.calendar-wrapper {
  container-type: inline-size;
  width: calc(100vw - min(25vw, 440px) - 128px);
  padding: clamp(32px, 2vw, 48px);
  padding-bottom: 0;
  background-color: var(--white1);
  border-radius: 32px;
  box-shadow: inset 0 0 4px 1px var(--secondary);
  transition: all cubic-bezier(0.16, 1, 0.3, 1) 400ms;
}
.calendar-container {
  display: flex;
  align-items: center;
  gap: 24px;
  padding: clamp(16px, 1vw, 24px);
  background-color: var(--white2);
  border-radius: 16px;
  box-shadow: 0 0 4px 3px var(--white5);
}

.day-of-week-container {
  display: grid;
  grid-auto-flow: column;
  grid-template-rows: repeat(7, clamp(54px, 4vw, 92px));
  gap: 4px;
  min-width: clamp(24px, 100%, 48px);
  height: 100%;
  margin-bottom: 24px;
  &:first-child {
    border-top: 1px solid var(--primary);
  }
}
.day-of-week {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  text-align: center;
  border-bottom: 1px solid var(--primary);
  p {
    font-size: clamp(16px, 1cqi, 20px);
    font-weight: 700;
  }
}

.calendar-grid {
  display: grid;
  grid-template-rows: repeat(7, clamp(54px, 4vw, 92px));
  grid-auto-flow: column;
  gap: 4px;
  overflow: auto;
  scroll-snap-type: x mandatory;
  scroll-padding-left: calc(clamp(42px, 3vw, 64px) * v-bind(cellZoom) + 8px);
  border-radius: 8px;
  user-select: none;
  @media screen and (not (-webkit-min-device-pixel-ratio: 0)) {
    scrollbar-color: var(--scrollbar) transparent;
  }
  &::-webkit-scrollbar {
    height: 24px;
  }
  &::-webkit-scrollbar-track {
    background: transparent;
  }
  &::-webkit-scrollbar-thumb {
    background: var(--scrollbar);
    border-radius: 12px;
    cursor: grab;
    &:hover {
      background-color: var(--scrollbar-hover);
    }
    &:active {
      cursor: grabbing;
    }
  }
}

.cell {
  container-type: inline-size;
  display: flex;
  flex-direction: column;
  gap: 4px;
  padding: 4px;
  width: calc(clamp(42px, 3vw, 64px) * v-bind(cellZoom));
  padding: 4px;
  border-radius: 4px;
  cursor: pointer;
  user-select: none;
  &:active {
    cursor: grabbing;
  }
}
.date-wrapper {
  display: flex;
  justify-content: space-between;
}
.day,
.month {
  font-size: clamp(11px, 30cqi, 16px);
  font-weight: 500;
}
.month {
  margin-right: 4px;
  font-size: clamp(11px, 30cqi, 16px);
  font-weight: 700;
}

.odd {
  background-color: var(--accent1);
  &:hover {
    background-color: var(--accent1-hover);
  }
  &:active {
    background-color: var(--accent1-active);
  }
}
.even {
  background-color: var(--accent2);
  &:hover {
    background-color: var(--accent2-hover);
  }
  &:active {
    background-color: var(--accent2-active);
  }
}
.today-cell {
  background-color: var(--accent3);
  &:hover {
    background-color: var(--accent3-hover);
  }
  &:active {
    background-color: var(--accent3-active);
  }
}

.notes-dots-wrapper {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  column-gap: 8%;
  row-gap: 14%;
}
.note-dot {
  flex: 1;
  aspect-ratio: 1;
  border-radius: 50%;
}
.important {
  border: 3px solid var(--red);
}
.todo {
  background-color: var(--todo);
}
.event {
  background-color: var(--event);
}
.birthday {
  background-color: var(--birthday);
}
.holiday {
  background-color: var(--holiday);
}
.misc {
  background-color: var(--misc);
}

.calendar-controls {
  display: flex;
  justify-content: space-between;
  padding: clamp(16px, 1vw, 24px) 0;
}

.zoom-controls {
  display: flex;
  align-items: center;
  overflow: hidden;
  border: solid 3px var(--white6);
  border-radius: 999px;
  box-shadow: 0 2px 10px var(--white5);
}
.zoom-button {
  height: 100%;
  padding: 6px 12px;
  background-color: var(--white5);
  &:hover {
    background-color: var(--white3);
  }
  &:active {
    background-color: var(--white6);
  }
  svg {
    width: clamp(24px, 3cqi, 40px);
    height: clamp(24px, 3cqi, 40px);
  }
}
.reset-zoom-button {
  border-inline: solid 3px var(--white6);
}
.reset-scroll-button {
  padding: 8px;
  border-radius: 12px;
  box-shadow: var(--shadow-button);
  cursor: pointer;
  &:hover {
    background-color: var(--mix);
    background-image: none;
  }
  &:active {
    background-color: var(--primary);
  }
}
</style>
