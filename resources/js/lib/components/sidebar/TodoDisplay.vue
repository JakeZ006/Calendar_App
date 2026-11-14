<script setup>
import TodoList from "./TodoList.vue";
import { SquareExclamationPoint } from "@lucide/vue";
import { ref } from "vue";

const filter = ref("today");
const important = ref(false);
</script>

<template>
  <div class="todo-display-wrapper">
    <nav class="todo-nav">
      <div class="date-button-wrapper">
        <button
          :class="['todo-nav-button', { 'selected-filter': filter === 'today' }]"
          title="Show notes for today"
          @click="filter = 'today'"
        >
          Today
        </button>
        <button
          :class="['todo-nav-button', { 'selected-filter': filter === 'week' }]"
          title="Show notes for this week"
          @click="filter = 'week'"
        >
          7 Days
        </button>
        <button
          :class="['todo-nav-button', { 'selected-filter': filter === 'month' }]"
          title="Show notes for this month"
          @click="filter = 'month'"
        >
          30 Days
        </button>
        <button
          :class="['todo-nav-button', { 'selected-filter': filter === 'all' }]"
          title="Show all notes"
          @click="filter = 'all'"
        >
          All
        </button>
      </div>

      <label
        class="todo-nav-button important-button"
        :class="{ 'important-selected': important }"
        for="important-checkbox"
        title="Filter by important notes"
      >
        <SquareExclamationPoint
          class="important-icon"
          size="28"
          :color="important ? 'var(--text-light)' : 'var(--text-dark)'"
        />
      </label>
      <input v-show="false" id="important-checkbox" v-model="important" type="checkbox" />
    </nav>
    <div class="todo-list-wrapper">
      <TodoList :filter="filter" :important="important" />
    </div>
  </div>
</template>

<style lang="scss" scoped>
.todo-display-wrapper {
  container-type: size;
  height: 37cqh;
  padding: 8px;
  padding-bottom: 4px;
  background-color: var(--white2);
  border-radius: 24px;
}
.todo-nav {
  display: flex;
  align-items: center;
  margin-bottom: 16px;
  overflow: hidden;
  border-radius: 99px;
  &::after {
    position: absolute;
    width: 96cqi;
    margin-left: 2cqi;
    border: 1px solid var(--white6);
    transform: translateY(28px);
  }
}
.date-button-wrapper {
  display: grid;
  grid-auto-flow: column;
  width: 100%;
}
.todo-nav-button {
  height: 40px;
  padding: 8px 0;
  font-size: clamp(15px, 4cqi, 18px);
  font-weight: 700;
  background-color: var(--white5);
  &:hover:not(.important-button) {
    background-color: var(--white3);
  }
}
.selected-filter {
  color: var(--text-light);
  background-image: linear-gradient(135deg, var(--secondary) -50%, var(--primary));
}

.important-button {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 40px;
  padding: 0 10px 0 8px;
  border-left: 3px solid var(--mix);
  cursor: pointer;
}
.important-selected {
  background-color: var(--secondary);
}

.todo-list-wrapper {
  height: calc(100cqh - 64px);
  overflow: auto;
  @media screen and (not (-webkit-min-device-pixel-ratio: 0)) {
    scrollbar-color: var(--scrollbar) transparent;
  }
  &::-webkit-scrollbar {
    width: 12px;
  }
  &::-webkit-scrollbar-track {
    background: transparent;
  }
  &::-webkit-scrollbar-thumb {
    background: var(--scrollbar);
    border-radius: 6px;
    cursor: grab;

    &:hover {
      background-color: var(--scrollbar-hover);
    }
    &:active {
      cursor: grabbing;
    }
  }
}
</style>
