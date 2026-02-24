🧩 Task 1: Multi Login System 
Architecture Overview

ecommerce-app → OAuth2 Authorization Server

foodpanda-app → OAuth Client

OAuth2 Authorization Code Grant Flow

How It Works

User logs into Ecommerce

OAuth authorization code generated

Foodpanda exchanges code for token

User auto logged in

Central logout implemented

Setup Instructions
Step 1: Clone Repo
git clone <your_repo_link>
Setup ecommerce-app
cd ecommerce-app
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan passport:install
php artisan serve --port=8000
Setup foodpanda-app
cd foodpanda-app
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve --port=8001
Demo Credentials

Email: admin@demo.com

Password: password

Task 2: Inventory Management System 
Business Logic

Purchase Price: 100
Sell Price: 200
Opening Stock: 50

Sale:

Sold: 10 units

Discount: 50

VAT: 5%

Payment: 1000

Remaining: Due

Accounting Journal Entry
On Purchase (Opening Stock)

Inventory A/C Dr
To Capital A/C

On Sale

Customer A/C Dr
To Sales A/C
To VAT Payable

On Payment

Cash A/C Dr
To Customer A/C

Financial Report

Date wise total sell

Date wise total expense

Date filter implemented

Proper frontend for testing

🌍 Deployment

Ecommerce Live: https://yourlink.com

Foodpanda Live: https://yourlink.com

Inventory Live: https://yourlink.com
