# Shape Guessing Experiment - Yii2 Application

A web application built with Yii2 framework that allows users to participate in a shape guessing experiment.

## Features

- **User Registration & Authentication**: Users can register and login to participate
- **Shape Guessing Game**: 20-trial experiment where users guess which shape (circle, triangle, square) is stored in the database
- **Real-time Progress**: Shows current trial number and correct guesses so far
- **Detailed Results**: After completion, shows trial-by-trial results with color-coded correct/incorrect indicators
- **Statistical Analysis**: 
  - CSV export of all experiment data
  - Histogram visualization using R
  - Statistical significance testing against random chance
- **PostgreSQL Database**: All data stored in PostgreSQL database

## Database Structure

- **users**: User accounts with authentication
- **shapes**: Available shapes (circle, triangle, square)
- **experiments**: User experiments with correct sequences and results

## How It Works

1. User registers and a random sequence of 20 shape IDs is generated
2. User participates in 20 trials, guessing which shape is stored
3. Results are compared and accuracy is calculated
4. Detailed results show each trial with correct/incorrect indicators
5. Aggregate statistics show distribution across all users

## Installation & Setup

1. PostgreSQL and PHP are already installed
2. Database `shape_guessing_db` is created with user `shape_user`
3. All tables are created and populated with shape data
4. Application is ready to run

## Running the Application

The application is already running on port 8080. You can access it at:
- http://localhost:8080

## Navigation

- **Home**: Welcome page with instructions
- **Register**: Create new user account
- **Login**: Existing user login
- **Experiment**: Participate in shape guessing
- **Statistics**: View aggregate data and analysis

## Statistical Analysis

The application includes:
- **Chi-square test** for randomness
- **Binomial distribution** comparison (expected vs observed)
- **R-generated histograms** with expected distribution overlay
- **P-value calculation** to assess statistical significance

## Files Structure

- `models/`: User, Experiment, Shape models
- `controllers/`: Auth, Experiment, Statistics controllers  
- `views/`: All view templates
- `migrations/`: Database migration files
- `web/images/`: Shape SVG files

The application is fully functional and ready for users to participate in the shape guessing experiment!
