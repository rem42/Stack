# Technical Documentation - Sylius AdminUi

This document details the architecture and components of the **Sylius AdminUi** package. It complements the root documentation for specific developments within this module.

## 1. Module Overview

**Role:**
Provides the logical and structural skeleton of the administration interface. It is **CSS framework agnostic** (styling is handled by `BootstrapAdminUi` or other implementations). It defines contracts, basic routes (login, dashboard), and the structure of CRUD templates.

**Key Dependencies:**
- `knplabs/knp-menu-bundle`: Menu management.
- `sylius/twig-hooks`: Hook system for content injection.
- `symfony/security-bundle`: Authentication management.

---

## 2. Internal Structure (`src/AdminUi/src`)

### `Knp/` (Menus)
- **`Menu/MenuBuilderInterface.php`**: Contract for building the main menu.
- **`Menu/MenuBuilder.php`**: Base implementation.
  - **Rule:** To add items to the menu, use the Decorator pattern on the `sylius_admin_ui.knp.menu_builder` service.

### `Symfony/` (Framework Integration)
- **`Controller/LoginController.php`**: Handles the display of the login form (`sylius_admin_ui_login`) and logout.
- **`Form/Type/LoginType.php`**: Standard login form (`_username`, `_password` fields).
- **`DependencyInjection/`**: Bundle configuration.
  - Loads services from `config/services.php`.

### `Twig/` (Extensions)
- **`Extension/RedirectPathExtension.php`**: Provides functions to handle redirects after CRUD actions.

### `TwigHooks/` (Hooks Integration)
- **`Hookable/Metadata/RoutingHookableMetadataFactory.php`**: Allows defining hooks based on current routing (page context).

---

## 3. Templates (`src/AdminUi/templates`)

This module provides **abstract** or skeleton templates:

- **`base.html.twig`**: Root layout defining main blocks (`title`, `stylesheets`, `javascripts`, `body`).
- **`dashboard/index.html.twig`**: Default homepage.
- **`security/login.html.twig`**: Login page.
- **`crud/`**: Generic templates for CRUD operations (Create, Read, Update, Delete).
  - `index.html.twig`
  - `create.html.twig`
  - `update.html.twig`
  - `show.html.twig`

**Convention:** These templates intensively use **Twig Hooks** (`{% hook 'hook_name' %}`) to allow themes (like `BootstrapAdminUi`) to inject specific markup.

---

## 4. Development Rules

1.  **CSS Agnosticism:** Never include specific CSS classes (Bootstrap, Tailwind) in this module's templates, unless they are purely utilitarian and standardized. Styling must be provided by the parent theme or implementation bundle.
2.  **Extensibility:** Any new template must expose clear hooks to allow customization.
3.  **Interface Contracts:** Always prefer injecting interfaces (e.g., `MenuBuilderInterface`) rather than concrete classes.
4.  **Route Naming:** Prefix all routes with `sylius_admin_ui_`.

---

**Note for AI:** When modifying this module, keep in mind that it serves as a foundation. Changes here impact all visual implementations (BootstrapAdminUi, etc.).
