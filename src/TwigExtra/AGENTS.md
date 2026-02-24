# Technical Documentation - Sylius TwigExtra

This document details the utility Twig extensions provided by the **Sylius TwigExtra** package. These tools simplify writing complex templates and improve testability.

## 1. Available Extensions (`src/TwigExtra/src/Twig/Extension`)

### `MergeRecursiveExtension`
- **Function:** `{{ array1|merge_recursive(array2) }}`
- **Usage:** Recursively merges two arrays (unlike the standard Twig `merge` filter which overwrites keys). Essential for composing complex configurations or nested HTML attributes.

### `RouteExistsExtension`
- **Function:** `{{ sylius_route_exists('route_name') }}`
- **Usage:** Checks if a route is defined in the Symfony router. Useful for conditionally displaying links (e.g., "Edit" button only if the edit route exists).

### `SortByExtension`
- **Filter:** `{{ collection|sort_by('property') }}`
- **Usage:** Sorts an array of objects or associative arrays based on a given key or property.

### `TestFormAttributeExtension` & `TestHtmlAttributeExtension`
- **Functions:** Helpers to generate `data-test-*` or `data-qa-*` attributes.
- **Usage:** Standardize selectors for E2E tests (Playwright/Cypress) without polluting CSS classes.
  - E.g.: `{{ test_html_attribute('submit-button') }}` -> `data-test="submit-button"`

---

## 2. UX Components (`src/TwigExtra/src/Twig/Ux`)

### `ComponentTemplateFinder`
- Internal utility to locate templates associated with Symfony UX components. Facilitates fluid integration between PHP components and their Twig views.

---

## 3. Development Rules

1.  **Usage:** Before writing complex logic in a template (e.g., sorting loops, route verification), check if an extension here already does the job.
2.  **Performance:** Be careful with `merge_recursive` on very large arrays within critical loops.
3.  **Tests:** Systematically use test attributes (`test_html_attribute`) for key interactive elements (buttons, inputs) to make functional tests robust against design changes.

---

**Note for AI:** If you need to generate Twig templates for the admin interface, remember to use `sort_by` for lists and `sylius_route_exists` for contextual actions.
