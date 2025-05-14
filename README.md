# Forex Institute Online Learning Platform

A comprehensive online learning platform for Forex trading education.

## Getting Started

Follow these instructions to get a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

- PHP (^8.0 recommended)
- Composer
- Node.js (^16.0 recommended)
- npm
- MySQL or other compatible database

### Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/sasankadeshapriya/forex-institute.git
   cd forex-institute
2. **Install Dependencies**
   ```bash
   composer install
   npm i
3. **Set Up Environment File**
   ```bash
   cp .env.example .env
4. **Generate Application Key**
   ```bash
   php artisan key:generate
5. **Run Database Migrations**
   ```bash
   php artisan migrate
6. **Compile Frontend Assets**
   ```bash
   npm run dev
7. **Serve the Application**
   ```bash
   php artisan serve
