<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Zoo Planet</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0a1f0a, #1a3a1a, #0a1f0a);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Jungle Background Overlay */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(ellipse at 20% 80%, rgba(45,106,79,0.2) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(27,67,50,0.2) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(64,145,108,0.15) 0%, transparent 50%);
            z-index: 0;
            pointer-events: none;
        }
        
        /* Floating Leaves */
        .leaves-container {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            top: 0;
            left: 0;
        }
        
        .leaf {
            position: absolute;
            font-size: 25px;
            animation: floatLeaf linear infinite;
            opacity: 0;
        }
        
        @keyframes floatLeaf {
            0% { transform: translateY(105vh) rotate(0deg) scale(0.5); opacity: 0; }
            5% { opacity: 0.25; }
            90% { opacity: 0.25; }
            100% { transform: translateY(-10vh) rotate(720deg) scale(1.2); opacity: 0; }
        }
        
        .leaf:nth-child(1) { left: 3%; animation-duration: 16s; animation-delay: 0s; }
        .leaf:nth-child(2) { left: 10%; animation-duration: 18s; animation-delay: 3s; font-size: 30px; }
        .leaf:nth-child(3) { left: 18%; animation-duration: 14s; animation-delay: 5s; }
        .leaf:nth-child(4) { left: 25%; animation-duration: 20s; animation-delay: 2s; font-size: 28px; }
        .leaf:nth-child(5) { left: 33%; animation-duration: 15s; animation-delay: 4s; }
        .leaf:nth-child(6) { left: 40%; animation-duration: 17s; animation-delay: 1s; font-size: 22px; }
        .leaf:nth-child(7) { left: 48%; animation-duration: 13s; animation-delay: 6s; }
        .leaf:nth-child(8) { left: 55%; animation-duration: 19s; animation-delay: 3s; font-size: 32px; }
        .leaf:nth-child(9) { left: 62%; animation-duration: 11s; animation-delay: 5s; }
        .leaf:nth-child(10) { left: 70%; animation-duration: 16s; animation-delay: 2s; font-size: 26px; }
        .leaf:nth-child(11) { left: 78%; animation-duration: 14s; animation-delay: 4s; }
        .leaf:nth-child(12) { left: 85%; animation-duration: 18s; animation-delay: 1s; font-size: 29px; }
        .leaf:nth-child(13) { left: 92%; animation-duration: 12s; animation-delay: 3s; }
        .leaf:nth-child(14) { left: 7%; animation-duration: 21s; animation-delay: 5s; font-size: 24px; }
        .leaf:nth-child(15) { left: 96%; animation-duration: 15s; animation-delay: 2s; }
        
        /* Fireflies */
        .firefly {
            position: absolute;
            width: 3px;
            height: 3px;
            background: #ffeb3b;
            border-radius: 50%;
            box-shadow: 0 0 8px #ffeb3b, 0 0 15px #ffeb3b, 0 0 30px #ffeb3b;
            animation: fireflyFloat linear infinite;
            opacity: 0;
        }
        
        @keyframes fireflyFloat {
            0% { transform: translate(0, 0) scale(0); opacity: 0; }
            10% { opacity: 0.7; transform: translate(15px, -25px) scale(1); }
            30% { opacity: 0.3; transform: translate(-8px, -50px) scale(0.5); }
            50% { opacity: 0.8; transform: translate(25px, -75px) scale(1.1); }
            70% { opacity: 0.2; transform: translate(-15px, -100px) scale(0.4); }
            90% { opacity: 0.6; transform: translate(8px, -125px) scale(0.7); }
            100% { opacity: 0; transform: translate(0, -150px) scale(0); }
        }
        
        .firefly:nth-child(16) { left: 8%; top: 75%; animation-duration: 9s; animation-delay: 0s; }
        .firefly:nth-child(17) { left: 25%; top: 65%; animation-duration: 11s; animation-delay: 3s; }
        .firefly:nth-child(18) { left: 42%; top: 70%; animation-duration: 8s; animation-delay: 5s; }
        .firefly:nth-child(19) { left: 58%; top: 80%; animation-duration: 10s; animation-delay: 2s; }
        .firefly:nth-child(20) { left: 75%; top: 60%; animation-duration: 12s; animation-delay: 4s; }
        .firefly:nth-child(21) { left: 90%; top: 72%; animation-duration: 9s; animation-delay: 1s; }
        .firefly:nth-child(22) { left: 15%; top: 85%; animation-duration: 11s; animation-delay: 6s; }
        .firefly:nth-child(23) { left: 50%; top: 55%; animation-duration: 8s; animation-delay: 3s; }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #1b4332, #2d6a4f, #40916c);
            color: white;
            padding: 22px 30px;
            text-align: center;
            box-shadow: 0 5px 25px rgba(0,0,0,0.4);
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        .header h1 { font-size: 28px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); }
        .header .welcome { 
            font-size: 14px; 
            opacity: 0.95; 
            background: rgba(255,255,255,0.15); 
            padding: 6px 15px; 
            border-radius: 20px;
        }
        .header .logout-btn {
            position: absolute;
            right: 25px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.15);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            transition: all 0.3s;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .header .logout-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-50%) scale(1.05);
        }
        
        /* Section Title */
        .section-title {
            text-align: center;
            margin: 30px 0 15px;
            color: #a5d6a7;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            position: relative;
            z-index: 5;
        }
        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 2px;
            margin: 8px auto;
            border-radius: 2px;
        }
        .section-title.management::after { background: #4caf50; }
        .section-title.ai::after { background: #ce93d8; }
        .section-title .icon { font-size: 22px; }
        
        /* Container */
        .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 10px 30px 25px;
            max-width: 1350px;
            margin: 0 auto;
            position: relative;
            z-index: 5;
        }
        
        /* Card */
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            width: 215px;
            padding: 22px 14px;
            text-align: center;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        }
        
        /* Management Cards */
        .card.management {
            border-top: 4px solid #2e7d32;
        }
        .card.management::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(46,125,50,0.05) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .card.management:hover::before { opacity: 1; }
        .card.management:hover {
            box-shadow: 0 15px 40px rgba(46,125,50,0.3);
        }
        
        /* AI Cards */
        .card.ai {
            border-top: 4px solid #9c27b0;
            animation: aiGlow 3s ease-in-out infinite;
        }
        @keyframes aiGlow {
            0%, 100% { box-shadow: 0 8px 30px rgba(156,39,176,0.2); }
            50% { box-shadow: 0 8px 35px rgba(156,39,176,0.4); }
        }
        .card.ai::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(156,39,176,0.05) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .card.ai:hover::before { opacity: 1; }
        .card.ai:hover {
            box-shadow: 0 15px 40px rgba(156,39,176,0.4);
        }
        
        .card .card-icon { 
            font-size: 48px; 
            margin-bottom: 8px; 
            display: block;
            position: relative;
            z-index: 1;
        }
        .card img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 10px;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }
        .card h3 {
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: 600;
            position: relative;
            z-index: 1;
        }
        .card.management h3 { color: #2e7d32; }
        .card.ai h3 { color: #6a1b9a; }
        
        .card .desc {
            font-size: 10px;
            color: #999;
            margin-bottom: 12px;
            line-height: 1.4;
            position: relative;
            z-index: 1;
        }
        
        .card a {
            display: block;
            text-decoration: none;
            color: white;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: bold;
            margin: 4px 0;
            transition: all 0.3s;
            position: relative;
            z-index: 1;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .card.management a {
            background: linear-gradient(135deg, #2d6a4f, #40916c);
        }
        .card.management a:hover {
            background: linear-gradient(135deg, #1b4332, #2d6a4f);
            transform: scale(1.04);
            box-shadow: 0 5px 15px rgba(45,106,79,0.4);
        }
        .card.ai a {
            background: linear-gradient(135deg, #6a1b9a, #9c27b0);
        }
        .card.ai a:hover {
            background: linear-gradient(135deg, #4a148c, #6a1b9a);
            transform: scale(1.04);
            box-shadow: 0 5px 15px rgba(156,39,176,0.4);
        }
        
        /* Footer */
        .footer {
            text-align: center;
            color: rgba(255,255,255,0.5);
            padding: 20px;
            font-size: 12px;
            position: relative;
            z-index: 5;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container { gap: 12px; padding: 10px; }
            .card { width: 150px; padding: 15px 8px; }
            .card .card-icon { font-size: 35px; }
            .card h3 { font-size: 11px; }
            .card a { font-size: 10px; padding: 7px 10px; }
            .header h1 { font-size: 22px; }
            .header .logout-btn { position: static; transform: none; margin-top: 5px; }
        }
        
        @media (max-width: 480px) {
            .card { width: 130px; padding: 12px 5px; }
            .card .card-icon { font-size: 28px; }
            .card h3 { font-size: 10px; }
            .card a { font-size: 9px; padding: 6px 8px; }
        }
    </style>
</head>
<body>

<!-- Leaves Animation -->
<div class="leaves-container">
    <div class="leaf">🌿</div>
    <div class="leaf">🍃</div>
    <div class="leaf">🌱</div>
    <div class="leaf">🍀</div>
    <div class="leaf">🌿</div>
    <div class="leaf">🍃</div>
    <div class="leaf">🌱</div>
    <div class="leaf">🍀</div>
    <div class="leaf">🌿</div>
    <div class="leaf">🍃</div>
    <div class="leaf">🌱</div>
    <div class="leaf">🍀</div>
    <div class="leaf">🌿</div>
    <div class="leaf">🍃</div>
    <div class="leaf">🍀</div>
    
    <!-- Fireflies -->
    <div class="firefly"></div>
    <div class="firefly"></div>
    <div class="firefly"></div>
    <div class="firefly"></div>
    <div class="firefly"></div>
    <div class="firefly"></div>
    <div class="firefly"></div>
    <div class="firefly"></div>
</div>

<!-- Header -->
<div class="header">
    <h1>🦁 Zoo Planet Admin Dashboard</h1>
    <span class="welcome">👋 Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?>!</span>
    <a href="logout.php" class="logout-btn">🚪 Logout</a>
</div>

<!-- Management Section -->
<div class="section-title management">
    <span class="icon">📋</span> Zoo Management
</div>
<div class="container">

    <!-- Animals -->
    <div class="card management">
        <div class="card-icon">🦁</div>
        <h3>Animal Management</h3>
        <p class="desc">Add & manage zoo animals</p>
        <a href="save_animal.php">➕ Add Animal</a>
        <a href="view_animal.php">👁️ View Animals</a>
    </div>

    <!-- Tickets -->
    <div class="card management">
        <div class="card-icon">🎫</div>
        <h3>Ticket Management</h3>
        <p class="desc">Book & view all tickets</p>
        <a href="booking.php">🎟️ Book Ticket</a>
        <a href="view_tickets.php">📋 View Tickets</a>
    </div>

    <!-- Visitors -->
    <div class="card management">
        <div class="card-icon">👥</div>
        <h3>Visitor Tracking</h3>
        <p class="desc">Register & track visitors</p>
        <a href="visitor.php">➕ Add Visitor</a>
        <a href="view_visitors.php">👁️ View Visitors</a>
    </div>

    <!-- Inquiries -->
    <div class="card management">
        <div class="card-icon">📧</div>
        <h3>Inquiry Management</h3>
        <p class="desc">Handle visitor inquiries</p>
        <a href="inquiry.php">📝 New Inquiry</a>
        <a href="view_inquiries.php">📋 View Inquiries</a>
    </div>

    <!-- Staff -->
    <div class="card management">
        <div class="card-icon">👷</div>
        <h3>Staff Management</h3>
        <p class="desc">Add & manage zoo staff</p>
        <a href="save_staff.php">➕ Add Staff</a>
        <a href="view_staff.php">👁️ View Staff</a>
    </div>
</div>

<!-- AI Features Section -->
<div class="section-title ai">
    <span class="icon">🤖</span> AI-Powered Features
</div>
<div class="container">

    <!-- AI Chatbot -->
    <div class="card ai">
        <div class="card-icon">🤖</div>
        <h3>AI Chatbot</h3>
        <p class="desc">Ask about animals, tickets & timings</p>
        <a href="ai_chatbot.php">💬 Chat with AI</a>
    </div>

    <!-- AI Animal Identifier -->
    <div class="card ai">
        <div class="card-icon">📸</div>
        <h3>Animal Identifier</h3>
        <p class="desc">Upload photo, AI identifies animal</p>
        <a href="ai_identifier_ml.php">🔍 Identify Now</a>
    </div>

    <!-- AI Facts Generator -->
    <div class="card ai">
        <div class="card-icon">🔮</div>
        <h3>Facts Generator</h3>
        <p class="desc">AI generates unique animal facts</p>
        <a href="ai_facts.php">✨ Generate Facts</a>
    </div>

    <!-- Voice Search -->
    <div class="card ai">
        <div class="card-icon">🎤</div>
        <h3>Voice Search</h3>
        <p class="desc">Speak to find animals instantly</p>
        <a href="voice_search.php">🎙️ Voice Search</a>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>🦁 Zoo Planet Management System © 2026 | AI-Enhanced</p>
    <p style="font-size:10px; margin-top:3px; opacity:0.7;">Built for Web Technology Project</p>
</div>

</body>
</html>