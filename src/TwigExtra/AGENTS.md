# Documentation Technique - Sylius TwigExtra

Ce document détaille les extensions Twig utilitaires fournies par le package **Sylius TwigExtra**. Ces outils simplifient l'écriture de templates complexes et améliorent la testabilité.

## 1. Extensions Disponibles (`src/TwigExtra/src/Twig/Extension`)

### `MergeRecursiveExtension`
- **Fonction :** `{{ array1|merge_recursive(array2) }}`
- **Usage :** Fusionne deux tableaux de manière récursive (contrairement au filtre `merge` standard de Twig qui écrase les clés). Indispensable pour composer des configurations complexes ou des attributs HTML imbriqués.

### `RouteExistsExtension`
- **Fonction :** `{{ sylius_route_exists('nom_route') }}`
- **Usage :** Vérifie si une route est définie dans le routeur Symfony. Utile pour afficher conditionnellement des liens (ex: bouton "Edit" seulement si la route d'édition existe).

### `SortByExtension`
- **Filtre :** `{{ collection|sort_by('propriete') }}`
- **Usage :** Trie un tableau d'objets ou de tableaux associatifs selon une clé ou une propriété donnée.

### `TestFormAttributeExtension` & `TestHtmlAttributeExtension`
- **Fonctions :** Helpers pour générer des attributs `data-test-*` ou `data-qa-*`.
- **Usage :** Standardiser les sélecteurs pour les tests E2E (Playwright/Cypress) sans polluer les classes CSS.
  - Ex: `{{ test_html_attribute('submit-button') }}` -> `data-test="submit-button"`

---

## 2. Composants UX (`src/TwigExtra/src/Twig/Ux`)

### `ComponentTemplateFinder`
- Utilitaire interne pour localiser les templates associés aux composants Symfony UX. Facilite l'intégration fluide entre les composants PHP et leurs vues Twig.

---

## 3. Règles de Développement

1.  **Utilisation :** Avant d'écrire une logique complexe dans un template (ex: boucles de tri, vérification de routes), vérifier si une extension ici ne fait pas déjà le travail.
2.  **Performance :** Attention à `merge_recursive` sur de très gros tableaux dans des boucles critiques.
3.  **Tests :** Utiliser systématiquement les attributs de test (`test_html_attribute`) pour les éléments interactifs clés (boutons, inputs) afin de rendre les tests fonctionnels robustes aux changements de design.

---

**Note pour l'IA :** Si tu dois générer des templates Twig pour l'interface admin, pense à utiliser `sort_by` pour les listes et `sylius_route_exists` pour les actions contextuelles.
