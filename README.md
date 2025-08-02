 ⚡ Sparkonics - Electrical Club of IIT Patna

![Sparkonics Banner](https://github.com/user-attachments/assets/797b8b2a-da41-4e0d-90b8-f1495340298e)

> “Illuminating the future, one project at a time.”

## 🔧 Project Overview

Sparkonics is the official Electrical Engineering club of **IIT Patna**. This repository contains the codebase for our **club activity website**, which powers our events, backend scheduling, admin dashboard, and community features.

This repo is structured in two main branches:
- **`main`** – Server-compatible version using Apache and `.htaccess`
- **`backend`** – Original version using OpenSwoole with async scheduling and WebSocket support

---

## 🌟 About Sparkonics

We are a community of passionate electrical engineering students driven by a shared vision—to **explore**, **build**, and **innovate**.

Our activities include:
- Technical workshops on VLSI, IoT, Robotics, and Power Systems
- Competitions and real-world problem-solving
- Hands-on projects on hardware + software integration

---

## 🖥️ Backend Architecture

The backend is built in **PHP 8.2** using our **custom lightweight MVC** framework. We adopted PHP due to high compatibility and performance with our server infrastructure.

### 🔁 API Handling
- Apache `.htaccess` rewrites all `/api/*` requests to `api.php`
- Adopts RESTful API structure for frontend integration
- Legacy branch uses OpenSwoole for async handling and real-time features

### 🗂️ Database
- Each page/module uses its own `SQLite` database
- Benefits: blazing-fast reads, zero setup, low file locking issues
- Structure supports future scaling and modularization

### 🔐 Security
- Custom session handling with encrypted session IDs
- SQL injection protection and data sanitization
- Role-based access system (admin / cord / subcord)

### 📅 Scheduler
- Uses `PHPMailer` + a custom loop for timed emails & reminders
- Previously used OpenSwoole timers (still available in backend branch)

### 💬 Messaging System
- Internal messaging system built using WebSockets (OpenSwoole)
- Due to hardware constraints, this is not live on the `main` branch

---

## 🎨 Frontend Stack

### 🧱 Technologies
- **HTML5** (semantic, accessible)
- **CSS3** (flexbox, grid, custom properties)
- **JavaScript (ES6+)** for interactivity and responsiveness
- Currently transitioning from **React** to **Vanilla JS** for performance

### 📈 Performance Optimization
- Lazy loading, code splitting, async scripts
- Progressive enhancement for low-resource devices
- Responsive design across mobile, tablet, desktop

---

## ⚙️ Features

- 🧑‍💻 Admin panel for backend control
- 📆 Scheduler + reminder system
- 💌 Automated mail dispatch (via PHPMailer)
- 🔒 Secure session management
- 💬 Real-time communication (on backend branch)
- 📊 Modular DB design for each feature/page

---

For more details check the backend branch, this main branch has been modified to meet the server requirements on our servers.
Logic remains same, but instead of openswoole, we use apache .htaccess ,to rewrite the api requests to a file called api.php.
And also scheduler has also been changed from openswoole Timer to a simple while loop.



