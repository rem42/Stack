# Documentation Technique - Google Antigravity

Ce fichier sert de référence absolue pour le développement sur ce dépôt. Il décrit l'architecture, les conventions et les flux de données du projet **Sylius Stack**.

## 1. Présentation du Projet

**Mission :**
Ce dépôt contient les composants nécessaires à la génération d'interfaces d'administration (back-office) robustes et découplées pour des applications Symfony. Il s'appuie sur une architecture modulaire permettant de composer des interfaces riches sans recourir à un framework SPA complet (React/Vue), en privilégiant **Symfony UX** et **Hotwire (Stimulus)**.

**Stack Technique Actuelle :**
- **Backend :** PHP 8.1+, Symfony 6.4/7.x (Components: HttpKernel, Security, DependencyInjection).
- **Frontend :** Twig, Stimulus, Symfony UX (Live Component, Twig Component, Autocomplete, Icons).
- **Architecture :** Monorepo modulaire (AdminUi, BootstrapAdminUi, TwigHooks).

---

## 2. Structure des Dossiers

L'architecture est organisée en composants découplés dans `src/` :

### `src/` (Composants PHP)
- **`AdminUi/`** : Cœur logique de l'interface admin. Fournit les routes génériques, la sécurité de base et les templates minimaux.
- **`BootstrapAdminUi/`** : Implémentation visuelle utilisant Bootstrap 5. Dépend de `AdminUi`. Contient les assets spécifiques et l'intégration UX.
- **`TwigHooks/`** : Système de hooks pour Twig permettant une composition flexible des layouts (zones de contenu dynamiques).
- **`TwigExtra/`** : Extensions Twig supplémentaires pour le formatage et les utilitaires.
- **`UiTranslations/`** : Catalogue de traductions pour l'interface.

### `assets/` (Frontend)
- **`app.js`** : Point d'entrée principal. Initialise Stimulus.
- **`controllers/`** : Contrôleurs Stimulus.
  - Configuration automatique via `@symfony/ux-live-component` et `@symfony/ux-autocomplete`.
- **`styles/`** : Fichiers CSS/SCSS (Bootstrap surchargé).

### `templates/` (Vues)
- **`base/`** : Layouts globaux.
- **`component/`** : Templates des Twig Components et Live Components.
- **`[Entity]/`** : Templates CRUD spécifiques (ex: `book/`, `speaker/`).

### `config/`
- Configuration des bundles et des routes.
- **`packages/security.yaml`** : Configuration du firewall `admin` (login, logout, provider).

---

## 3. Règles de Code et Conventions

### PHP / Symfony
1.  **Typage Strict :** `declare(strict_types=1);` obligatoire dans tous les fichiers PHP.
2.  **Attributs PHP 8 :** Utiliser les attributs pour la configuration.
    - Routing : `#[Route('/path', name: 'app_route')]`
    - Injection de Dépendances : Constructor Injection privilégiée.
    - Live Components : `#[AsLiveComponent]`, `#[LiveProp(writable: true)]`, `#[LiveAction]`.
3.  **Décoration de Services :** Pour étendre les fonctionnalités (ex: Menu), utiliser le pattern Décorateur.
    ```php
    #[AsDecorator(decorates: 'sylius_admin_ui.knp.menu_builder')]
    final readonly class MenuBuilder implements MenuBuilderInterface { ... }
    ```
4.  **Contrôleurs :** Doivent rester maigres (Thin Controllers). Déléguer la logique métier aux Services ou Handlers.

### Frontend (Twig / Stimulus / UX)
1.  **Twig Components :** Privilégier les composants Twig pour les éléments réutilisables (boutons, cartes, tableaux).
2.  **Live Components :** Utiliser pour les interactions dynamiques sans rechargement de page (recherche, formulaires complexes, filtres).
    - Ne pas écrire de JavaScript manuel si un Live Component peut le gérer.
3.  **Stimulus :**
    - Nommage : `kebab-case` pour les contrôleurs.
    - Utiliser `getComponent()` de `@symfony/ux-live-component` pour interagir avec le backend depuis JS.
    - Cibles : Utiliser `static targets = [...] ` pour référencer les éléments DOM.

---

## 4. Flux de Données

Le flux suit le modèle MVC amélioré par Symfony UX :

1.  **Requête Initiale (HTTP GET) :**
    - Le contrôleur Symfony reçoit la requête.
    - Il prépare les données (via Doctrine/Services) et rend un template Twig.
    - Twig génère le HTML initial, incluant les attributs `data-controller` pour Stimulus.

2.  **Interactions Client (Frontend) :**
    - **Actions Simples :** Gérées par des contrôleurs Stimulus (ex: toggle menu).
    - **Actions Complexes (Data-Driven) :** Gérées par des **Live Components**.
        - L'utilisateur interagit (ex: tape dans une recherche).
        - Le composant Live envoie une requête AJAX automatique au backend.
        - Le backend met à jour l'état du composant PHP (`#[LiveProp]`) et re-rend le template partiel.
        - Le DOM est mis à jour intelligemment via Morphdom.

3.  **Hooks Twig :**
    - Les templates utilisent des hooks (`{% hook 'sidebar' %}`) pour permettre l'injection de contenu par d'autres bundles ou configurations, sans modifier le template parent.

---

**Note pour l'IA :** Lors de la génération de code, vérifie toujours la compatibilité avec Symfony 6.4+ et l'utilisation des attributs PHP. Assure-toi que les Live Components sont correctement déclarés avec `#[AsLiveComponent]`.
