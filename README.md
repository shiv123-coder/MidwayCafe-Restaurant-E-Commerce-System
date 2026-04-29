<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MidwayCafe — Restaurant E-Commerce System</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
    background: #0f172a;
    color: #e2e8f0;
    line-height: 1.6;
}

.container {
    max-width: 1100px;
    margin: auto;
    padding: 40px 20px;
}

h1, h2, h3 {
    color: #38bdf8;
}

.card {
    background: rgba(255,255,255,0.05);
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 20px;
    backdrop-filter: blur(10px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.tag {
    display: inline-block;
    background: #1e293b;
    padding: 6px 10px;
    border-radius: 8px;
    margin: 5px;
    font-size: 14px;
}

.highlight {
    color: #22c55e;
    font-weight: bold;
}

.footer {
    text-align: center;
    margin-top: 40px;
    opacity: 0.7;
}
</style>
</head>

<body>

<div class="container">

<h1>🍽️ MidwayCafe — Restaurant E-Commerce System</h1>

<div class="card">
<p>
MidwayCafe is a <span class="highlight">full-stack restaurant management and e-commerce platform</span> 
developed using <b>Laravel</b> and <b>PostgreSQL</b>. While the concept of restaurant systems is common, 
this project was specifically built with a strong focus on <span class="highlight">deep understanding of Laravel architecture</span>, 
real-world backend workflows, and scalable system design.
</p>

<p>
The project simulates a production-level system where customers can browse menus, place orders, 
and track deliveries, while administrators manage operations through a powerful backend dashboard.
</p>
</div>

<h2>📋 Problem Statement</h2>
<div class="card">
<p>
Traditional restaurant workflows rely heavily on manual processes such as phone-based ordering 
and offline reservations. This leads to inefficiencies like delayed service, order mismanagement, 
and poor customer experience.
</p>

<p>
The goal was to design a <span class="highlight">centralized digital solution</span> that automates restaurant operations 
while enhancing customer convenience through real-time interaction.
</p>
</div>

<h2>💡 Solution & Learning Focus</h2>
<div class="card">
<p>
Although the project title follows a common domain (restaurant system), the primary objective was to:
</p>

<ul>
<li>Master <b>Laravel MVC architecture</b> in depth</li>
<li>Understand <b>real-world database relationships</b></li>
<li>Implement <b>authentication & role-based access control</b></li>
<li>Integrate <b>payment gateways</b> and external services</li>
<li>Develop a <b>scalable backend system</b></li>
</ul>

<p>
This project represents a transition from basic CRUD applications to a 
<span class="highlight">production-grade full-stack system</span>.
</p>
</div>

<h2>✨ Key Features Summary</h2>
<div class="card">
<p>
MidwayCafe provides a comprehensive suite of features for both customers and administrators:
</p>
<ul>
    <li><b>End-to-End Ordering:</b> From OTP signup to real-time order tracking.</li>
    <li><b>Powerful Administration:</b> Full control over menu, staff, and analytics.</li>
    <li><b>Secure Payments:</b> Integration with major gateways and COD support.</li>
    <li><b>Modern UI:</b> Responsive design with Dark/Light mode support.</li>
</ul>
<p>👉 For a full list of features, refer to <b><a href="Project_Features.md">Project_Features.md</a></b></p>
</div>

<div class="card" style="border: 1px solid #38bdf8;">
    <h3 style="margin-top: 0;">🚀 Getting Started</h3>
    <p>For detailed setup and run instructions, please refer to the <b><a href="RUN.md" style="color: #22c55e;">RUN.md</a></b> guide.</p>
</div>

<h2>🛠️ Tech Stack</h2>

<div class="card">
<div class="grid">
<div>
<h3>Backend</h3>
<span class="tag">Laravel 9</span>
<span class="tag">PHP 8.x</span>
</div>

<div>
<h3>Database</h3>
<span class="tag">PostgreSQL</span>
</div>

<div>
<h3>Frontend</h3>
<span class="tag">Bootstrap 5</span>
<span class="tag">Tailwind CSS</span>
<span class="tag">JavaScript</span>
</div>

<div>
<h3>Authentication</h3>
<span class="tag">Laravel Jetstream</span>
<span class="tag">OTP Email</span>
</div>

<div>
<h3>Payments</h3>
<span class="tag">bKash</span>
<span class="tag">SSLCommerz</span>
</div>

<div>
<h3>Tools</h3>
<span class="tag">Composer</span>
<span class="tag">npm</span>
<span class="tag">Laravel Mix</span>
</div>
</div>
</div>

<h2>🗄️ Database Design</h2>

<div class="card">
<p>
The system uses a relational database structure designed in PostgreSQL with proper normalization and relationships.
</p>

<ul>
<li><b>users</b> — role-based system (Admin, Customer, Delivery)</li>
<li><b>products</b> — menu items</li>
<li><b>orders</b> — order lifecycle tracking</li>
<li><b>carts</b> — temporary cart data</li>
<li><b>reservations</b> — table bookings</li>
<li><b>coupons</b> — discount logic</li>
<li><b>charges</b> — delivery pricing</li>
<li><b>chefs</b> — restaurant staff</li>
<li><b>ratings</b> — feedback system</li>
<li><b>otps</b> — verification mechanism</li>
</ul>

<p>
Special attention was given to <span class="highlight">data relationships, indexing, and scalability</span>.
</p>
</div>

<h2>🚀 System Architecture Insight</h2>

<div class="card">
<p>
The project strictly follows Laravel’s MVC pattern:
</p>

<ul>
<li><b>Models</b> → Database interaction</li>
<li><b>Views</b> → Blade templating engine</li>
<li><b>Controllers</b> → Business logic</li>
</ul>

<p>
Additional architectural concepts implemented:
</p>

<ul>
<li>Middleware for role-based access</li>
<li>Service-based payment integration</li>
<li>RESTful routing</li>
<li>Session & state management</li>
</ul>
</div>

<h2>🎯 Key Takeaways</h2>

<div class="card">
<ul>
<li>Strong understanding of Laravel internals</li>
<li>Real-world backend system design</li>
<li>Hands-on experience with PostgreSQL</li>
<li>Integration of third-party services</li>
<li>Building scalable and maintainable applications</li>
</ul>
</div>

<div class="footer">
<p>👨‍💻 Developed by <b>Shivshankar Mali</b></p>
<p>📧 shivashankrmali7@gmail.com</p>
</div>

</div>

</body>
</html>
