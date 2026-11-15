/** @type {import("stylelint").Config} */
export default {
  extends: [
      "stylelint-config-standard",
      "stylelint-config-html",
      "stylelint-config-standard-scss",
      "stylelint-config-clean-order",
      "stylelint-config-standard-vue",
  ],
  "rules": {
      "hue-degree-notation": "number",
      "selector-no-unmatchable": null,
      "media-feature-name-no-unknown": null,
  },
};
