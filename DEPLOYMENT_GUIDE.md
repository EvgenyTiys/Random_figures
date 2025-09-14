# Shape Guessing Experiment - Deployment Guide

## 🎯 Application Overview

A complete Yii2 web application for conducting shape guessing experiments with:
- User registration and authentication
- 20-trial shape guessing game (circle, triangle, square)
- Real-time progress tracking
- Detailed results with color-coded feedback
- Statistical analysis with R-generated histograms
- CSV data export functionality
- PostgreSQL database storage

## 🚀 Quick Start

1. **Start the application:**
   ```bash
   cd /workspace/shape-guessing-app
   ./start_server.sh
   ```

2. **Access the application:**
   - Open browser to `http://localhost:8080`
   - Register a new user account
   - Start the shape guessing experiment

## 📊 Application Features

### User Registration & Authentication
- Secure user registration with password hashing
- Login/logout functionality
- Session management

### Shape Guessing Experiment
- **20 trials per experiment**
- **3 shapes**: Circle, Triangle, Square (black/white SVG images)
- **Real-time progress**: Shows current trial and correct count
- **Random sequence generation**: Each user gets unique 20-shape sequence
- **Immediate feedback**: Results shown after completion

### Results Display
- **Trial-by-trial breakdown**
- **Color coding**: Green for correct, red for incorrect
- **Visual shape indicators** with mini images
- **Performance statistics**: Accuracy percentage and timing

### Statistical Analysis
- **CSV Export**: Raw data download for all users
- **R-generated Histograms**: Distribution visualization
- **Statistical Testing**: Chi-square test for randomness
- **Probability Analysis**: P-value calculation vs random chance

## 🗄️ Database Structure

### Tables Created:
- **users**: User accounts (id, username, email, password_hash, auth_key, timestamps)
- **shapes**: Available shapes (id, name, image_path)
- **experiments**: User experiments (id, user_id, correct_sequence, user_sequence, correct_count, current_trial, is_completed, timestamps)

### Demo Data:
- 3 shapes pre-populated
- 3 demo users with completed experiments
- Sample data for testing statistics features

## 🛠️ Technical Implementation

### Backend (Yii2 Framework)
- **Models**: User, Experiment, Shape with proper relationships
- **Controllers**: Auth, Experiment, Statistics with access control
- **Database**: PostgreSQL with proper foreign keys and constraints

### Frontend (Bootstrap 5)
- **Responsive design** for mobile and desktop
- **Interactive shape buttons** with hover effects
- **Progress indicators** and real-time feedback
- **Color-coded results** display

### Statistical Analysis (R Integration)
- **Histogram generation** with expected vs observed distributions
- **Binomial distribution** comparison (p=1/3 for random guessing)
- **Chi-square testing** for statistical significance
- **Automated R script execution** from PHP

## 📁 File Structure

```
shape-guessing-app/
├── controllers/
│   ├── AuthController.php       # User registration/login
│   ├── ExperimentController.php # Shape guessing game
│   └── StatisticsController.php # Data analysis
├── models/
│   ├── User.php                 # User authentication model
│   ├── Experiment.php           # Experiment data model
│   └── Shape.php               # Shape definitions
├── views/
│   ├── auth/                   # Registration/login forms
│   ├── experiment/             # Game interface & results
│   └── statistics/             # Data visualization
├── web/
│   ├── images/                 # Shape SVG files
│   └── css/site.css           # Custom styling
├── migrations/                 # Database migrations
└── config/                    # Application configuration
```

## 🎮 User Flow

1. **Registration**: User creates account → Random 20-shape sequence generated
2. **Experiment**: User completes 20 trials guessing shapes
3. **Results**: Detailed breakdown with correct/incorrect indicators
4. **Statistics**: Aggregate analysis across all users

## 📈 Statistical Features

- **Expected Performance**: 6.67 correct (20 × 1/3) for random guessing
- **Histogram**: Shows distribution of correct guesses across users
- **P-value**: Probability of observing results by random chance
- **CSV Export**: Raw data for external analysis

## 🔧 Configuration

- **Database**: PostgreSQL (shape_guessing_db)
- **User**: shape_user / shape_password
- **Server**: PHP built-in server on port 8080
- **Dependencies**: PHP 8.4, PostgreSQL 17, R 4.4, Composer

## ✅ Application Status

- ✅ Database configured and populated
- ✅ All models and controllers implemented
- ✅ Views created with responsive design
- ✅ Authentication system working
- ✅ Demo data available for testing
- ✅ R integration for statistical analysis
- ✅ CSV export functionality
- ✅ Ready for production use

## 🚦 Next Steps

The application is fully functional and ready for users to:
1. Register and participate in experiments
2. View their detailed results
3. Analyze aggregate statistics
4. Export data for further research

**Note**: To start the server, run `./start_server.sh` from the application directory.