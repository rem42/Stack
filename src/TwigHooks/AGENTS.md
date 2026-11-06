# AI Contribution Guidelines - TwigHooks

Guidelines for AI assistants contributing to the `TwigHooks` component of the Sylius Stack. This package provides the **dynamic content injection engine** used by `AdminUi` and `BootstrapAdminUi`.

## Reference Files

When working on TwigHooks, check these files for patterns:

### Core Logic
- Hook Metadata: `src/TwigHooks/src/Hook/Metadata/HookMetadata.php`
- Hook Renderer: `src/TwigHooks/src/Hook/Renderer/HookRenderer.php`
- Twig Extension: `src/TwigHooks/src/Twig/Extension/HooksExtension.php`

### Hookables
- Hookable Template: `src/TwigHooks/src/Hookable/HookableTemplate.php`
- Hookable Component: `src/TwigHooks/src/Hookable/HookableComponent.php`
- Hookable Merger: `src/TwigHooks/src/Hookable/Merger/HookableMerger.php`

## General Guidelines

### Project Structure & Philosophy

- **Engine:** This package is the engine that parses `{% hook 'name' %}` tags and injects content.
- **Composition:** It enables a composition-based architecture (vs. inheritance).
- **Extensible:** Allows defining hooks in configuration (PHP/YAML) to control what renders where.
- **Context:** Provides a `DataBag` to pass context (e.g., current resource) to injected templates.

### Dependencies

- `twig/twig`: Core template engine.
- `symfony/twig-bundle`: Integration with Symfony.

## PHP Code

- **Strict Types:** `declare(strict_types=1);` is mandatory.
- **Hook Configuration:** Use PHP configuration arrays or services to define hooks.
- **Profiler Integration:** Use `src/TwigHooks/src/Profiler/HooksDataCollector.php` to debug hook execution.

## Templates and Hooks

- **Defining Hooks:** Use `{% hook 'hook_name' %}` in templates.
- **Providing Content:** Configure `HookableTemplate` or `HookableComponent` services.
- **Context Passing:** Use the `DataBag` object to access variables passed from the parent template.

## Common Mistakes to Avoid

- **Deep Nesting:** Avoid excessive hook nesting (performance impact).
- **Missing Context:** Ensure required variables are available in the hook context (via `DataBag`).
- **Overcomplicating Logic:** Keep hook logic simple. Complex logic belongs in services or components.
- **Ignoring Profiler:** Use the Symfony Profiler to debug hook rendering issues.
