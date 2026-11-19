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
import { computed, onMounted, reactive, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useDate } from "../../composables/date.js";
import { ZoomIn, ZoomOut } from "@lucide/vue";

import ModalBody from "../modal/ModalBody.vue";

defineEmits(["toggle-sidebar"]);
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

function zoomOut() {
  if (cellZoom.value >= 0.8) {
    cellZoom.value -= 0.2;
  }
}

function zoomIn() {
  if (cellZoom.value <= 3.6) {
    cellZoom.value += 0.2;
  }
}

onMounted(() => {
  todayCellEl.value = document.getElementById(`cell-${date.dateString}`);
  todayCellScroll();
});
</script>

<template>
  <div :class="['calendar-wrapper', { 'sidebar-closed-calendar': !sidebarOpen }]">
    <div class="calendar-container">
      <div class="day-of-week-container">
        <div class="day-of-week" v-for="dayName in date.names.day" :key="dayName">
          <p>{{ dayName.substring(0, 3) }}</p>
        </div>
      </div>

      <div
        class="calendar-grid"
        v-dragscroll
        @dragscrollend="stopDragging"
        @dragscrollmove="dragging = true"
      >
        <p v-show="false">{{ setCalendar() }}</p>

        <div class="cell" v-for="i in calendar.dayOfWeek - 1" :key="`spacer-${i}`"></div>

        <div
          v-for="i in calendar.daysInYear * 5"
          :id="'cell-' + calendar.toString().slice(0, 10)"
          :key="i"
          :class="[
            'cell',
            calendar.month % 2 === 0 ? 'even' : 'odd',
            { 'today-cell': calendar.toString().slice(0, 10) === date.dateString },
          ]"
          :title="`${calendar.day}/${calendar.month}/${calendar.year}`"
          @click="openModal"
        >
          <div class="date-wrapper">
            <p class="day">{{ calendar.day }}</p>
            <p class="month" v-if="calendar.day === 1">
              {{ date.names.month[calendar.month - 1].substring(0, 3) }}
            </p>
          </div>
          <div class="notes-dots-wrapper">
            <div
              v-for="note in notes[calendar.toString().slice(0, 10)] ?? []"
              :key="note.id"
              :class="['note-dot', note.type.toLowerCase(), { important: note.important }]"
            ></div>
          </div>

          <p v-show="false">{{ calendar = calendar.add({ days: 1 }) }}</p>
        </div>
      </div>
    </div>
    <div class="calendar-controls">
      <div class="left-controls-wrapper">
        <button
          class="left-controls-button button-primary"
          @click="$emit('toggle-sidebar')"
          title="Toggle sidebar"
        >
          <svg
            :class="[
              'lucide',
              'lucide-square-arrow-left-exit',
              'preview-icon',
              { 'sidebar-closed-toggle-button': !sidebarOpen },
            ]"
            xmlns="http://www.w3.org/2000/svg"
            width="max(26px, 2.5cqh)"
            height="max(26px, 2.5cqh)"
            viewBox="0 0 24 24"
            fill="none"
            stroke="var(--text-light)"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="M13 12H3" />
            <path d="M3 17.67V19a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v1.33" />
            <path d="m7 8-4 4 4 4" />
          </svg>
        </button>
        <button class="left-controls-button button-primary" @click="todayCellScroll()">
          Reset scroll
        </button>
      </div>

      <div class="zoom-controls">
        <button class="zoom-button" title="Zoom out" @click="zoomOut">
          <ZoomOut />
        </button>
        <button class="zoom-button reset-zoom-button" title="Reset zoom" @click="cellZoom = 1">
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
        <button class="zoom-button" title="Zoom in" @click="zoomIn">
          <ZoomIn class="zoom-in-button" />
        </button>
      </div>
    </div>
    <ModalBody
      v-if="modalOpen"
      :day="selectedDay"
      :notes="selectedNotes"
      :open="modalOpen"
      @close-modal="toggleModal()"
    />
  </div>
</template>

<style lang="scss" scoped>
.calendar-wrapper {
  container-type: inline-size;
  justify-self: center;
  width: calc(100vw - min(18vw, 700px) - min(256px, 10vw));
  padding: clamp(32px, 2vw, 64px);
  padding-bottom: 0;
  border-radius: 32px;
  background-color: var(--white1);
  box-shadow: inset 0 0 4px 1px var(--secondary);
  transition: width cubic-bezier(0.16, 1, 0.3, 1) 1000ms;
}

