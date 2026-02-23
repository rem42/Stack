# Documentation Technique - Sylius AdminUi

Ce document détaille l'architecture et les composants du package **Sylius AdminUi**. Il complète la documentation racine pour les développements spécifiques à ce module.

## 1. Présentation du Module

**Rôle :**
Fournit le squelette logique et structurel de l'interface d'administration. Il est **agnostique du framework CSS** (le style est géré par `BootstrapAdminUi` ou d'autres implémentations). Il définit les contrats, les routes de base (login, dashboard) et la structure des templates CRUD.

**Dépendances Clés :**
- `knplabs/knp-menu-bundle` : Gestion des menus.
- `sylius/twig-hooks` : Système de hooks pour l'injection de contenu.
- `symfony/security-bundle` : Gestion de l'authentification.

---

## 2. Structure Interne (`src/AdminUi/src`)

### `Knp/` (Menus)
- **`Menu/MenuBuilderInterface.php`** : Contrat pour la construction du menu principal.
- **`Menu/MenuBuilder.php`** : Implémentation de base.
  - **Règle :** Pour ajouter des items au menu, utiliser le pattern Décorateur sur le service `sylius_admin_ui.knp.menu_builder`.

### `Symfony/` (Intégration Framework)
- **`Controller/LoginController.php`** : Gère l'affichage du formulaire de connexion (`sylius_admin_ui_login`) et la déconnexion.
- **`Form/Type/LoginType.php`** : Formulaire de connexion standard (champs `_username`, `_password`).
- **`DependencyInjection/`** : Configuration du bundle.
  - Charge les services depuis `config/services.php`.

### `Twig/` (Extensions)
- **`Extension/RedirectPathExtension.php`** : Fournit des fonctions pour gérer les redirections après actions CRUD.

### `TwigHooks/` (Intégration Hooks)
- **`Hookable/Metadata/RoutingHookableMetadataFactory.php`** : Permet de définir des hooks basés sur le routing actuel (contexte de la page).

---

## 3. Templates (`src/AdminUi/templates`)

Ce module fournit les templates **abstraits** ou squelettes :

- **`base.html.twig`** : Layout racine définissant les blocs principaux (`title`, `stylesheets`, `javascripts`, `body`).
- **`dashboard/index.html.twig`** : Page d'accueil par défaut.
- **`security/login.html.twig`** : Page de connexion.
- **`crud/`** : Templates génériques pour les opérations CRUD (Create, Read, Update, Delete).
  - `index.html.twig`
  - `create.html.twig`
  - `update.html.twig`
  - `show.html.twig`

**Convention :** Ces templates utilisent intensivement les **Twig Hooks** (`{% hook 'nom_du_hook' %}`) pour permettre aux thèmes (comme `BootstrapAdminUi`) d'injecter le markup spécifique.

---

## 4. Règles de Développement

1.  **Agnosticisme CSS :** Ne jamais inclure de classes CSS spécifiques (Bootstrap, Tailwind) dans les templates de ce module, sauf si elles sont purement utilitaires et standardisées. Le style doit être apporté par le thème parent ou le bundle d'implémentation.
2.  **Extensibilité :** Tout nouveau template doit exposer des hooks clairs pour permettre la personnalisation.
3.  **Contrats d'Interface :** Toujours préférer l'injection d'interfaces (ex: `MenuBuilderInterface`) plutôt que les classes concrètes.
4.  **Nommage des Routes :** Préfixer toutes les routes par `sylius_admin_ui_`.

---

**Note pour l'IA :** Lors de la modification de ce module, garde à l'esprit qu'il sert de fondation. Les changements ici impactent toutes les implémentations visuelles (BootstrapAdminUi, etc.).
