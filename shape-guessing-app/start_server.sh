#!/bin/bash

# Start PostgreSQL if not running
sudo service postgresql start

# Start PHP built-in server
cd /workspace/shape-guessing-app/web
php -S 0.0.0.0:8080