.sidebar-closed-calendar {
  width: calc(100vw - min(256px, 10vw));
  margin-left: min(128px, 5vw);
}

.calendar-container {
  display: flex;
  gap: 24px;
  align-items: center;
  padding: clamp(16px, 1vw, 24px);
  border-radius: 16px;
  background-color: var(--white2);
  box-shadow: 0 0 4px 3px var(--white5);
}

.day-of-week-container {
  display: grid;
  grid-auto-flow: column;
  grid-template-rows: repeat(7, clamp(48px, 6vh, 256px));
  gap: 4px;
  margin-bottom: 24px;
  border-top: 1px solid var(--primary);
}

.day-of-week {
  display: flex;
  align-items: center;
  justify-content: center;
  border-bottom: 1px solid var(--primary);
  text-align: center;

  p {
    font-size: clamp(1rem, 1.5cqb, 2rem);
    font-weight: 700;
  }
}

.calendar-grid {
  user-select: none;
  scroll-padding-left: calc(clamp(38px, 4cqb, 92px) * v-bind(cellZoom) + clamp(3px, 0.25cqb, 8px));
  scroll-snap-type: x mandatory;
  overflow: auto;
  display: grid;
  grid-auto-flow: column;
  grid-template-rows: repeat(7, clamp(48px, 6vh, 256px));
  gap: clamp(3px, 0.4cqb, 8px);
  border-radius: 8px;

  &::-webkit-scrollbar {
    height: 24px;
  }

  &::-webkit-scrollbar-track {
    background: transparent;
  }

  &::-webkit-scrollbar-thumb {
    cursor: grab;
    border-radius: 12px;
    background: var(--scrollbar);

    &:hover {
      background-color: var(--scrollbar-hover);
    }

    &:active {
      cursor: grabbing;
    }
  }

  @media screen and (not (min-device-pixel-ratio: 0)) {
    scrollbar-color: var(--scrollbar) transparent;
  }
}

.cell {
  cursor: pointer;
  user-select: none;
  container-type: inline-size;
  display: flex;
  flex-direction: column;
  gap: 4px;
  width: calc(clamp(38px, 4cqb, 92px) * v-bind(cellZoom));
  padding: 4px;
  border-radius: 12%;

  &:active {
    cursor: grabbing;
  }
}

.date-wrapper {
  display: flex;
  justify-content: space-between;
}

.day {
  font-size: clamp(0.6875rem, 30cqi, 1.5rem);
  font-weight: 500;
}

.month {
  margin-right: 4px;
  font-size: clamp(0.6875rem, 30cqi, 1.5rem);
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
  gap: 14% 8%;
}

.note-dot {
  flex: 1;
  aspect-ratio: 1;
  border-radius: 50%;
}

.important {
  border: 2px solid var(--red);
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
  height: 6cqh;
  margin-bottom: 1.5cqb;
  padding: 1.5cqb 0;
}

.left-controls-wrapper {
  display: flex;
  gap: 24px;
}

.left-controls-button {
  cursor: pointer;
  display: flex;
  align-items: center;
  height: 4.5cqb;
  padding: 16px;
  border-radius: 12px;
  font-size: clamp(01rem, 2cqi, 2rem);
  box-shadow: var(--shadow-button);

  &:hover {
    background-color: var(--mix);
    background-image: none;
  }

  &:active {
    background-color: var(--primary);
  }
}

.lucide-square-arrow-left-exit {
  transition: transform 600ms;
  transition-timing-function: linear(
    0,
    -0.041 20.4%,
    0.006 30.8%,
    0.199 41.6%,
    0.743 56.4%,
    0.956 66%,
    1.04 78%,
    1
  );
}

.sidebar-closed-toggle-button {
  transform: rotateY(180deg);
}

.zoom-controls {
  overflow: hidden;
  display: flex;
  align-items: center;
  height: fit-content;
  border: solid 3px var(--white6);
  border-radius: 999px;
  box-shadow: 0 2px 10px var(--white5);
}

.zoom-button {
  height: 4cqb;
  padding: clamp(2px, 0.25cqb, 6px) clamp(8px, 1cqb, 18px);
  background-color: var(--white5);

  &:hover {
    background-color: var(--white3);
  }

  &:active {
    background-color: var(--white6);
  }

  svg {
    width: 100%;
    height: 100%;
  }
}

.reset-zoom-button {
  border-inline: solid 3px var(--white6);
}
</style>
