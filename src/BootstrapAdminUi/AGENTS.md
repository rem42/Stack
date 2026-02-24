# AI Contribution Guidelines - BootstrapAdminUi

Guidelines for AI assistants contributing to the `BootstrapAdminUi` component of the Sylius Stack. This package provides the **visual implementation** (templates, styles, assets) of the admin interface using Bootstrap 5.

## Reference Files

When working on BootstrapAdminUi, check these files for patterns:

### Visual Implementation
- Base Layout: `src/BootstrapAdminUi/templates/shared/layout/stylesheets.html.twig`
- Dashboard Content: `src/BootstrapAdminUi/config/app/twig_hooks/dashboard/index.php`
- Sidebar Menu: `src/BootstrapAdminUi/templates/shared/crud/common/sidebar/menu.html.twig`

### Assets
- Styles: `src/BootstrapAdminUi/assets/styles/main.scss`
- Stimulus Controllers: `src/BootstrapAdminUi/assets/controllers/`
- Configuration: `src/BootstrapAdminUi/config/app/twig_hooks/common/index.php`

## General Guidelines

### Project Structure & Philosophy

- **Visual Layer:** This package is responsible for all CSS and JavaScript related to the admin theme.
- **Hook Mapping:** It maps abstract hooks from `AdminUi` to concrete templates.
  - E.g., `sylius_admin.dashboard.content` -> `templates/dashboard/content.html.twig`.
- **Bootstrap 5:** Use standard Bootstrap utility classes. Custom CSS should be minimal and placed in SCSS files.

### Dependencies

- `sylius/admin-ui`: The logical foundation.
- `symfony/ux-icons`: Icon set (Tabler).
- `symfony/ux-live-component`: Interactive components.
- `symfony/stimulus-bundle`: Frontend logic.

## PHP Code

- **Strict Types:** `declare(strict_types=1);` is mandatory.
- **Hook Configuration:** Use PHP configuration files in `config/app/twig_hooks/` to define hook mappings.
- **Component Logic:** Twig Components (`src/BootstrapAdminUi/src/Twig/Component/`) encapsulate UI logic (e.g., User Dropdown).

## Templates and Hooks

- **Concrete Implementation:** Use HTML5 and Bootstrap classes.
- **Icons:** Use `{{ ux_icon('tabler:icon-name') }}`.
- **Stimulus Integration:** Add `data-controller="controller-name"` to interactive elements.
- **Live Components:** Use `{{ component('LiveComponent:Name') }}` for complex interactions.

## JavaScript & CSS (Stimulus / Bootstrap)

- **Stimulus Controllers:**
  - Naming: `kebab-case` (e.g., `bulk-action-controller.js`).
  - Use targets (`static targets = [...]`) to manipulate DOM.
  - Use values (`static values = {...}`) to pass data from Twig.
- **SCSS:**
  - Import Bootstrap variables in `_variables.scss`.
  - Use `rem` units for spacing/font-size.
  - Avoid `!important`.

## Common Mistakes to Avoid

- **Modifying Abstract Templates:** Do not edit `src/AdminUi` templates for style changes. Edit `src/BootstrapAdminUi` templates instead.
- **Hardcoding Styles:** Use Bootstrap classes first. Only use custom CSS if absolutely necessary.
- **Missing Translations:** Always use `|trans` filter.
- **Direct DOM Manipulation:** Use Stimulus controllers instead of inline `onclick` or jQuery.
