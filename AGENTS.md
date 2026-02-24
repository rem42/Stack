# Technical Documentation - Google Antigravity

This file serves as the absolute reference for development on this repository. It describes the architecture, conventions, and data flows of the **Sylius Stack** project.

## 1. Project Overview

**Mission:**
This repository contains the components necessary to generate robust and decoupled administration interfaces (back-office) for Symfony applications. It relies on a modular architecture allowing the composition of rich interfaces without resorting to a full SPA framework (React/Vue), prioritizing **Symfony UX** and **Hotwire (Stimulus)**.

**Current Tech Stack:**
- **Backend:** PHP 8.1+, Symfony 6.4/7.x (Components: HttpKernel, Security, DependencyInjection).
- **Frontend:** Twig, Stimulus, Symfony UX (Live Component, Twig Component, Autocomplete, Icons).
- **Architecture:** Modular Monorepo (AdminUi, BootstrapAdminUi, TwigHooks).

---

## 2. Directory Structure

The architecture is organized into decoupled components within `src/`:

### `src/` (PHP Components)
- **`AdminUi/`**: Logical core of the admin interface. Provides generic routes, basic security, and minimal templates.
- **`BootstrapAdminUi/`**: Visual implementation using Bootstrap 5. Depends on `AdminUi`. Contains specific assets and UX integration.
- **`TwigHooks/`**: Hook system for Twig allowing flexible layout composition (dynamic content zones).
- **`TwigExtra/`**: Additional Twig extensions for formatting and utilities.
- **`UiTranslations/`**: Translation catalog for the interface.

### `assets/` (Frontend)
- **`app.js`**: Main entry point. Initializes Stimulus.
- **`controllers/`**: Stimulus controllers.
  - Automatic configuration via `@symfony/ux-live-component` and `@symfony/ux-autocomplete`.
- **`styles/`**: CSS/SCSS files (Overridden Bootstrap).

### `templates/` (Views)
- **`base/`**: Global layouts.
- **`component/`**: Templates for Twig Components and Live Components.
- **`[Entity]/`**: Specific CRUD templates (e.g., `book/`, `speaker/`).

### `config/`
- Bundle and route configuration.
- **`packages/security.yaml`**: Configuration of the `admin` firewall (login, logout, provider).

---

## 3. Code Rules and Conventions

### PHP / Symfony
1.  **Strict Typing:** `declare(strict_types=1);` mandatory in all PHP files.
2.  **PHP 8 Attributes:** Use attributes for configuration.
    - Routing: `#[Route('/path', name: 'app_route')]`
    - Dependency Injection: Constructor Injection preferred.
    - Live Components: `#[AsLiveComponent]`, `#[LiveProp(writable: true)]`, `#[LiveAction]`.
3.  **Service Decoration:** To extend functionalities (e.g., Menu), use the Decorator pattern.
    ```php
    #[AsDecorator(decorates: 'sylius_admin_ui.knp.menu_builder')]
    final readonly class MenuBuilder implements MenuBuilderInterface { ... }
    ```
4.  **Controllers:** Must remain thin (Thin Controllers). Delegate business logic to Services or Handlers.

### Frontend (Twig / Stimulus / UX)
1.  **Twig Components:** Prioritize Twig components for reusable elements (buttons, cards, tables).
2.  **Live Components:** Use for dynamic interactions without page reload (search, complex forms, filters).
    - Do not write manual JavaScript if a Live Component can handle it.
3.  **Stimulus:**
    - Naming: `kebab-case` for controllers.
    - Use `getComponent()` from `@symfony/ux-live-component` to interact with the backend from JS.
    - Targets: Use `static targets = [...] ` to reference DOM elements.

---

## 4. Data Flow

The flow follows the MVC model enhanced by Symfony UX:

1.  **Initial Request (HTTP GET):**
    - The Symfony controller receives the request.
    - It prepares data (via Doctrine/Services) and renders a Twig template.
    - Twig generates the initial HTML, including `data-controller` attributes for Stimulus.

2.  **Client Interactions (Frontend):**
    - **Simple Actions:** Handled by Stimulus controllers (e.g., toggle menu).
    - **Complex Actions (Data-Driven):** Handled by **Live Components**.
        - User interacts (e.g., types in a search).
        - The Live Component sends an automatic AJAX request to the backend.
        - The backend updates the PHP component state (`#[LiveProp]`) and re-renders the partial template.
        - The DOM is intelligently updated via Morphdom.

3.  **Twig Hooks:**
    - Templates use hooks (`{% hook 'sidebar' %}`) to allow content injection by other bundles or configurations, without modifying the parent template.

---

**Note for AI:** When generating code, always verify compatibility with Symfony 6.4+ and the use of PHP attributes. Ensure that Live Components are correctly declared with `#[AsLiveComponent]`.
