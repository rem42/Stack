# Documentation Technique - Sylius TwigHooks

Ce document détaille le fonctionnement interne du package **Sylius TwigHooks**. C'est le moteur de composition d'interface utilisé par toute la stack.

## 1. Concept Fondamental

**Problème :** Les héritages de templates Twig (`{% extends %}`) sont rigides. Modifier un bloc nécessite souvent de surcharger tout le fichier.
**Solution :** TwigHooks introduit un système d'injection dynamique.
- **Hook Point :** `{% hook 'nom_du_hook' %}` dans un template définit une zone d'insertion.
- **Hookable :** Un élément (Template Twig ou Composant) configuré pour s'afficher dans un hook donné.

---

## 2. Architecture Interne (`src/TwigHooks/src`)

### `Twig/` (Extension Twig)
- **`TokenParser/HookTokenParser.php`** : Compile le tag `{% hook %}`.
- **`Runtime/HooksRuntime.php`** : Exécuté au rendu. Appelle le `HookRenderer`.

### `Hook/` et `Hookable/`
- **`Renderer/HookRenderer.php`** : Orchestre le rendu d'un hook.
  1.  Récupère tous les *Hookables* configurés pour ce nom de hook.
  2.  Trie les hookables par priorité.
  3.  Rend chaque hookable séquentiellement.
- **`Hookable/`** : Types d'éléments insérables.
  - `HookableTemplate` : Un fichier `.html.twig`.
  - `HookableComponent` : Un Twig Component ou Live Component.
- **`Merger/`** : Gère la fusion des configurations (ex: écraser un hookable défini dans un bundle par une config locale).

### `Bag/` (Context)
- **`DataBag.php`** : Structure de données passée aux templates rendus par le hook. Permet de transmettre le contexte (ex: l'entité courante `resource`) du template parent vers les enfants injectés.

### `Profiler/`
- Intégration à la Web Debug Toolbar de Symfony pour inspecter les hooks rendus, leur ordre et leur temps d'exécution.

---

## 3. Utilisation et Configuration

### Côté Template (Définition du point d'ancrage)
```twig
{# Dans base.html.twig #}
<div class="sidebar">
    {% hook 'sylius_admin.sidebar' %}
</div>
```

### Côté Configuration (PHP/YAML)
C'est ici que l'assemblage se fait. Le bundle lit la configuration pour savoir quoi mettre dans `sylius_admin.sidebar`.

Exemple théorique de structure interne (géré via `sylius_twig_hooks.yaml` dans l'app) :
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

## 4. Règles de Développement

1.  **Performance :** Le rendu de hooks est rapide mais pas gratuit. Éviter d'imbriquer des hooks trop profondément (N+1 hooks).
2.  **Contexte :** Les variables Twig du scope parent **ne sont pas** automatiquement passées aux enfants (contrairement à `include`). Il faut passer explicitement le contexte via le `DataBag` si nécessaire, ou configurer le hook pour accepter certaines variables contextuelles.
3.  **Débuggage :** Utiliser la commande `bin/console debug:twig-hooks` ou le profiler Symfony pour comprendre pourquoi un bloc ne s'affiche pas.

---

**Note pour l'IA :** Ce bundle est de la pure infrastructure. Tu n'auras probablement pas à modifier le code PHP ici, mais tu devras comprendre comment *configurer* les hooks en utilisant les structures définies ici pour assembler les pages dans `AdminUi`/`BootstrapAdminUi`.
