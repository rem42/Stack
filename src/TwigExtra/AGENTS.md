# AI Contribution Guidelines - TwigExtra

Guidelines for AI assistants contributing to the `TwigExtra` component of the Sylius Stack. This package provides **utility Twig extensions** to simplify complex template logic.

## Reference Files

When working on TwigExtra, check these files for patterns:

### Extensions
- Recursive Merge: `src/TwigExtra/src/Twig/Extension/MergeRecursiveExtension.php`
- Route Existence: `src/TwigExtra/src/Twig/Extension/RouteExistsExtension.php`
- Sorting: `src/TwigExtra/src/Twig/Extension/SortByExtension.php`
- Test Attributes: `src/TwigExtra/src/Twig/Extension/TestHtmlAttributeExtension.php`

## General Guidelines

### Project Structure & Philosophy

- **Utility Layer:** This package is a collection of helper functions and filters for Twig.
- **Simplification:** It aims to reduce complex logic (e.g., sorting arrays) directly in templates.
- **Testing:** It provides helpers (`test_html_attribute`) to standardize E2E testing selectors.

### Dependencies

- `twig/twig`: Core template engine.
- `symfony/routing`: For route existence checks.

## PHP Code

- **Strict Types:** `declare(strict_types=1);` is mandatory.
- **Extension Logic:** Keep extension logic simple and focused on template manipulation.
- **Performance:** Be mindful of performance implications (e.g., recursive merging large arrays).

## Templates and Hooks

- **Using Extensions:**
  - `{{ array1|merge_recursive(array2) }}`
  - `{{ collection|sort_by('property') }}`
  - `{{ sylius_route_exists('route_name') }}`
  - `{{ test_html_attribute('selector') }}`

## Common Mistakes to Avoid

- **Reimplementing Logic:** Check existing extensions before writing custom Twig logic.
- **Hardcoding Test Selectors:** Always use `test_html_attribute()` instead of manual `data-test=""`.
- **Inefficient Sorting:** Avoid sorting large collections directly in Twig if possible (prefer database queries).
