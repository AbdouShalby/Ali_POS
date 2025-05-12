# Ali_POS - Point of Sale and Business Management System

## Overview

Ali_POS is a comprehensive Point of Sale (POS) system developed using the Laravel framework. This system aims to provide an integrated solution for managing sales, inventory, customers, suppliers, and financial transactions, including support for cryptocurrencies.

## Technologies Used

*   **Backend:** PHP 8.x, Laravel 10.x (based on latest practices)
*   **Database:** (Likely MySQL/MariaDB, PostgreSQL - configurable in Laravel)
*   **Frontend:** HTML, CSS (Bootstrap), JavaScript (Partial Vue.js or React presence is possible due to `package.json`)
*   **Asset Bundling:** Vite / Laravel Mix
*   **PHP Package Management:** Composer
*   **JavaScript Package Management:** NPM or Yarn

## Key Features

The system includes a wide range of features, including:

### 1. Product and Inventory Management
*   **Products:** Add and edit products with details like name, description, price, SKU. (**Note: Product/Device data structure has been re-structured recently.**)
*   **Categories:** Organize products into categories and subcategories.
*   **Brands:** Manage product brands.
*   **Warehouses:** Support for multi-warehouse inventory management.
*   **Purchases:** Record purchases from suppliers and update inventory.
*   **Purchase Items:** Details of products purchased in each transaction.
*   **External Purchases:** Record purchases from external sources.

### 2. Sales and POS Management
*   **POS Interface:** User-friendly interface for fast sales processing (as inferred from `public/js/pos/`).
*   **Sales:** Record sales transactions and their details.
*   **Sale Items:** Products sold in each transaction.
*   **Sale Details:** Additional information for each sale.
*   **Taxes and Discounts:** Apply taxes and discounts to sales.
*   **Multiple Payment Methods:** Support for various payment methods.

### 3. Financial Management
*   **Transactions:** Track all types of financial transactions.
*   **Cash Registers:** Manage cash available at POS terminals.
*   **Cash Transactions:** Record cash-based transactions.
*   **Debts:** Track and manage debts owed by customers or to suppliers.
*   **Payments:** Record payments related to debts or purchases.
*   **Expenses:** Record and manage operational expenses.
*   **Revenues:** Track revenues from various sources.

### 4. Customer and Supplier Management
*   **Customers:** Manage customer database and their transaction history.
*   **Suppliers:** Manage supplier database and their purchase history.

### 5. Cryptocurrency Integration
*   **Crypto Gateways:** Set up and manage cryptocurrency payment gateways.
*   **Crypto Transactions:** Track and record transactions made using cryptocurrencies.

### 6. User and Permission Management
*   **Users:** Manage user accounts for the system.
*   **Roles & Permissions:** Define user roles and the permissions granted to each role (likely using `spatie/laravel-permission`, as inferred from `config/permission.php`).
*   **User-Cash Register Link:** Ability to link a user to a specific cash register.

### 7. Additional Features
*   **Devices and Maintenances:** Track devices and their related maintenance operations.
*   **Mobiles & MobileDetails:** Manage information related to mobile phones (could be products or devices). (**Note: Mobile details are now separated from main product data.**)
*   **Notifications:** In-app notification system.
*   **Settings:** Configure various application settings.
*   **QR Code Generation:** (as inferred from `public/qrcodes/` directory). (**Note: QR Code generation is now specifically for devices.**)
*   **Data Export:** Ability to export data (sales, purchases, debts, crypto transactions) to formats like Excel (using a library like `maatwebsite/excel`).
*   **Helper Functions:** Custom functions to facilitate repetitive tasks.

## Recent Progress

We have recently focused on re-structuring and improving the **Product management module**. Key accomplishments include:

*   **Database Re-structure:** Separated core product data (`products` table) from device-specific details (`mobile_details` table).
*   **Eloquent Models Update:** Updated `Product` and `MobileDetail` models and their relationships.
*   **Controller Logic Adaptation:** Modified `ProductController` to handle the new data structure for CRUD operations.
*   **Enhanced QR Code Mechanism:** Implemented Observers and a Job to efficiently generate, update, and delete QR codes for devices.
*   **User Interface Updates:** Revised Product creation, edit, and show pages (`create.blade.php`, `edit.blade.php`, `show.blade.php`) to reflect data changes.
*   **UI Organization:** Extracted Modals to separate Partial Views.
*   **Duplicate Product Feature:** Added the functionality to duplicate existing products, including an AJAX search interface.
*   **Bug Fixing:** Resolved a critical 404 error issue with the product search route (`/products/search`) by correcting its placement within the route middleware group.
*   **Translation Review:** Reviewed Product module texts and updated translation files (`en/products.php`, `ar/products.php`) to ensure comprehensive coverage.

## Upcoming Features / Modules

Following the completion of the Product module re-structuring and initial bug fixing, the next steps will focus on developing and enhancing the following key areas:

*   **Integrated Purchase Module:** Full functionality for creating purchase invoices, managing stock, supplier selection, and payment handling (cash/credit).
*   **External Purchases Module:** System for recording non-product related expenses.
*   **Maintenance Module:** Comprehensive management of device maintenance requests, including tracking and POS integration.
*   **Product Sales/Purchase History:** Displaying related sales and purchase invoices on the Product details page.
*   **Treasury Management:** Manual cash deposits/withdrawals and a detailed transaction log for the treasury balance.
*   **External Debts Section:** Managing debts not linked to sales/purchase invoices.
*   **Notifications System:** Full activation and integration of the notification system, including low stock alerts in the POS interface.
*   **POS UI Improvements:** Enhancements to the user interface of the Point of Sale system.
*   **Cryptocurrency Module:** Management of crypto gateways and transactions, including POS payment integration.

## Getting Started (General Instructions)

1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    cd Ali_POS
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    npm install # or yarn install
    ```

3.  **Set up the environment file:**
    *   Copy `.env.example` to `.env`:\
        ```bash
        cp .env.example .env
        ```
    *   Update database settings and other variables in the `.env` file.

4.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Run database migrations and seeders (if necessary):**
    ```bash
    php artisan migrate --seed
    ```

6.  **Link the storage directory (if not already linked):**
    ```bash
    php artisan storage:link
    ```

7.  **Compile assets (if using Mix or Vite):**
    ```bash
    npm run dev # or npm run build
    ```

8.  **Run the development server:**
    ```bash
    php artisan serve
    ```

You can then access the application at `http://localhost:8000` (or the specified port).

## Contributing

(Add contribution guidelines here if the project is open source or accepts contributions).

## License

(Specify the project's license here, e.g., MIT, GPL, etc.).

---

*Note: This README reflects the current state of the project development as discussed and implemented recently. It will be updated as further progress is made.*
