# 🚀 API-V2

## 📋 Description

Ce projet est une application Laravel, configurée avec Docker via Laravel Sail. Utilisez MariaDB pour la base de données, Redis pour le caching, et phpMyAdmin pour la gestion de la base de données.

## 🔧 Prérequis

## 🛠 Installation et Démarrage

### Cloner le projet

```bash
    git clone https://github.com/Unknow-name-pending/api.git
```

```bash
    cd api
```

### Installer les dépendances

```bash
    composer install
```

### Configurer les variables d'environnement

```bash
    cp .env.example .env
```

### Configurer les variables d'environnement pour l'environement de test

```bash
    cp .env.example .env.testing
```

### Démarrer les services Docker

```bash
    ./vendor/bin/sail up -d
```

📦 Services :
    - Laravel (PHP 8.3)
    - MariaDB (version 10)
    - Redis (Alpine)
    - phpMyAdmin (latest)

### Initialiser l'application

```bash
    ./vendor/bin/sail artisan key:generate
```

```bash
    ./vendor/bin/sail artisan migrate
```

## 🌐 Accès aux Services

- Laravel : <http://localhost>
- phpMyAdmin : <http://localhost:8080>
- Base de données : Port 3306 (modifiable dans .env)

### 👀 Partager votre api

```bash
    sail share --subdomain=my-sail-site
```

### 👀 Vérifier le code

```bash
    ./vendor/bin/phpcs app     
```

## ⏹ Arrêter les Services

```bash
    ./vendor/bin/sail stop
```

## ⏹ Details serveur pulse

```bash
    ./vendor/bin/sail artisan pulse:check 
```
