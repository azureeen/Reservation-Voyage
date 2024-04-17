# Application de Réservation de Voyages

## Description
Ce projet est une application web de réservation de voyages développée avec Symfony, conçue pour offrir une plateforme sécurisée et intuitive permettant aux utilisateurs de planifier et réserver leurs voyages facilement. L'application garantit la confidentialité et l'intégrité des données personnelles des utilisateurs tout en fournissant une expérience utilisateur fluide et responsive.

## Fonctionnalités
- **Recherche de voyages** : Les utilisateurs peuvent rechercher des voyages selon différents critères tels que la destination, la date et le budget.
- **Réservation de voyages** : Fonctionnalité permettant aux utilisateurs de réserver des voyages directement via l'application.
- **Gestion de profil** : Les utilisateurs peuvent créer et gérer leur profil, y compris leurs informations de contact et préférences de voyage.
- **Historique des réservations** : Les utilisateurs peuvent consulter l'historique de leurs réservations et accéder à leurs itinéraires.

## Sécurité
L'application intègre des mesures de sécurité robustes dès la conception, incluant :
- Authentification multi-facteurs (MFA).
- Chiffrement des données sensibles.
- Contrôle d'accès basé sur les rôles.
- Prévention des injections SQL et des attaques XSS.

## Technologies Utilisées
- **Frontend** : Vue.js
- **Backend** : Symfony, PHP
- **Base de données** : MySQL
- **Tests** : PHPUnit pour les tests automatisés
- **CI/CD** : GitHub Actions pour l'intégration et la livraison continues

## Comment démarrer?
1. Clonez le dépôt : `git clone https://github.com/<votre-nom-d'utilisateur>/<nom-du-repot>.git`
2. Installez les dépendances : `composer install`
3. Lancez les tests : `./bin/phpunit`
4. Démarrez le serveur local : `symfony server:start`

## Contribuer
Les contributions sont les bienvenues ! Veuillez consulter notre `CONTRIBUTING.md` pour les détails sur comment proposer des pull requests, rapporter des bugs ou demander des fonctionnalités.

## Licence
Ce projet est sous licence selon les termes de la licence MIT.

---

Pour plus d'informations sur la configuration et l'utilisation de l'application, veuillez consulter la documentation complète disponible dans le wiki du projet.
