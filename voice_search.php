<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎤 Voice Search - Zoo Planet</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1a0000, #0a1f0a);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            max-width: 500px;
            width: 90%;
            text-align: center;
        }
        h1 { color: #2d6a4f; }
        .subtitle { color: #666; margin: 10px 0 30px; }
        
        .mic-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 30px auto;
        }
        .mic-btn {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2d6a4f, #40916c);
            color: white;
            border: none;
            font-size: 60px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 10px 40px rgba(45,106,79,0.4);
            position: relative;
            z-index: 2;
        }
        .mic-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 50px rgba(45,106,79,0.6);
        }
        .mic-btn.listening {
            background: linear-gradient(135deg, #d32f2f, #f44336);
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(244,67,54,0.6); }
            50% { box-shadow: 0 0 0 40px rgba(244,67,54,0); }
            100% { box-shadow: 0 0 0 0 rgba(244,67,54,0); }
        }
        .ripple {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid #2d6a4f;
            animation: ripple 2s infinite;
            opacity: 0;
            z-index: 1;
        }
        @keyframes ripple {
            0% { width: 150px; height: 150px; opacity: 0.5; }
            100% { width: 300px; height: 300px; opacity: 0; }
        }
        
        .status-text {
            font-size: 18px;
            color: #666;
            margin: 20px 0;
            min-height: 30px;
            font-weight: bold;
        }
        .status-text.listening { color: #f44336; }
        .status-text.success { color: #2d6a4f; }
        
        .result-box {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            padding: 25px;
            border-radius: 15px;
            margin-top: 20px;
            display: none;
            animation: slideUp 0.5s ease-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .result-box .emoji { font-size: 70px; }
        .result-box h3 { color: #2d6a4f; font-size: 24px; margin: 10px 0; }
        .result-box p { color: #555; line-height: 1.8; font-size: 16px; }
        .result-box .quick-facts {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 15px;
            justify-content: center;
        }
        .quick-fact {
            background: #2d6a4f;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 12px;
        }
        
        .history-box {
            margin-top: 20px;
            text-align: left;
        }
        .history-box h4 { color: #666; margin-bottom: 10px; }
        .history-item {
            background: #f5f5f5;
            padding: 10px 15px;
            border-radius: 8px;
            margin: 5px 0;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .back-link { display: block; margin-top: 20px; color: #2d6a4f; text-decoration: none; }
        
        .try-saying {
            background: #fff3e0;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .try-saying h4 { color: #e65100; margin-bottom: 8px; }
        .try-saying span {
            display: inline-block;
            background: white;
            padding: 5px 12px;
            border-radius: 15px;
            margin: 3px;
            font-size: 13px;
            cursor: pointer;
            border: 1px solid #ffcc80;
        }
        .try-saying span:hover { background: #ffe0b2; }
    </style>
</head>
<body>

<div class="container">
    <h1>🎤 AI Voice Search</h1>
    <p class="subtitle">Speak an animal name and find it instantly!</p>
    
    <div class="mic-container">
        <div class="ripple"></div>
        <button class="mic-btn" id="micBtn" onclick="startListening()">
            🎤
        </button>
    </div>
    
    <div class="status-text" id="statusText">
        Click the mic and say an animal name
    </div>
    
    <div class="result-box" id="resultBox">
        <div class="emoji" id="resultEmoji"></div>
        <h3 id="resultName"></h3>
        <p id="resultInfo"></p>
        <div class="quick-facts" id="quickFacts"></div>
    </div>
    
    <div class="history-box" id="historyBox" style="display:none;">
        <h4>📜 Search History</h4>
        <div id="historyList"></div>
    </div>
    
    <div class="try-saying">
        <h4>💡 Try saying:</h4>
        <span onclick="searchAnimal('lion')">Lion</span>
        <span onclick="searchAnimal('tiger')">Tiger</span>
        <span onclick="searchAnimal('elephant')">Elephant</span>
        <span onclick="searchAnimal('giraffe')">Giraffe</span>
        <span onclick="searchAnimal('zebra')">Zebra</span>
        <span onclick="searchAnimal('deer')">Deer</span>
    </div>
    
    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
</div>

<script>
const animalDatabase = {
    lion: {
        emoji: '🦁',
        name: 'Lion - King of the Jungle',
        info: 'Lions live in prides of up to 30 members. Their roar can be heard from 8 km away!',
        quickFacts: ['🦁 Roar: 8km', '😴 Sleep: 20hrs', '🍖 Carnivore', '👑 Pride Leader']
    },
    tiger: {
        emoji: '🐯',
        name: 'Tiger - Striped Warrior',
        info: 'The largest wild cat! Excellent swimmers and each has unique stripe patterns.',
        quickFacts: ['🐯 Stripes: Unique', '🏊 Great Swimmer', '🏃 Speed: 65km/h', '🌙 Night Vision']
    },
    elephant: {
        emoji: '🐘',
        name: 'Elephant - Gentle Giant',
        info: 'The largest land animal with incredible intelligence and emotional capacity.',
        quickFacts: ['🐘 Can\'t Jump', '🧠 Brain: 5kg', '🦴 Trunk: 40K muscles', '💔 Mourns Dead']
    },
    giraffe: {
        emoji: '🦒',
        name: 'Giraffe - Tall Wonder',
        info: 'The tallest animal on Earth with a unique blue-black tongue!',
        quickFacts: ['🦒 Height: 18ft', '😴 Sleep: 30min', '👅 Blue Tongue', '❤️ Heart: 11kg']
    },
    zebra: {
        emoji: '🦓',
        name: 'Zebra - Striped Beauty',
        info: 'Each zebra has unique stripes like human fingerprints!',
        quickFacts: ['🦓 Unique Stripes', '🏃 Speed: 65km/h', '👥 Group: Dazzle', '🦟 Insect Repellent']
    },
    deer: {
        emoji: '🦌',
        name: 'Deer - Graceful Runner',
        info: 'Elegant creatures with antlers that grow and shed every year!',
        quickFacts: ['🦌 Speed: 80km/h', '🦴 Antlers: Yearly', '👀 Vision: 310°', '🏊 Can Swim']
    },
    parrot: {
        emoji: '🦜',
        name: 'Parrot - Intelligent Bird',
        info: 'Among the most intelligent birds, can learn over 1,000 words!',
        quickFacts: ['🦜 Lives: 80yrs', '🗣️ Words: 1000+', '🧠 Problem Solver', '💚 Mate for Life']
    },
    eagle: {
        emoji: '🦅',
        name: 'Eagle - Sky King',
        info: 'Majestic birds of prey with vision 8x better than humans!',
        quickFacts: ['🦅 Vision: 8x Human', '🦅 Speed: 240km/h', '🏔️ Altitude: 10K ft', '💪 Grip: 10x Human']
    }
};

let searchHistory = [];

function startListening() {
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    
    if (!SpeechRecognition) {
        alert('⚠️ Your browser does not support voice recognition.\n\nPlease use Google Chrome browser!');
        return;
    }
    
    const recognition = new SpeechRecognition();
    recognition.lang = 'en-US';
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;
    
    const micBtn = document.getElementById('micBtn');
    const statusText = document.getElementById('statusText');
    
    // Start listening animation
    micBtn.classList.add('listening');
    micBtn.textContent = '🎧';
    statusText.textContent = '🎧 Listening... Speak now!';
    statusText.className = 'status-text listening';
    
    recognition.start();
    
    recognition.onresult = function(event) {
        const spoken = event.results[0][0].transcript.toLowerCase().trim();
        statusText.textContent = '🗣️ You said: "' + spoken + '"';
        statusText.className = 'status-text success';
        
        // Search for animal in speech
        let found = false;
        for (let animal in animalDatabase) {
            if (spoken.includes(animal)) {
                showResult(animal);
                addToHistory(animal);
                found = true;
                break;
            }
        }
        
        if (!found) {
            showNoResult(spoken);
        }
    };
    
    recognition.onerror = function(event) {
        statusText.textContent = '❌ ' + event.error + '. Try again!';
        statusText.className = 'status-text';
        resetMic();
    };
    
    recognition.onend = function() {
        resetMic();
    };
    
    // Auto-stop after 5 seconds
    setTimeout(() => {
        if (micBtn.classList.contains('listening')) {
            recognition.stop();
            resetMic();
        }
    }, 5000);
}

function resetMic() {
    const micBtn = document.getElementById('micBtn');
    micBtn.classList.remove('listening');
    micBtn.textContent = '🎤';
}

function showResult(animal) {
    const data = animalDatabase[animal];
    
    document.getElementById('resultEmoji').textContent = data.emoji;
    document.getElementById('resultName').textContent = data.name;
    document.getElementById('resultInfo').textContent = data.info;
    
    const quickFactsDiv = document.getElementById('quickFacts');
    quickFactsDiv.innerHTML = '';
    data.quickFacts.forEach(fact => {
        const span = document.createElement('span');
        span.className = 'quick-fact';
        span.textContent = fact;
        quickFactsDiv.appendChild(span);
    });
    
    const resultBox = document.getElementById('resultBox');
    resultBox.style.display = 'block';
    resultBox.style.animation = 'none';
    resultBox.offsetHeight;
    resultBox.style.animation = 'slideUp 0.5s ease-out';
    
    // Speak the result
    speakResult(data.name);
}

function showNoResult(spoken) {
    document.getElementById('resultEmoji').textContent = '🤔';
    document.getElementById('resultName').textContent = 'Animal Not Found';
    document.getElementById('resultInfo').textContent = 'You said: "' + spoken + '"\n\nTry saying: Lion, Tiger, Elephant, Giraffe, Zebra, Deer, Parrot, or Eagle';
    document.getElementById('quickFacts').innerHTML = '';
    
    const resultBox = document.getElementById('resultBox');
    resultBox.style.display = 'block';
    resultBox.style.animation = 'none';
    resultBox.offsetHeight;
    resultBox.style.animation = 'slideUp 0.5s ease-out';
}

function addToHistory(animal) {
    const data = animalDatabase[animal];
    searchHistory.unshift({ emoji: data.emoji, name: animal, time: new Date().toLocaleTimeString() });
    
    if (searchHistory.length > 5) searchHistory.pop();
    
    updateHistory();
}

function updateHistory() {
    const historyBox = document.getElementById('historyBox');
    const historyList = document.getElementById('historyList');
    
    if (searchHistory.length > 0) {
        historyBox.style.display = 'block';
        historyList.innerHTML = searchHistory.map(item => 
            `<div class="history-item">
                <span style="font-size:24px;">${item.emoji}</span>
                <span>${item.name}</span>
                <span style="margin-left:auto;color:#999;font-size:12px;">${item.time}</span>
            </div>`
        ).join('');
    }
}

function speakResult(text) {
    if ('speechSynthesis' in window) {
        const utterance = new SpeechSynthesisUtterance('Found it! ' + text);
        utterance.lang = 'en-US';
        utterance.rate = 0.9;
        speechSynthesis.speak(utterance);
    }
}

function searchAnimal(animal) {
    showResult(animal);
    addToHistory(animal);
    document.getElementById('statusText').textContent = '🖱️ Selected: ' + animal;
    document.getElementById('statusText').className = 'status-text success';
}

// Keyboard shortcut: Press Space to activate mic
document.addEventListener('keydown', function(event) {
    if (event.code === 'Space' && event.target === document.body) {
        event.preventDefault();
        startListening();
    }
});
</script>

</body>
</html>