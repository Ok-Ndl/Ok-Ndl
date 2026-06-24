# Gymnastics Training and Membership Management System

## Project Overview
This project is a complete academic full-stack application for managing gymnastics memberships, training records, profile pages, reporting, and an interactive React demo module.

## Features
- Admin registration, edit, view, and delete workflows
- Search, filter, and sort dashboard tools
- Interactive gymnast dashboard with live member-card selection
- Printable profile summary and enrollment slip pages
- Prepared statements, validation, and logging
- Interactive React functional component demonstration with a simulated Node API

## Technology Stack
- PHP 8+
- MySQL
- HTML/CSS/JavaScript
- React + Vite
- Node.js (simulated API)

## Folder Structure
- assets/ for styling and scripts
- database/ for schema and sample data
- includes/ for shared PHP helpers
- admin/ for administration pages
- gymnast/ for profile and report pages
- react-app/ for the React demo
- server/ for Node simulation

## Database Setup
1. Start MySQL in XAMPP/AMPPS.
2. Create a database named `gymnastics_system`.
3. Import `database/schema.sql` and `database/seed.sql`.
4. Copy `.env.example` to `.env` and update credentials if needed.
5. Open the landing page at `http://localhost/Gymnastics_System/` to access the three main portals: Admin Dashboard, Gymnast Dashboard, and React Demo.

## How to Run Using AMPPS/XAMPP
1. Place the project in your web server root folder.
2. Start Apache and MySQL.
3. Open `http://localhost/Gymnastics_System/`.

## How to Import SQL
Use phpMyAdmin or the MySQL CLI:
- source database/schema.sql;
- source database/seed.sql;

## Portal Highlights
- Admin Dashboard: filter/search gymnast records and manage updates from the main control panel.
- Gymnast Dashboard: browse member cards, live-filter by program/status, and open a selected profile instantly.
- React Demo: add, inspect, and remove simulated gymnasts from the interactive React interface.

## Gymnast Features
- view profile pages
- generate printable profile reports
- view enrollment confirmation slips

## Security Features
- prepared statements
- input sanitization and output escaping
- validation and error handling
- delete logging

## React Module
Run `cd react-app && npm install && npm start`.
The demo is wired to the Node simulation at `http://localhost:3001/gymnasts`.

## Node.js Simulation
Run `cd server && node server.js`.

## Report Generation
Use the report pages in `gymnast/` and the printable buttons for print/PDF-ready output.

## Future Improvements
- authentication and role-based access
- email notifications
- advanced analytics

## Troubleshooting
- If the database connection fails, confirm your XAMPP/AMPPS credentials in `.env`.
- If React fails to start, install dependencies with `npm install`.
