# TilePet

## Overview

TilePet is a small project that brings my lifelong dream to life: creating a vibrant world populated by autonomous NPCs, affectionately known as **Noobs**. Each Noob operates independently, making decisions, gathering resources, and evolving over time to create a dynamic and engaging simulation.

## Features

- **Autonomous Noobs:** Each Noob is driven by its own AI thread, allowing for unique behaviors and interactions.
- **Defined Actions & Resources:** All actions, resources, and items are coded and accessible to the AI via function calls.
- **Skill Progression:** Noobs can develop skills over time, enhancing their abilities and unlocking new actions.
- **Intelligent Pathfinding:** Implements the A* algorithm for efficient navigation around obstacles.
- **Basic UI:** A simple interface to monitor and interact with Noobs in real-time.

## Requirements

- **PHP** (8.0 or higher)
- **Composer** for managing PHP dependencies
- **Relational Database** (SQLite recommended)
- **Redis** (optional, but recommended for managing queues with Horizon)
- **Node.js & NPM** for compiling front-end assets

## Installation

1. **Clone the Repository**

```bash
git clone https://github.com/yourusername/tilepet.git
cd tilepet
```

2. **Install PHP Dependencies**

```bash
composer install
```

3. **Install Node.js Dependencies**

```bash
npm install
```

4. **Set Up Environment Variables**

   - Copy the example environment file and configure it:

   ```bash
   cp .env.example .env
   ```

   - Generate the application key:

   ```bash
   php artisan key:generate
   ```

   - Configure your `.env` file with the necessary settings, such as database connection, Redis, and OpenAI API key.

5. **Compile Front-End Assets**

   ```bash
   npm run dev
   ```

   For production:

   ```bash
   npm run build
   ```

6. **Run Migrations and Seed the Database**

   ```bash
   php artisan migrate --seed
   ```

7. **Start Laravel Horizon (Queue Management)**

   ```bash
   php artisan horizon
   ```

8. **Run the Scheduler**

   ```bash
   php artisan schedule:run
   ```

   **Tip:** For continuous operation, set up a cron job to execute the scheduler every minute:

   ```cron
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

9. **Start the Development Server**

   ```bash
   php artisan serve
   ```

   Access the application at `http://localhost:8000`.

## Usage

- **View Noobs:** Navigate to the home page to see a list of all Noobs.
- **Noob Details:** Click on a Noob to view detailed information, including inventory, skills, and actions.
- **Interact:** While the UI currently provides a basic overview, future updates will allow you to issue commands and interact with Noobs directly.

## Contributing

I’m excited to see TilePet grow! If you’d like to contribute, feel free to fork the repository and submit a pull request. Any improvements or new features are welcome!

## License

This project is open-source and available under the MIT License.

------

**Happy Simulating! 🐾**
