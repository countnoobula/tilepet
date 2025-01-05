# TilePet

## Overview
This is a small project to create a simulation of NPC's (called `Noobs`) in a world.
`Actions`, `Resources` and `Items` are all defined in the code and exposed to the LLM via `functions`.

The key aspect is to have an LLM thread (OpenAI works, or any compatible AI) per `Noob` to drive the simulation.

## Requirements
- PHP (Obviously)
- Relational Database (I use SQLite 🤷‍♂)
- Redis (Optional, but recommended - Gives Horizon overview)

## How to start
1. Clone the repo
2. Run `composer install`
3. Create a `.env` file and copy the contents of `.env.example` into it
4. Run `php artisan migrate --seed` to create the database and seed the basic information
5. Run `php artisan horizon` to manage the jobs
6. Run `php artisan schedule:run` to tick forward one action
