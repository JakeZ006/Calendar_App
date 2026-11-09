import { createInertiaApp } from "@inertiajs/vue3";

void createInertiaApp({
  withApp: (app) => {
    app.directive("focus", {
      mounted: (el: HTMLElement, shouldFocus) => {
        if (shouldFocus.value !== false) {
          el.focus();
        }
      },
    });
  },
  progress: {
    color: "#4B5563",
  },
});
