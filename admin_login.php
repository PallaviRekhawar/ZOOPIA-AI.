<?php
session_start();

// Check if already logged in
if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

// Process login when form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Connect to database
    $conn = mysqli_connect("localhost", "root", "", "zoo_planet");
    
    if ($conn) {
        // Check credentials from database
        $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) == 1) {
            $_SESSION['admin'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid Username or Password!";
        }
        mysqli_close($conn);
    } else {
        $error = "Database connection failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Zoo Planet</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0a1f0a, #1a3a1a, #0a1f0a);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        /* Jungle Background Overlay */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(ellipse at 20% 80%, rgba(45,106,79,0.3) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(27,67,50,0.3) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(64,145,108,0.2) 0%, transparent 50%);
            z-index: 0;
        }
        
        /* Floating Leaves */
        .leaves-container {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }
        
        .leaf {
            position: absolute;
            font-size: 30px;
            animation: floatLeaf linear infinite;
            opacity: 0;
        }
        
        @keyframes floatLeaf {
            0% {
                transform: translateY(105vh) rotate(0deg) scale(0.5);
                opacity: 0;
            }
            5% { opacity: 0.4; }
            90% { opacity: 0.4; }
            100% {
                transform: translateY(-10vh) rotate(720deg) scale(1.2);
                opacity: 0;
            }
        }
        
        .leaf:nth-child(1) { left: 5%; animation-duration: 14s; animation-delay: 0s; font-size: 25px; }
        .leaf:nth-child(2) { left: 12%; animation-duration: 16s; animation-delay: 2s; font-size: 35px; }
        .leaf:nth-child(3) { left: 20%; animation-duration: 12s; animation-delay: 4s; font-size: 28px; }
        .leaf:nth-child(4) { left: 28%; animation-duration: 18s; animation-delay: 1s; font-size: 22px; }
        .leaf:nth-child(5) { left: 35%; animation-duration: 15s; animation-delay: 3s; font-size: 32px; }
        .leaf:nth-child(6) { left: 42%; animation-duration: 13s; animation-delay: 5s; font-size: 26px; }
        .leaf:nth-child(7) { left: 50%; animation-duration: 17s; animation-delay: 2s; font-size: 30px; }
        .leaf:nth-child(8) { left: 58%; animation-duration: 11s; animation-delay: 4s; font-size: 24px; }
        .leaf:nth-child(9) { left: 65%; animation-duration: 19s; animation-delay: 1s; font-size: 33px; }
        .leaf:nth-child(10) { left: 72%; animation-duration: 14s; animation-delay: 3s; font-size: 27px; }
        .leaf:nth-child(11) { left: 78%; animation-duration: 16s; animation-delay: 5s; font-size: 29px; }
        .leaf:nth-child(12) { left: 85%; animation-duration: 12s; animation-delay: 2s; font-size: 31px; }
        .leaf:nth-child(13) { left: 92%; animation-duration: 15s; animation-delay: 4s; font-size: 25px; }
        .leaf:nth-child(14) { left: 8%; animation-duration: 20s; animation-delay: 6s; font-size: 28px; }
        .leaf:nth-child(15) { left: 95%; animation-duration: 13s; animation-delay: 1s; font-size: 34px; }
        
        /* Fireflies */
        .firefly {
            position: absolute;
            width: 4px;
            height: 4px;
            background: #ffeb3b;
            border-radius: 50%;
            box-shadow: 0 0 10px #ffeb3b, 0 0 20px #ffeb3b, 0 0 40px #ffeb3b;
            animation: fireflyFloat linear infinite;
            opacity: 0;
        }
        
        @keyframes fireflyFloat {
            0% { transform: translate(0, 0) scale(0); opacity: 0; }
            10% { opacity: 0.8; transform: translate(20px, -30px) scale(1); }
            30% { opacity: 0.4; transform: translate(-10px, -60px) scale(0.6); }
            50% { opacity: 0.9; transform: translate(30px, -90px) scale(1.2); }
            70% { opacity: 0.3; transform: translate(-20px, -120px) scale(0.5); }
            90% { opacity: 0.7; transform: translate(10px, -150px) scale(0.8); }
            100% { opacity: 0; transform: translate(0, -180px) scale(0); }
        }
        
        .firefly:nth-child(16) { left: 10%; top: 80%; animation-duration: 8s; animation-delay: 0s; }
        .firefly:nth-child(17) { left: 30%; top: 70%; animation-duration: 10s; animation-delay: 2s; }
        .firefly:nth-child(18) { left: 55%; top: 75%; animation-duration: 9s; animation-delay: 4s; }
        .firefly:nth-child(19) { left: 70%; top: 85%; animation-duration: 11s; animation-delay: 1s; }
        .firefly:nth-child(20) { left: 85%; top: 65%; animation-duration: 7s; animation-delay: 3s; }
        .firefly:nth-child(21) { left: 20%; top: 90%; animation-duration: 12s; animation-delay: 5s; }
        .firefly:nth-child(22) { left: 45%; top: 60%; animation-duration: 9s; animation-delay: 2s; }
        .firefly:nth-child(23) { left: 65%; top: 55%; animation-duration: 10s; animation-delay: 4s; }
        
        /* Login Container */
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 45px 40px 30px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 0 80px rgba(45,106,79,0.2);
            width: 420px;
            text-align: center;
            position: relative;
            z-index: 10;
            animation: slideUp 0.8s ease-out;
            border: 1px solid rgba(255,255,255,0.3);
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(60px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .login-container .logo-circle {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #2d6a4f, #40916c);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 45px;
            box-shadow: 0 10px 30px rgba(45,106,79,0.4);
            animation: pulse 3s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 10px 30px rgba(45,106,79,0.4); }
            50% { transform: scale(1.05); box-shadow: 0 15px 40px rgba(45,106,79,0.6); }
        }
        
        .login-container h2 {
            color: #1b4332;
            margin-bottom: 5px;
            font-size: 26px;
            font-weight: 700;
        }
        
        .login-container .subtitle {
            color: #666;
            font-size: 13px;
            margin-bottom: 25px;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 15px;
        }
        
        .input-group .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            z-index: 1;
        }
        
        .login-container input {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            box-sizing: border-box;
            transition: all 0.3s;
            background: #fafafa;
            font-family: 'Segoe UI', sans-serif;
        }
        
        .login-container input:focus {
            border-color: #2d6a4f;
            outline: none;
            background: white;
            box-shadow: 0 0 0 4px rgba(45,106,79,0.1);
        }
        
        .login-container button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #2d6a4f, #40916c);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 15px;
            transition: all 0.3s;
            letter-spacing: 0.5px;
            font-family: 'Segoe UI', sans-serif;
        }
        
        .login-container button:hover {
            background: linear-gradient(135deg, #1b4332, #2d6a4f);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(45,106,79,0.5);
        }
        
        .login-container button:active {
            transform: translateY(0);
        }
        
        .error {
            color: #d32f2f;
            background: #ffebee;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
            border-left: 4px solid #d32f2f;
            animation: shake 0.5s ease-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-10px); }
            40% { transform: translateX(10px); }
            60% { transform: translateX(-5px); }
            80% { transform: translateX(5px); }
        }
        
        .back-link {
            display: block;
            margin-top: 15px;
            color: #2d6a4f;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .back-link:hover {
            color: #1b4332;
            text-decoration: underline;
        }
        
        /* TINY Credentials - Small & Elegant */
        .tiny-credentials {
            margin-top: 15px;
            padding: 8px 15px;
            background: rgba(0,0,0,0.03);
            border-radius: 20px;
            display: inline-block;
            font-size: 11px;
            color: #999;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        .tiny-credentials:hover {
            background: rgba(0,0,0,0.06);
            color: #666;
        }
        .tiny-credentials span {
            color: #2d6a4f;
            font-weight: 600;
        }
        .tiny-credentials .dot {
            margin: 0 6px;
            color: #ccc;
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

<!-- Login Container -->
<div class="login-container">
    <div class="logo-circle">🦁</div>
    <h2>Zoo Planet</h2>
    <p class="subtitle">Admin Management System</p>
    
    <?php if (!empty($error)): ?>
        <div class="error">❌ <?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="input-group">
            <span class="input-icon">👤</span>
            <input type="text" name="username" placeholder="Username" required autocomplete="off">
        </div>
        
        <div class="input-group">
            <span class="input-icon">🔒</span>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        
        <button type="submit" name="login">🔐 Login to Dashboard</button>
    </form>
    
    <!-- Tiny Elegant Credentials -->
    <div class="tiny-credentials">
        🔑 <span>pallavi</span> <span class="dot">•</span> <span>*******</span>
    </div>
    
    <a href="index.html" class="back-link">← Back to Homepage</a>
</div>

</body>
</html>