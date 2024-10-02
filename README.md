# Laravel DSO

## Overview
Laravel DSO is a web application built with Filament, Livewire and PHP Laravel, providing a modern and responsive interface for mainly calculating character stars, gem/rune/jewel dust, infernal passages and real fragments for amount of portals/runs. There is also an event calendar for displaying the events of the month. Key features include:

- Calculate Character Stats
- Calculate Gem/Rune/Jewel Dust
- Calculate Infernal Passages/Real Fragments for amount of portals/runs

## Installation
Ensure you have [Git](https://git-scm.com/), [Composer](https://getcomposer.org/), and [Node.js](https://nodejs.org/) installed.

1. **Clone the repository:**
   ```bash
   git clone https://github.com/AntonisKazantzis/Laravel-DSO.git
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Set up environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrate database and seed initial data:**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Compile assets and start server:**
   ```bash
   npm run dev
   php artisan serve
   ```

6. **Access the application:**
   - URL: [http://127.0.0.1:8000/login](http://127.0.0.1:8000)

7. **Access the admin panel:**
   - URL: [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)
   - Credentials: 
     - Email: test@test.com
     - Password: password

## Dependencies
- Laravel: 10
- Laravel Pint: 1.15.1
- Filament: 3.2

## Tags
#DSO #Laravel #Tailwind #FullStackDevelopment #Filament #Livewire

## Developer
Antonis Kazantzis
