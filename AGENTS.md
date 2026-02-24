# AI Contribution Guidelines - Sylius Stack

Guidelines for AI assistants contributing to the Sylius Stack repository. This repository provides a decoupled, modular admin interface architecture based on Symfony UX.

## Reference Files

When working on specific areas, check these files for patterns:

### Admin UI & Bootstrap
- Admin Interface Contracts: `src/AdminUi/src/Knp/Menu/MenuBuilderInterface.php`
- Base Templates: `src/AdminUi/templates/base.html.twig`
- Bootstrap Implementation: `src/BootstrapAdminUi/templates/shared/layout/title.html.twig`
- Stimulus Controllers: `src/BootstrapAdminUi/assets/controllers/`

### Twig Hooks & Extensions
- Hook Definition Pattern: `src/TwigHooks/src/Hook/Metadata/HookMetadata.php`
- Hook Configuration: `src/BootstrapAdminUi/config/app/twig_hooks/common/index.php`
- Twig Extensions: `src/TwigExtra/src/Twig/Extension/`

### Configuration & Services
- Bundle Configuration: `src/AdminUi/src/Symfony/DependencyInjection/Configuration.php`
- Service Definitions: `src/AdminUi/config/services.php`

## General Guidelines

### Project Structure & Philosophy

- **Modular Monorepo:** The project is divided into independent packages (`AdminUi`, `BootstrapAdminUi`, `TwigHooks`, etc.).
- **Headless Core:** `AdminUi` provides the logic and structure but **no CSS**.
- **Theme Implementation:** `BootstrapAdminUi` provides the concrete visual implementation using Bootstrap 5.
- **Composition over Inheritance:** The interface is built using **Twig Hooks**, allowing dynamic content injection without complex template inheritance.
- **Symfony UX First:** Heavy reliance on **Stimulus** and **Live Components** for interactivity, avoiding full SPA frameworks (React/Vue).

### Coding Standards & Tooling

- Use **4 spaces** for indentation in all files (PHP, YAML, Twig, etc.).
- Use **PHP 8.1+** syntax and features.
- Declare `strict_types=1` in **all** PHP files.
- Use **Attributes** for routing and configuration (e.g., `#[Route]`, `#[AsLiveComponent]`).
- Use **Constructor Injection** for dependencies.
- Use **Thin Controllers**: Delegate business logic to services.

## Commands

- Run `composer install` to install PHP dependencies.
- Run `yarn install` to install JavaScript dependencies.
- Run `yarn build` to compile frontend assets (Webpack/Encore).
- Run `bin/console debug:twig-hooks` to inspect registered hooks.

## PHP Code

- Use modern PHP 8.1+ syntax (readonly properties, match expressions).
- **Final Classes:** Classes should be `final` by default unless designed for inheritance.
- **Type Declarations:** Add strict type declarations for all properties, arguments, and return values.
- **Naming:**
  - Variables/Methods: `camelCase`
  - Constants: `SCREAMING_SNAKE_CASE`
  - Configuration Keys: `snake_case`
- **Service Decoration:** Use the `#[AsDecorator]` attribute to extend core services (e.g., MenuBuilder).

## Templates and Hooks

- **Twig Hooks:** Use `{% hook 'hook_name' %}` instead of `{% block %}` for extensible zones.
- **Variables:** Use `snake_case` for all template variables.
- **Translations:** Never hardcode text. Use `|trans` filter with keys following `sylius.ui.context.action`.
- **Icons:** Use the `{{ ux_icon() }}` helper (Tabler icons by default).

## JavaScript & CSS (Stimulus / Bootstrap)

- **Stimulus:** Use Stimulus controllers for all DOM interactions.
  - Place controllers in `assets/controllers/`.
  - Naming: `kebab-case` (e.g., `user-menu-controller.js`).
  - Use `static targets = [...]` to reference elements.
- **CSS:**
  - Use **SCSS** syntax.
  - Extend Bootstrap 5 via `_variables.scss`.
  - Do not write custom CSS if a Bootstrap utility class exists.

## Common Mistakes to Avoid

- **Hardcoding Strings:** Always use translation keys (`sylius.ui.*`).
- **Direct CSS Classes in AdminUi:** `AdminUi` templates must remain CSS-agnostic. Put classes in `BootstrapAdminUi`.
- **Ignoring Hooks:** Do not hardcode content in templates if it prevents extensibility. Use a Hook.
- **Manual JS:** Do not write inline JavaScript or vanilla JS event listeners. Use a Stimulus controller.
