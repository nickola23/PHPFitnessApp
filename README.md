# Gym / Fitness Application

PHP fitness/gym application for tracking memberships, creating/joining training groups, and providing statistical insights.

## Description

This is a PHP-based fitness/gym application designed to help users track their memberships, explore and join training groups, while allowing admins and fitness centers to create training groups, and allow users to join group sessions, supplying them with statistics data.

## Features

### 1. Membership Management
- Track membership payment and expiration dates for each user.
- Option to renew memberships.
- View the history of all previous membership payments.

### 2. Group Training
- Instructors can create training groups
- Users can view available groups and register to participate.
- Record all users within each group.

## Technologies
- **Backend**: PHP.
- **Database**: MySQL.
- **Frontend**: HTML, CSS, JavaScript.

## How to Run the Project

1. Clone the repository:
   ```bash
   git clone https://github.com/nickola23/PHPFitnessApp.git
   ```

2. Import the database:
   - The SQL script for creating the database is located in the `database/` folder (e.g., `fittrack.sql`).
   - Create database named `fittrack`
   - Import the script into your database.

4. Start a local server

5. Access the application:
   - Open a browser and go to: `http://localhost:3000`
