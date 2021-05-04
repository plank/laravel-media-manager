'use strict'

module.exports = {
  'extends': 'stylelint-config-standard-scss',
  rules: {
    'no-descending-specificity': null,
    "color-named": ["never", { ignore: ["inside-function"] } ],
    "declaration-property-unit-whitelist": {"font-size": ["rem", "%", "px"], "line-height": ["rem", "px"]},
    'selector-class-pattern': null,
    'max-line-length': 100,
    "at-rule-empty-line-before": null,
    "function-url-quotes": "always",
    "indentation": "tab",
  },
  ignoreFiles: [
    './src/scss/01-settings/_font-face.scss',
    './src/scss/02-tools/*'
  ]
}
