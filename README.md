# 🛒 SmartTech E-Commerce

A modern e-commerce platform built with Laravel for selling electronic products.  
This project was developed as part of an academic E-Commerce course, with a focus on implementing real-world features such as online payments, transaction management, and admin dashboard.

---

## 📸 Preview

> ⚠️ Add screenshots here to make your portfolio stand out

Recommended screenshots:
- Homepage (landing page)
- Product detail page
- Cart & Checkout page
- Payment (Midtrans)
- Admin dashboard

![Homepage](docs/assets/homepage.png)
![Product](docs/assets/product.png)
![Checkout](docs/assets/checkout.png)
![Dashboard](docs/assets/dashboard.png)

---

## ✨ Features

### 🧑 Customer
- User registration & authentication
- Browse products & categories
- Shopping cart system
- Checkout & online payment integration
- View order history & invoices

### 🧑‍💼 Admin
- Admin dashboard (Filament)
- Product & category management (CRUD)
- Order management & status updates

---

## 💳 Payment Integration

Integrated with Midtrans Payment Gateway:

- Snap payment integration
- Payment status handling (pending, success, failed)
- Callback / webhook handling
- Signature key verification
- Automatic transaction status synchronization

---

## 🛠️ Tech Stack

- Backend: Laravel  
- Language: PHP  
- Database: MySQL  
- Frontend: Tailwind CSS  
- Admin Panel: Filament  
- Payment Gateway: Midtrans  

---

## ⚙️ Core System Design

### 🔹 Snapshot Pricing
Product prices are stored at the time of checkout to maintain historical data consistency even if prices change in the future.

### 🔹 Order Lifecycle
- Pending
- Paid
- Processing
- Shipped
- Completed
- Canceled

### 🔹 Stock Management
- Stock is reduced at checkout (Pending)
- Stock is restored if order is canceled

---

## 🚀 Installation

### 1. Clone repository
```bash
git clone https://github.com/username/smarttech-ecommerce.git
cd smarttech-ecommerce
```

### 2. Install dependencies
```bash
composer install
npm install
```

### 3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure database
Edit .env file:
```bash
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run migration
```bash
php artisan migrate
```

### 6. Run application
```bash
php artisan serve
npm run dev
```

### 🎓 Background

This project was developed as part of an E-Commerce course, with the objective of building a fully functional online store that simulates real-world business processes, from product browsing to payment and order management.
