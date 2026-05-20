<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🤖 Zoo Planet AI Assistant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
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
        
        /* Background Effects */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: 
                radial-gradient(ellipse at 20% 80%, rgba(45,106,79,0.2) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(156,39,176,0.15) 0%, transparent 50%);
            z-index: 0;
            pointer-events: none;
        }
        
        /* Floating Leaves */
        .leaf {
            position: fixed;
            font-size: 22px;
            animation: floatLeaf linear infinite;
            opacity: 0;
            pointer-events: none;
            z-index: 0;
        }
        @keyframes floatLeaf {
            0% { transform: translateY(105vh) rotate(0deg); opacity: 0; }
            5% { opacity: 0.2; }
            90% { opacity: 0.2; }
            100% { transform: translateY(-10vh) rotate(720deg); opacity: 0; }
        }
        .leaf:nth-child(1) { left: 5%; animation-duration: 15s; animation-delay: 0s; }
        .leaf:nth-child(2) { left: 15%; animation-duration: 18s; animation-delay: 2s; font-size: 28px; }
        .leaf:nth-child(3) { left: 30%; animation-duration: 13s; animation-delay: 4s; }
        .leaf:nth-child(4) { left: 50%; animation-duration: 16s; animation-delay: 1s; }
        .leaf:nth-child(5) { left: 70%; animation-duration: 14s; animation-delay: 3s; }
        .leaf:nth-child(6) { left: 85%; animation-duration: 17s; animation-delay: 5s; }
        
        .chat-container {
            width: 430px;
            height: 620px;
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
            z-index: 10;
            animation: slideUp 0.6s ease-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .chat-header {
            background: linear-gradient(135deg, #2d6a4f, #40916c);
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }
        .chat-header .bot-icon {
            font-size: 45px;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .chat-header h3 { font-size: 20px; margin-top: 5px; }
        .chat-header .status { font-size: 11px; opacity: 0.9; margin-top: 2px; }
        
        .chat-body {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #f8f8f8;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .chat-body::-webkit-scrollbar { width: 5px; }
        .chat-body::-webkit-scrollbar-thumb { background: #ccc; border-radius: 5px; }
        
        .message {
            max-width: 82%;
            padding: 12px 16px;
            border-radius: 15px;
            font-size: 14px;
            line-height: 1.6;
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .bot-message {
            background: white;
            align-self: flex-start;
            border-bottom-left-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            color: #333;
        }
        .user-message {
            background: linear-gradient(135deg, #2d6a4f, #40916c);
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 5px;
        }
        
        .suggestions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 12px 15px;
            background: white;
            border-top: 1px solid #eee;
        }
        .chip {
            background: #e8f5e9;
            color: #2d6a4f;
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 12px;
            cursor: pointer;
            border: none;
            transition: all 0.3s;
            font-weight: 500;
        }
        .chip:hover {
            background: #2d6a4f;
            color: white;
            transform: scale(1.05);
        }
        
        .chat-footer {
            padding: 15px;
            background: white;
            border-top: 1px solid #eee;
            display: flex;
            gap: 10px;
        }
        .chat-footer input {
            flex: 1;
            padding: 12px 18px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s;
            font-family: 'Segoe UI', sans-serif;
        }
        .chat-footer input:focus {
            border-color: #2d6a4f;
            box-shadow: 0 0 0 3px rgba(45,106,79,0.1);
        }
        .chat-footer button {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #2d6a4f, #40916c);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .chat-footer button:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(45,106,79,0.3);
        }
        
        /* Back to Dashboard Button */
        .back-dashboard {
            display: block;
            text-align: center;
            padding: 12px;
            background: rgba(255,255,255,0.1);
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s;
            letter-spacing: 1px;
        }
        .back-dashboard:hover {
            background: rgba(255,255,255,0.25);
        }
    </style>
</head>
<body>

<!-- Floating Leaves -->
<div class="leaf">🌿</div>
<div class="leaf">🍃</div>
<div class="leaf">🌱</div>
<div class="leaf">🍀</div>
<div class="leaf">🌿</div>
<div class="leaf">🍃</div>

<div class="chat-container">
    <!-- Header -->
    <div class="chat-header">
        <div class="bot-icon">🤖</div>
        <h3>Zoo AI Assistant</h3>
        <p class="status">🟢 Online | Ask me anything!</p>
    </div>
    
    <!-- Chat Body -->
    <div class="chat-body" id="chatBody">
        <div class="message bot-message">
            👋 Hello! I'm your <b>Zoo Planet AI Assistant</b>!<br><br>
            I can tell you about:<br>
            🦁 <b>Animals</b> - Lions, Tigers, Elephants<br>
            🎫 <b>Tickets</b> - Prices & Booking<br>
            🕐 <b>Timings</b> - Zoo hours & Shows<br>
            📍 <b>Location</b> - How to reach us<br><br>
            How can I help you today? 😊
        </div>
    </div>
    
    <!-- Suggestions -->
    <div class="suggestions">
        <button class="chip" onclick="ask('Tell me about Lions')">🦁 Lions</button>
        <button class="chip" onclick="ask('What are ticket prices?')">🎫 Tickets</button>
        <button class="chip" onclick="ask('Zoo timings')">🕐 Timings</button>
        <button class="chip" onclick="ask('Tell me about Tigers')">🐯 Tigers</button>
        <button class="chip" onclick="ask('How to reach the zoo?')">📍 Location</button>
    </div>
    
    <!-- Chat Input -->
    <div class="chat-footer">
        <input type="text" id="userInput" placeholder="Type your question..." onkeypress="if(event.key==='Enter') sendMsg()">
        <button onclick="sendMsg()">➤</button>
    </div>
    
    <!-- Back to Dashboard -->
    <a href="dashboard.php" class="back-dashboard">🏠 Go to Dashboard</a>
</div>

<script>
const knowledge = {
    'lion': '🦁 <b>Lions - King of the Jungle!</b><br><br>• Scientific Name: Panthera leo<br>• Lifespan: 10-14 years<br>• Diet: Carnivore<br>• Pride Size: Up to 30 lions<br>• Fun Fact: A lion\'s roar can be heard 8 km away!<br><br>🏠 <b>At Zoo Planet:</b> We have 4 African lions in a natural habitat enclosure.',
    
    'tiger': '🐯 <b>Tigers - Largest Wild Cat!</b><br><br>• Scientific Name: Panthera tigris<br>• Lifespan: 10-15 years<br>• Weight: Up to 300 kg<br>• Fun Fact: No two tigers have the same stripes!<br><br>🏠 <b>At Zoo Planet:</b> Visit our Royal Bengal Tigers in a special enclosure.',
    
    'elephant': '🐘 <b>Elephants - Gentle Giants!</b><br><br>• Scientific Name: Elephas maximus<br>• Lifespan: 60-70 years<br>• Weight: Up to 5000 kg<br>• Fun Fact: They are the only animals that can\'t jump!<br><br>🏠 <b>At Zoo Planet:</b> Watch our elephant show daily at 11 AM & 3 PM.',
    
    'giraffe': '🦒 <b>Giraffes - Tallest Animal!</b><br><br>• Height: Up to 18 feet<br>• Lifespan: 25 years<br>• Fun Fact: They only need 30 minutes of sleep per day!<br><br>🏠 <b>At Zoo Planet:</b> Feed giraffes at our special feeding zone.',
    
    'zebra': '🦓 <b>Zebras - Striped Beauty!</b><br><br>• Scientific Name: Equus zebra<br>• Lifespan: 25 years<br>• Fun Fact: Each zebra has unique stripes like fingerprints!<br><br>🏠 <b>At Zoo Planet:</b> See zebras in the African Savanna zone.',
    
    'ticket': '🎫 <b>Ticket Information:</b><br><br>• Adult (12+): <b>₹154.50</b> (incl. GST)<br>• Child (3-12): <b>₹103.00</b> (incl. GST)<br>• Below 3 years: <b>FREE</b><br>• Senior Citizen: <b>₹100</b><br><br>🎟️ <b>Packages:</b><br>• Family (2+2): ₹450<br>• School Group: ₹80/student<br><br>📞 Book at: <b>1800-ZOO-PLANET</b>',
    
    'timing': '🕐 <b>Zoo Timings:</b><br><br>• Mon-Sat: 9 AM - 5 PM<br>• Sunday: 8:30 AM - 6 PM<br><br>🎪 <b>Show Timings:</b><br>• Elephant Show: 11 AM & 3 PM<br>• Bird Show: 12 PM & 4 PM<br>• Feeding: 10:30 AM & 2:30 PM<br><br>📍 <b>Closed on:</b> National Holidays',
    
    'location': '📍 <b>How to Reach Zoo Planet:</b><br><br>• Address: 123 Wildlife Road, Green Valley<br>• 📞 Phone: 1800-ZOO-PLANET<br>• 📧 Email: info@zooplanet.com<br>• 🚗 Parking: ₹50/car<br>• 🚌 Nearest Bus: Wildlife Colony (500m)<br>• 🚂 Nearest Train: Green Valley Station (2km)',
    
    'hello': '👋 Hello! Welcome to Zoo Planet! I can tell you about animals, tickets, timings, and more. What would you like to know? 😊',
    'hi': '👋 Hi there! Ask me anything about Zoo Planet - animals, tickets, shows, or directions!',
    'help': '🤖 <b>I can help you with:</b><br><br>🦁 Animal Information<br>🎫 Ticket Prices<br>🕐 Zoo Timings<br>📍 Location & Directions<br>🎪 Show Schedules<br><br>Just type your question!'
};

function getResponse(msg) {
    msg = msg.toLowerCase();
    if (msg.includes('lion') || msg.includes('sher')) return knowledge['lion'];
    if (msg.includes('tiger') || msg.includes('bagh')) return knowledge['tiger'];
    if (msg.includes('elephant') || msg.includes('hathi')) return knowledge['elephant'];
    if (msg.includes('giraffe')) return knowledge['giraffe'];
    if (msg.includes('zebra')) return knowledge['zebra'];
    if (msg.includes('ticket') || msg.includes('price') || msg.includes('cost') || msg.includes('booking')) return knowledge['ticket'];
    if (msg.includes('time') || msg.includes('open') || msg.includes('show') || msg.includes('hour')) return knowledge['timing'];
    if (msg.includes('location') || msg.includes('address') || msg.includes('where') || msg.includes('direction') || msg.includes('reach')) return knowledge['location'];
    if (msg.includes('hello') || msg.includes('hi') || msg.includes('hey')) return knowledge['hello'];
    if (msg.includes('help')) return knowledge['help'];
    return '🤔 I\'m not sure about that. Try asking about:<br><br>🦁 Animals (Lion, Tiger, Elephant, Giraffe, Zebra)<br>🎫 Tickets & Prices<br>🕐 Zoo Timings<br>📍 Location & Directions<br><br>Or type <b>"help"</b> for more options!';
}

function addMsg(text, type) {
    const div = document.createElement('div');
    div.className = 'message ' + type + '-message';
    div.innerHTML = text;
    document.getElementById('chatBody').appendChild(div);
    document.getElementById('chatBody').scrollTop = document.getElementById('chatBody').scrollHeight;
}

function sendMsg() {
    const input = document.getElementById('userInput');
    const msg = input.value.trim();
    if (!msg) return;
    addMsg(msg, 'user');
    input.value = '';
    setTimeout(() => { addMsg(getResponse(msg), 'bot'); }, 600 + Math.random() * 800);
}

function ask(question) {
    document.getElementById('userInput').value = question;
    sendMsg();
}
</script>

</body>
</html>