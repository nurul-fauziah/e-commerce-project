# 🛒 SmartTech E-Commerce

A modern e-commerce platform built with Laravel for selling electronic products.  
This project was developed as part of an academic E-Commerce course, with a focus on implementing real-world features such as online payments, transaction management, and admin dashboard.

---

## 📸 Preview

- Homepage (landing page)
  <img width="1236" height="954" alt="image" src="https://github.com/user-attachments/assets/8f16d098-fd2d-45d3-b190-889b9975a97e" />

- Product detail page
  <img width="943" height="866" alt="image" src="https://github.com/user-attachments/assets/51097576-55d0-4a19-aeda-368331ea2e4e" />

- Cart & Checkout page
  <img width="1392" height="921" alt="image" src="https://github.com/user-attachments/assets/4768f7d2-5444-4ef2-86ff-c0855fdb8fb4" />

- Payment (Midtrans)
  <img width="1416" height="949" alt="image" src="https://github.com/user-attachments/assets/01e332a5-addf-451d-9248-c4251ce7ae2c" />

- Admin dashboard
  <img width="1920" height="840" alt="image" src="https://github.com/user-attachments/assets/ed3bbaf8-8e90-434f-b472-515f61f7608c" />


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
