# Technical Documentation - Sylius TwigHooks

This document details the internal workings of the **Sylius TwigHooks** package. It is the interface composition engine used throughout the stack.

## 1. Core Concept

**Problem:** Twig template inheritance (`{% extends %}`) is rigid. Modifying a block often requires overriding the entire file.
**Solution:** TwigHooks introduces a dynamic injection system.
- **Hook Point:** `{% hook 'hook_name' %}` in a template defines an insertion zone.
- **Hookable:** An element (Twig Template or Component) configured to be displayed in a given hook.

---

## 2. Internal Architecture (`src/TwigHooks/src`)

### `Twig/` (Twig Extension)
- **`TokenParser/HookTokenParser.php`**: Compiles the `{% hook %}` tag.
- **`Runtime/HooksRuntime.php`**: Executed at render time. Calls the `HookRenderer`.

### `Hook/` and `Hookable/`
- **`Renderer/HookRenderer.php`**: Orchestrates the rendering of a hook.
  1.  Retrieves all configured *Hookables* for this hook name.
  2.  Sorts hookables by priority.
  3.  Renders each hookable sequentially.
- **`Hookable/`**: Types of insertable elements.
  - `HookableTemplate`: An `.html.twig` file.
  - `HookableComponent`: A Twig Component or Live Component.
- **`Merger/`**: Handles configuration merging (e.g., overriding a hookable defined in a bundle with a local config).

### `Bag/` (Context)
- **`DataBag.php`**: Data structure passed to templates rendered by the hook. Allows passing context (e.g., the current entity `resource`) from the parent template to injected children.

### `Profiler/`
- Integration with the Symfony Web Debug Toolbar to inspect rendered hooks, their order, and execution time.

---

## 3. Usage and Configuration

### Template Side (Anchor Definition)
```twig
{# In base.html.twig #}
<div class="sidebar">
    {% hook 'sylius_admin.sidebar' %}
</div>
```

### Configuration Side (PHP/YAML)
This is where assembly happens. The bundle reads the configuration to know what to put in `sylius_admin.sidebar`.

Theoretical example of internal structure (managed via `sylius_twig_hooks.yaml` in the app):
```php
'sylius_admin.sidebar' => [
    'menu' => [
        'template' => 'sidebar/menu.html.twig',
        'priority' => 10
    ],
    'user_card' => [
        'component' => 'UserCardComponent',
        'priority' => 20
    ]
]
```

---

## 4. Development Rules

1.  **Performance:** Hook rendering is fast but not free. Avoid nesting hooks too deeply (N+1 hooks).
2.  **Context:** Twig variables from the parent scope are **not** automatically passed to children (unlike `include`). Context must be explicitly passed via the `DataBag` if necessary, or the hook configured to accept specific contextual variables.
3.  **Debugging:** Use the command `bin/console debug:twig-hooks` or the Symfony profiler to understand why a block is not displaying.

---

**Note for AI:** This bundle is pure infrastructure. You will likely not need to modify the PHP code here, but you will need to understand how to *configure* hooks using the structures defined here to assemble pages in `AdminUi`/`BootstrapAdminUi`.
