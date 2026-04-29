# 🍽️ MidwayCafe — Restaurant E-Commerce System

<p align="center">
  <b>Learning-Focused Full-Stack Laravel Project</b><br>
  <i>Understanding > Uniqueness</i>
</p>

---

## 📌 Project Philosophy

MidwayCafe is not just another restaurant system.

While the domain is common, the goal of this project was to:
> **Deeply understand Laravel internals and real-world backend workflows**  
instead of building something “unique but shallow”.

This project represents a shift from:
- ❌ Basic CRUD apps  
➡️ to  
- ✅ **Production-level thinking and architecture**

---

## 🧠 Laravel Learning Focus

This project was built with strong emphasis on understanding the **Laravel Lifecycle (Request → Response Flow)**:

- HTTP Request handling  
- Routing & Middleware processing  
- Controller execution  
- Service & business logic  
- Database interaction via Eloquent ORM  
- Response rendering using Blade  

👉 Instead of just using Laravel, the focus was on:
- *How Laravel works internally*  
- *Why each layer exists*  
- *How real applications scale*

---

## 💡 Problem Statement

Traditional restaurant systems rely on:
- Manual ordering  
- Poor tracking  
- Inefficient workflows  

👉 MidwayCafe solves this using a  
**centralized, automated digital platform**.

---

## ✨ Key Features

- ✅ End-to-End Ordering System  
- ✅ Admin Dashboard  
- ✅ Role-Based Authentication  
- ✅ Secure Payment Integration  
- ✅ Order & Delivery Tracking  

📄 [View Full Features](Project_Features.md)

---

## 🚀 Getting Started

👉 Setup instructions:  
📄 [RUN.md](RUN.md)

---

## 🛠️ Tech Stack

**Backend**
- Laravel 9
- PHP 8

**Database**
- PostgreSQL

**Frontend**
- Bootstrap  
- Tailwind CSS  
- JavaScript  

**Authentication**
- Laravel Jetstream  
- OTP Verification  

**Payments**
- bKash  
- SSLCommerz  

---

## 🗄️ Database Design & Understanding

This project uses a **relational PostgreSQL database**, with focus on:

### 🔹 Custom Application Database (2026)
Designed and created specifically for this project:
- users (role-based system)
- products (menu items)
- orders (order lifecycle)
- carts (temporary storage)
- reservations
- coupons
- ratings
- chefs & delivery staff

👉 Focus:
- Relationships (1:N, N:N)
- Indexing
- Data consistency

---

### 🔹 Laravel Default Database Structure (2014+ Framework Design)

Alongside custom tables, Laravel provides its own standard tables via migrations:

- migrations → version control for DB  
- failed_jobs → queue handling  
- password_resets → auth system  
- personal_access_tokens → API security  

👉 This helped in understanding:
- How Laravel manages database evolution  
- Migration-based schema design  
- Framework-level database architecture  

---

## 🏗️ System Architecture

Follows Laravel MVC pattern:

- **Models** → Database interaction  
- **Views (Blade)** → UI rendering  
- **Controllers** → Business logic  

Additional concepts:
- Middleware (role-based access)
- RESTful routing
- Session & state management
- Service-based integrations

---

## 🎯 Key Takeaways

- Deep understanding of Laravel lifecycle  
- Real-world backend architecture thinking  
- Strong database design skills  
- Integration of third-party services  
- Focus on scalability and maintainability  

---

## 👨‍💻 Author

**Shivshankar Mali**  
📧 shivashankrmali7@gmail.com
