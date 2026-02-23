# Documentation Technique - Sylius BootstrapAdminUi

Ce document détaille l'architecture et les composants du package **Sylius BootstrapAdminUi**. Il s'agit de l'implémentation visuelle de référence pour `AdminUi`, basée sur Bootstrap 5.

## 1. Présentation du Module

**Rôle :**
Fournit les templates concrets, le style (SCSS), et les comportements JavaScript (Stimulus) pour l'interface d'administration. Il transforme la structure abstraite de `AdminUi` en une interface utilisateur fonctionnelle et esthétique.

**Technologies Clés :**
- **Bootstrap 5** : Framework CSS.
- **Symfony UX** : Icônes (`tabler`), Composants Live.
- **Stimulus** : Gestion des interactions JS.
- **Webpack/AssetMapper** : Gestion des assets.

---

## 2. Structure Interne

### `assets/` (Frontend Sources)
- **`controllers/`** : Contrôleurs Stimulus spécifiques au thème.
- **`styles/`** : Sources SCSS.
  - `main.scss` : Point d'entrée.
  - `_variables.scss` : Surcharges des variables Bootstrap.
  - `_sidebar.scss`, `_navbar.scss`, etc. : Styles des composants.
- **`scripts/`** : Scripts JS utilitaires (non-Stimulus ou initiaux).

### `config/` (Configuration & Mapping)
- **`app/twig_hooks/`** : **Cœur de l'intégration**. Ce dossier contient les fichiers PHP définissant le mapping entre les hooks abstraits (définis par `AdminUi` ou par le développeur) et les templates concrets de ce bundle.
  - Ex: `common/index.php` mappe le hook `sylius_admin.common.index.content` vers `.../content.html.twig`.

### `src/Twig/Component/`
- **`UserDropdownComponent.php`** : Composant Twig pour le menu utilisateur dans la navbar.

---

## 3. Templates (`templates/`)

Les templates sont organisés pour être injectés via le système de Hooks.

### `shared/layout/`
- `stylesheets.html.twig`, `javascripts.html.twig` : Inclusion des assets compilés.

### `shared/crud/`
- Implémentation des vues CRUD standard (Create, Index, Show, Update).
- **`common/`** : Éléments partagés (Navbar, Sidebar, Flashes).
  - `sidebar/menu.html.twig` : Rendu du menu KnpMenu avec le style Bootstrap.

### `shared/grid/`
- Templates pour **Sylius Grid Bundle**.
- `action/` : Boutons d'action (Edit, Delete).
- `filter/` : Widgets de filtres.
- `field/` : Rendu des champs de données.

### `shared/helper/`
- Composants atomiques réutilisables :
  - `accordion.html.twig`
  - `modal.html.twig`
  - `table.html.twig`

---

## 4. Règles de Développement

1.  **Personnalisation du Style :** Ne pas modifier `main.scss` directement si possible. Utiliser les variables SCSS pour surcharger le thème.
2.  **Mapping des Hooks :** Pour changer l'apparence d'une section sans toucher au code PHP, modifier la configuration des hooks dans `config/packages/sylius_twig_hooks.yaml` (dans l'application finale) pour pointer vers un nouveau template.
3.  **Icônes :** Utiliser `ux-icons` (set `tabler` par défaut).
    - Ex: `{{ ux_icon('tabler:edit') }}`.
4.  **Javascript :** Privilégier les contrôleurs Stimulus pour toute interactivité. Éviter le jQuery ou le JS vanilla global.

---

**Note pour l'IA :** Ce module est "l'habillage". Si on te demande de changer la couleur d'un bouton ou la disposition de la sidebar, c'est ici qu'il faut agir (SCSS ou Templates). Si on te demande de changer la logique de redirection, c'est dans `AdminUi`.
