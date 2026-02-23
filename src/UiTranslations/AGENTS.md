# Documentation Technique - Sylius UiTranslations

Ce document détaille les conventions d'internationalisation (i18n) fournies par le package **Sylius UiTranslations**. Il centralise les labels communs de l'interface d'administration.

## 1. Structure

**Fichiers de traduction :** `translations/messages.[lang].yaml`
- Contiennent les clés de traduction standard.
- Domaine par défaut : `messages`.

## 2. Conventions de Nommage

Les clés doivent suivre une structure hiérarchique logique pour garantir la cohérence :

`sylius.ui.[contexte].[action_ou_element]`

### Exemples Courants
- **Actions CRUD :**
  - `sylius.ui.create` : "Create"
  - `sylius.ui.update` : "Update"
  - `sylius.ui.delete` : "Delete"
  - `sylius.ui.show` : "Show"
  - `sylius.ui.cancel` : "Cancel"
  - `sylius.ui.save_changes` : "Save changes"

- **Interface Générale :**
  - `sylius.ui.dashboard` : "Dashboard"
  - `sylius.ui.login` : "Login"
  - `sylius.ui.logout` : "Logout"
  - `sylius.ui.success` : "Success"
  - `sylius.ui.error` : "Error"

- **Formulaires :**
  - `sylius.ui.username` : "Username"
  - `sylius.ui.password` : "Password"

---

## 3. Règles de Développement

1.  **Réutilisation :** Avant de créer une nouvelle clé, vérifier si une clé générique existe déjà (ex: `sylius.ui.save` au lieu de `app.ui.save_product`).
2.  **Hardcoding Interdit :** Ne jamais écrire de texte en dur dans les templates Twig ou les contrôleurs. Toujours utiliser le filtre `trans` (`|trans`) ou le service Translator.
    - Mauvais : `<button>Save</button>`
    - Bon : `<button>{{ 'sylius.ui.save'|trans }}</button>`
3.  **Ajout de Clés :** Si une nouvelle clé est nécessaire, l'ajouter d'abord dans `messages.en.yaml` (langue pivot), puis dans les autres langues si possible.

---

**Note pour l'IA :** Lors de la génération de code (templates ou formulaires), utilise systématiquement ces clés de traduction pour garantir que l'interface est multilingue dès le départ.
