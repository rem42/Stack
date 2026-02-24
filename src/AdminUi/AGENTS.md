# AI Contribution Guidelines - AdminUi

Guidelines for AI assistants contributing to the `AdminUi` component of the Sylius Stack. This package provides the **logical foundation** (contracts, basic routes, form types) for the admin interface, without any visual implementation.

## Reference Files

When working on AdminUi, check these files for patterns:

### Core Logic
- Login Controller: `src/AdminUi/src/Symfony/Controller/LoginController.php`
- Menu Builder Interface: `src/AdminUi/src/Knp/Menu/MenuBuilderInterface.php`
- Form Types: `src/AdminUi/src/Symfony/Form/Type/LoginType.php`

### Abstract Templates
- Base Layout: `src/AdminUi/templates/base.html.twig`
- Dashboard: `src/AdminUi/templates/dashboard/index.html.twig`
- CRUD Index: `src/AdminUi/templates/crud/index.html.twig`

## General Guidelines

### Project Structure & Philosophy

- **CSS Agnostic:** This package **must not** contain any CSS framework classes (Bootstrap, Tailwind). It defines only the HTML structure and logic.
- **Contract-First:** Define interfaces for critical services (e.g., MenuBuilder) to allow implementation by other bundles (BootstrapAdminUi).
- **Extensible:** Use Twig Hooks liberally to allow downstream packages to inject content.

### Dependencies

- `knplabs/knp-menu-bundle`: Menu structure.
- `sylius/twig-hooks`: Content injection mechanism.
- `symfony/security-bundle`: Authentication logic.

## PHP Code

- **Strict Types:** `declare(strict_types=1);` is mandatory.
- **Service Configuration:** Use PHP attributes (`#[AsDecorator]`, `#[Route]`) where possible, but core services may be defined in `config/services.php` for clarity.
- **Route Naming:** All routes defined in this package must be prefixed with `sylius_admin_ui_` to avoid conflicts.
  - Example: `sylius_admin_ui_login`, `sylius_admin_ui_dashboard`.

## Templates and Hooks

- **Hook Definition:** Use `{% hook 'sylius_admin.dashboard.content' %}` to define insertion points.
- **No Hardcoded Content:** Avoid putting static text or specific HTML elements that dictate a visual style.
- **Translations:** Use `|trans` filter with keys starting with `sylius.ui.`.

## Common Mistakes to Avoid

- **Adding CSS Classes:** Do not add `class="btn btn-primary"` here. This belongs in `BootstrapAdminUi`.
- **Hardcoding Links:** Use route names (`sylius_admin_ui_*`).
- **Ignoring Security:** Ensure controllers and routes are protected by the firewall configuration (usually handled in the main app config, but be aware of `ROLE_ADMIN`).
