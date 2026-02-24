# Technical Documentation - Sylius BootstrapAdminUi

This document details the architecture and components of the **Sylius BootstrapAdminUi** package. It acts as the reference visual implementation for `AdminUi`, based on Bootstrap 5.

## 1. Module Overview

**Role:**
Provides concrete templates, styling (SCSS), and JavaScript behaviors (Stimulus) for the administration interface. It transforms the abstract structure of `AdminUi` into a functional and aesthetic user interface.

**Key Technologies:**
- **Bootstrap 5**: CSS Framework.
- **Symfony UX**: Icons (`tabler`), Live Components.
- **Stimulus**: JS interaction management.
- **Webpack/AssetMapper**: Asset management.

---

## 2. Internal Structure

### `assets/` (Frontend Sources)
- **`controllers/`**: Theme-specific Stimulus controllers.
- **`styles/`**: SCSS sources.
  - `main.scss`: Entry point.
  - `_variables.scss`: Bootstrap variable overrides.
  - `_sidebar.scss`, `_navbar.scss`, etc.: Component styles.
- **`scripts/`**: Utility JS scripts (non-Stimulus or initial).

### `config/` (Configuration & Mapping)
- **`app/twig_hooks/`**: **Integration Core**. This folder contains PHP files defining the mapping between abstract hooks (defined by `AdminUi` or the developer) and concrete templates in this bundle.
  - E.g.: `common/index.php` maps the hook `sylius_admin.common.index.content` to `.../content.html.twig`.

### `src/Twig/Component/`
- **`UserDropdownComponent.php`**: Twig component for the user menu in the navbar.

---

## 3. Templates (`templates/`)

Templates are organized to be injected via the Hooks system.

### `shared/layout/`
- `stylesheets.html.twig`, `javascripts.html.twig`: Inclusion of compiled assets.

### `shared/crud/`
- Implementation of standard CRUD views (Create, Index, Show, Update).
- **`common/`**: Shared elements (Navbar, Sidebar, Flashes).
  - `sidebar/menu.html.twig`: Rendering the KnpMenu with Bootstrap styling.

### `shared/grid/`
- Templates for **Sylius Grid Bundle**.
- `action/`: Action buttons (Edit, Delete).
- `filter/`: Filter widgets.
- `field/`: Data field rendering.

### `shared/helper/`
- Reusable atomic components:
  - `accordion.html.twig`
  - `modal.html.twig`
  - `table.html.twig`

---

## 4. Development Rules

1.  **Style Customization:** Do not modify `main.scss` directly if possible. Use SCSS variables to override the theme.
2.  **Hook Mapping:** To change the appearance of a section without touching PHP code, modify the hook configuration in `config/packages/sylius_twig_hooks.yaml` (in the final application) to point to a new template.
3.  **Icons:** Use `ux-icons` (default set `tabler`).
    - E.g.: `{{ ux_icon('tabler:edit') }}`.
4.  **Javascript:** Prioritize Stimulus controllers for all interactivity. Avoid jQuery or global vanilla JS.

---

**Note for AI:** This module is the "skin". If asked to change a button color or sidebar layout, act here (SCSS or Templates). If asked to change redirection logic, do it in `AdminUi`.
