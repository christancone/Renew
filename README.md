# Pharmacy Inventory Management System

## Demo

Watch the demo video of the project [here](https://www.youtube.com).


## Description

The **Pharmacy Inventory Management System** is a web-based application designed to streamline the management of pharmaceutical inventories. The system is built to ensure smooth stock management by providing two user roles: **Admin** and **Pharmacist**.

- **Admin**: The admin has full control over the inventory. They can add, update, and manage the stock of medicines and supplies. Additionally, the admin has the ability to update their personal information.
  
- **Pharmacist**: The pharmacist has a view-only role when it comes to inventory management. They can monitor the stock levels, view detailed statistics, and notify the admin when specific items are running low and need restocking.

## Features

### Admin
- Full control over inventory: add, edit, and remove items.
- View real-time inventory statistics.
- Manage personal information (update profile details).

### Pharmacist
- View inventory statistics and stock levels.
- Notify admin of low-stock items to prompt restocking.

## Tech Stack

- **Frontend**:HTML/CSS/JS
- **Backend**: PHP
- **Database**: MySQL

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/christancone/Renew.git


2. Setup a sample database named "Renew":
   
   ```sql
   CREATE TABLE stock (
    id INT PRIMARY KEY AUTO_INCREMENT,
    prd_name VARCHAR(100) NOT NULL,
    prd_type VARCHAR(50),
    quantity INT NOT NULL,
    image VARCHAR(255),
    chemical_name VARCHAR(100),
    brand_name VARCHAR(100),
    description TEXT,
    expiry_date DATE,
    getmethod ENUM('OTC', 'Prescription Required') NOT NULL);
   
   CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
   
   CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    role ENUM('Admin', 'Pharmacist') NOT NULL,
    username VARCHAR(25) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    firstname VARCHAR(50),
    lastname VARCHAR(50),
    email VARCHAR(100),
    phonenumber VARCHAR(15));
   
   INSERT INTO stock (prd_name, prd_type, quantity, image, chemical_name, brand_name, description, expiry_date, getmethod) VALUES
   ('Aspirin', 'Tablet', 100, 'tablet.jpg', 'Acetylsalicylic Acid', 'Bayer', 'Pain reliever and anti-inflammatory', '2025-12-31', 'OTC'),
   ('Amoxicillin', 'Capsule', 50, 'tablet.jpg', 'Amoxicillin', 'Amoxil', 'Antibiotic for bacterial infections', '2024-08-15', 'Prescription Required'),
   ('Ibuprofen', 'Tablet', 200, 'tablet.jpg', 'Ibuprofen', 'Advil', 'Pain reliever and fever reducer', '2026-02-20', 'OTC'),
   ('Cetirizine', 'Syrup', 80, 'tablet.jpg', 'Cetirizine Hydrochloride', 'Zyrtec', 'Antihistamine for allergy relief', '2024-10-05', 'OTC'),
   ('Metformin', 'Tablet', 150, 'tablet.jpg', 'Metformin Hydrochloride', 'Glucophage', 'Used to control high blood sugar', '2025-05-25', 'Prescription Required');

    INSERT INTO notifications (message) VALUES
    ('Stock for Aspirin has been updated.'),
    ('New user account created.'),
    ('Amoxicillin is running low on stock.'),
    ('System maintenance scheduled for next Friday.'),
    ('Password reset request for user john_doe.');


    INSERT INTO users (role, username, password, firstname, lastname, email, phonenumber) VALUES
    ('Admin', 'admin_user', '$2y$10$o81lfGhfg/EU1ynseTCFrepPclHYYTXdNVAxSsBsiqNUiid40WyYW', 'Alice', 'Smith', 'alice.smith@example.com', '123-456-7890'),
    ('Pharmacist', 'john_doe', '$2y$10$o81lfGhfg/EU1ynseTCFrepPclHYYTXdNVAxSsBsiqNUiid40WyYW', 'John', 'Doe', 'john.doe@example.com', '234-567-8901'),
    ('Pharmacist', 'jane_doe', '$2y$10$o81lfGhfg/EU1ynseTCFrepPclHYYTXdNVAxSsBsiqNUiid40WyYW', 'Jane', 'Doe', 'jane.doe@example.com', '345-678-9012'),
    ('Admin', 'super_admin', '$2y$10$o81lfGhfg/EU1ynseTCFrepPclHYYTXdNVAxSsBsiqNUiid40WyYW', 'Mark', 'Johnson', 'mark.johnson@example.com', '456-789-0123'),
    ('Pharmacist', 'peter_parker', '$2y$10$o81lfGhfg/EU1ynseTCFrepPclHYYTXdNVAxSsBsiqNUiid40WyYW', 'Peter', 'Parker', 'peter.parker@example.com', '567-890-1234');

3. Clone the repository and start working.

### Contributions
- Contributions are welcome! Feel free to submit a pull request or open an issue for feedback and improvements.



