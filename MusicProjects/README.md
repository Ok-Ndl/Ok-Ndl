# Music Producer Project Tracker

A simple PHP web application for tracking music production projects, recording progress, and analyzing whether a project is on pace to meet its target deadline.

## Features

- Create and manage music production projects
- Track:
  - project name
  - total planned tracks
  - tracks already recorded
  - hours spent
  - target hours
  - genre and notes
- Calculate:
  - completion percentage
  - average time per track
  - required recording speed
  - estimated time remaining
  - whether the project is on pace
- Save and load project data from text files
- Upload, download, and delete project data files

## Project Structure

- index.php - Main interface for creating and managing projects
- process.php - Handles form actions such as creating, deleting, loading, and saving projects
- display.php - Shows detailed analysis for a selected project
- functions.php - Contains validation, calculations, and data handling logic
- Data/ - Stores sample data and uploaded text files

## Requirements

- PHP 7.4 or newer
- A local web server such as:
  - XAMPP
  - WAMP
  - MAMP
  - PHP built-in server

## Setup

1. Place the project folder in your web server directory, such as htdocs or www.
2. Start your Apache server.
3. Open the app in your browser:
   - http://localhost/MusicProjects/index.php
   - or the appropriate path for your local setup

## Usage

1. Open the main page.
2. Fill in the project details.
3. Submit the form to create a project.
4. View the detailed analysis for the project.
5. Use the session tools to save, clear, or delete projects.
6. Upload a .txt file to load existing project data.

## Data Files

The application can read and write plain text project files. A sample file is included in the Data folder:

- Data/projects_sample.txt

## Notes

- File uploads are limited to .txt files.
- Project data is stored in the session by default until it is saved to a file.
- The app does not require a database.

## License

This project is provided for educational and personal use.
