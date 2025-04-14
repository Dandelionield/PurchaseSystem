# Purchase Management System

A comprehensive web-based system for managing purchases and time capture. Built with Mysql, PHP, and ActiveRecord ORM.

## Features ✨

- **User Authentication & Authorization**
  - Role-based access control (Admin)
  - Secure password hashing
  - Session management

- **Sales Processing** 💰
  - Transactional purchase system

## Tech Stack 🛠️

- **Backend**: PHP 7.4
- **Database**: Mysql 5.7
- **Web Server**: nginx 1.14
- **ORM**: [PHP ActiveRecord](http://www.phpactiverecord.org/)
- **Frontend**: Bootstrap 5, HTML5, CSS3

## Installation 💻

### Prerequisites
- PHP 7.4+
- Mysql 5.7
- Docker Compose
- Web server (Apache/Nginx)

```bash
# Clone repository
git clone https://github.com/Dandelionield/PurchaseSystem.git
cd PurchaseSystem

# RUN
docker-composer up --build
