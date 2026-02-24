# AI Contribution Guidelines - UiTranslations

Guidelines for AI assistants contributing to the `UiTranslations` component of the Sylius Stack. This package provides the **centralized translation catalog** (i18n) for the admin interface.

## Reference Files

When working on UiTranslations, check these files for patterns:

### Translation Files
- French (Default): `src/UiTranslations/translations/messages.fr.yaml`
- English: `src/UiTranslations/translations/messages.en.yaml`
- Spanish: `src/UiTranslations/translations/messages.es.yaml`
- German: `src/UiTranslations/translations/messages.de.yaml`

## General Guidelines

### Project Structure & Philosophy

- **Centralized Keys:** This package acts as the single source of truth for common admin UI labels (`sylius.ui.*`).
- **Convention-Based:** Keys follow a strictly defined hierarchy (`context.action`).
- **Language Pivot:** English (`messages.en.yaml`) is the pivot language for new keys.

### Dependencies

- `symfony/translation`: Translation component.

## PHP Code

- **Strict Types:** `declare(strict_types=1);` is mandatory (if PHP classes are added).
- **Service Configuration:** Configuration is minimal (translation files loaded by Symfony).

## Translation Keys & Conventions

- **Pattern:** `sylius.ui.[context].[action_or_element]`
- **Common Examples:**
  - `sylius.ui.create`: "Create"
  - `sylius.ui.update`: "Update"
  - `sylius.ui.delete`: "Delete"
  - `sylius.ui.show`: "Show"
  - `sylius.ui.cancel`: "Cancel"
  - `sylius.ui.save_changes`: "Save changes"

## Common Mistakes to Avoid

- **Hardcoding Text:** Never write user-visible text directly in templates. Use translation keys.
- **Duplicating Keys:** Check if a generic key (e.g., `sylius.ui.save`) exists before creating a specific one.
- **Inconsistent Naming:** Follow the `sylius.ui.*` pattern strictly.
- **Missing Translations:** Ensure new keys are added to at least English and French files.
