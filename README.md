# Laravel Livewire Chat System

A real-time online chat system built with **Laravel** and **Livewire**, designed for fast, secure, and interactive communication between users.

## 🚀 Features

- 🔐 **User Registration with Unique Code**
  - Users can register using a unique invitation or identification code.

- 💬 **Private Chat**
  - One-to-one real-time messaging between users.

- 👥 **Group Chat**
  - Create chat groups and communicate with multiple users simultaneously.

- ⚡ **Real-Time Updates**
  - Messages are updated instantly using Laravel Livewire (no page refresh).

- 🧑‍🤝‍🧑 **User List & Online Status**
  - View users and their online/offline status.

- 🔔 **Live Notifications**
  - Receive notifications for new messages.

- 🗑️ **Message Management**
  - Ability to delete messages (optional / configurable).

## 🛠️ Tech Stack

- Laravel
- Livewire
- Blade
- MySQL
- Tailwind CSS (optional)

## 📦 Installation

```bash
git clone https://github.com/your-username/your-repo.git
cd your-repo
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
