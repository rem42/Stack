# Technical Documentation - Sylius UiTranslations

This document details the internationalization (i18n) conventions provided by the **Sylius UiTranslations** package. It centralizes common labels for the administration interface.

## 1. Structure

**Translation Files:** `translations/messages.[lang].yaml`
- Contain standard translation keys.
- Default domain: `messages`.

## 2. Naming Conventions

Keys must follow a logical hierarchical structure to ensure consistency:

`sylius.ui.[context].[action_or_element]`

### Common Examples
- **CRUD Actions:**
  - `sylius.ui.create`: "Create"
  - `sylius.ui.update`: "Update"
  - `sylius.ui.delete`: "Delete"
  - `sylius.ui.show`: "Show"
  - `sylius.ui.cancel`: "Cancel"
  - `sylius.ui.save_changes`: "Save changes"

- **General Interface:**
  - `sylius.ui.dashboard`: "Dashboard"
  - `sylius.ui.login`: "Login"
  - `sylius.ui.logout`: "Logout"
  - `sylius.ui.success`: "Success"
  - `sylius.ui.error`: "Error"

- **Forms:**
  - `sylius.ui.username`: "Username"
  - `sylius.ui.password`: "Password"

---

## 3. Development Rules

1.  **Reuse:** Before creating a new key, check if a generic key already exists (e.g., `sylius.ui.save` instead of `app.ui.save_product`).
2.  **Hardcoding Forbidden:** Never write hardcoded text in Twig templates or controllers. Always use the `trans` filter (`|trans`) or the Translator service.
    - Bad: `<button>Save</button>`
    - Good: `<button>{{ 'sylius.ui.save'|trans }}</button>`
3.  **Adding Keys:** If a new key is necessary, add it first to `messages.en.yaml` (pivot language), then to other languages if possible.

---

**Note for AI:** When generating code (templates or forms), systematically use these translation keys to ensure the interface is multilingual from the start.
