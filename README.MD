# Laravel Multi-Role Authentication Package

<div align="center">
  
![Laravel Version](https://img.shields.io/badge/Laravel-10.x%20%7C%2011.x%20%7C%2012.x-red)
![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Downloads](https://img.shields.io/badge/downloads-1k%2B-brightgreen)

A powerful, flexible, and production-ready multi-role authentication system for Laravel applications.

</div>

## 📋 Table of Contents

- [Features](#-features)
- [Requirements](#-requirements)
- [Quick Start](#-quick-start)
- [Detailed Installation](#-detailed-installation)
- [Configuration](#-configuration)
- [Usage Guide](#-usage-guide)
  - [Role Management](#role-management)
  - [Permission Management](#permission-management)
  - [Middleware Protection](#middleware-protection)
  - [Blade Directives](#blade-directives)
  - [API Protection](#api-protection)
- [Artisan Commands](#-artisan-commands)
- [Helper Functions](#-helper-functions)
- [Testing](#-testing)
- [Troubleshooting](#-troubleshooting)
- [Security](#-security)
- [Contributing](#-contributing)
- [License](#-license)

---

## ✨ Features

| Feature | Description |
|---------|-------------|
| 🎭 **Unlimited Roles** | Create unlimited roles with custom permissions |
| 📊 **Role Hierarchy** | Priority-based role system with inheritance |
| 🔐 **Permission Management** | Granular access control at permission level |
| 🛡️ **Multi-Guard Support** | Web, Admin, and API guards support |
| 🎯 **Smart Redirects** | Role-specific dashboards after login |
| 🚀 **Middleware Protection** | `role:admin`, `role:editor\|moderator` |
| 🎨 **Blade Directives** | `@role`, `@hasrole`, `@canrole` directives |
| 📱 **API Ready** | Built-in middleware for REST APIs |
| 🎛️ **Admin Panel** | Complete CRUD interface for roles/permissions |
| ⌨️ **Artisan Commands** | CLI tools for quick role management |

---

## 📦 Requirements

- **PHP**: 8.1 or higher
- **Laravel**: 10.x, 11.x, or 12.x
- **Database**: MySQL 5.7+, PostgreSQL 9.4+, SQLite 3.8+, SQL Server 2017+
- **Composer**: Latest stable version

---

## 🚀 Quick Start

Get up and running in 3 simple steps:

```bash
# Step 1: Install the package
composer require mitul456/laravel-multi-role-auth

# Step 2: Run installation command
php artisan multirole:install

# Step 3: Add trait to your User model
# Add this line to app/Models/User.php: use LaravelMultiRoleAuth\Traits\HasRoles;