<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📸 AI Animal Identifier (ML)</title>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet@latest"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0a1f0a, #1a3a1a);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: rgba(255,255,255,0.95);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            max-width: 500px;
            width: 90%;
            text-align: center;
        }
        h1 { color: #2d6a4f; }
        .subtitle { color: #666; font-size: 13px; margin-bottom: 20px; }
        
        .upload-area {
            border: 3px dashed #2d6a4f;
            border-radius: 15px;
            padding: 30px;
            cursor: pointer;
            background: #f9f9f9;
            margin-bottom: 15px;
            transition: all 0.3s;
        }
        .upload-area:hover { background: #e8f5e9; }
        .upload-area .icon { font-size: 50px; }
        
        #preview {
            max-width: 100%;
            max-height: 200px;
            border-radius: 10px;
            display: none;
            margin: 15px auto;
        }
        
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6a1b9a, #9c27b0);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            display: none;
        }
        .btn:disabled { opacity: 0.5; cursor: not-allowed; }
        
        .result-box {
            background: linear-gradient(135deg, #f3e5f5, #e8f5e9);
            padding: 20px;
            border-radius: 15px;
            margin-top: 15px;
            display: none;
            animation: popIn 0.5s;
        }
        @keyframes popIn {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .result-box .emoji { font-size: 50px; }
        .result-box h3 { color: #2d6a4f; margin: 8px 0; }
        .result-box p { color: #555; font-size: 14px; }
        
        .loading {
            display: none;
            margin: 15px 0;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #9c27b0;
            border-radius: 50%;
            width: 40px; height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .status-msg {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }
        .back-link { display: block; margin-top: 15px; color: #2d6a4f; text-decoration: none; }
        
        .animal-map {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            text-align: left;
        }
        .animal-map h4 { font-size: 12px; color: #888; margin-bottom: 6px; }
        .animal-map span {
            display: inline-block;
            background: #e8f5e9;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            margin: 2px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>📸 AI Animal Identifier</h1>
    <p class="subtitle">Real ML-powered image recognition (MobileNet)</p>
    
    <div class="upload-area" id="uploadArea" onclick="document.getElementById('fileInput').click()">
        <div class="icon">🖼️</div>
        <p>Click to upload an animal photo</p>
        <p class="status-msg">Powered by TensorFlow.js MobileNet</p>
    </div>
    
    <input type="file" id="fileInput" accept="image/*" style="display:none;" onchange="handleFile(event)">
    
    <img id="preview" alt="Preview">
    
    <div class="loading" id="loading">
        <div class="spinner"></div>
        <p style="margin-top:8px; color:#666;">🔍 AI Model analyzing image...</p>
        <p class="status-msg" id="loadStatus"></p>
    </div>
    
    <button class="btn" id="identifyBtn" onclick="classifyImage()">🔍 Identify Animal</button>
    
    <div class="result-box" id="resultBox">
        <div class="emoji" id="resultEmoji">🔍</div>
        <h3 id="resultName"></h3>
        <p id="resultInfo"></p>
    </div>
    
    <!-- Quick Manual Select -->
    <div class="animal-map">
        <h4>👇 Or quickly select animal:</h4>
        <span onclick="showResult('🦁', 'Lion', 'King of the Jungle')" style="cursor:pointer;">🦁 Lion</span>
        <span onclick="showResult('🐯', 'Tiger', 'Largest wild cat')" style="cursor:pointer;">🐯 Tiger</span>
        <span onclick="showResult('🐘', 'Elephant', 'Gentle giant')" style="cursor:pointer;">🐘 Elephant</span>
        <span onclick="showResult('🦒', 'Giraffe', 'Tallest animal')" style="cursor:pointer;">🦒 Giraffe</span>
        <span onclick="showResult('🦓', 'Zebra', 'Striped beauty')" style="cursor:pointer;">🦓 Zebra</span>
        <span onclick="showResult('🦌', 'Deer', 'Graceful runner')" style="cursor:pointer;">🦌 Deer</span>
        <span onclick="showResult('🦜', 'Parrot', 'Smart bird')" style="cursor:pointer;">🦜 Parrot</span>
        <span onclick="showResult('🦅', 'Eagle', 'Sky king')" style="cursor:pointer;">🦅 Eagle</span>
    </div>
    
    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
</div>

<script>
let model = null;
let selectedFile = null;

// Load MobileNet model on page load
async function loadModel() {
    document.getElementById('loadStatus').textContent = 'Loading AI model...';
    try {
        model = await mobilenet.load();
        document.getElementById('loadStatus').textContent = '✅ Model ready! Upload an image.';
    } catch (error) {
        document.getElementById('loadStatus').textContent = '⚠️ Model load failed. Use manual selection.';
        console.log('Model load error:', error);
    }
}

loadModel();

function handleFile(event) {
    const file = event.target.files[0];
    if (!file) return;
    selectedFile = file;
    
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('preview').src = e.target.result;
        document.getElementById('preview').style.display = 'block';
        document.getElementById('identifyBtn').style.display = 'block';
        document.getElementById('uploadArea').style.display = 'none';
        document.getElementById('resultBox').style.display = 'none';
    };
    reader.readAsDataURL(file);
}

async function classifyImage() {
    if (!selectedFile) return;
    
    document.getElementById('loading').style.display = 'block';
    document.getElementById('identifyBtn').disabled = true;
    document.getElementById('resultBox').style.display = 'none';
    
    if (!model) {
        document.getElementById('loadStatus').textContent = 'Model not loaded. Using color detection...';
    }
    
    const img = document.getElementById('preview');
    
    try {
        let predictions;
        
        if (model) {
            // Use MobileNet model
            predictions = await model.classify(img);
        } else {
            // Fallback
            throw new Error('Model not available');
        }
        
        // Animal emoji mapping
        const animalEmojis = {
            'lion': '🦁', 'tiger': '🐯', 'elephant': '🐘', 'giraffe': '🦒',
            'zebra': '🦓', 'deer': '🦌', 'parrot': '🦜', 'eagle': '🦅',
            'bird': '🐦', 'cat': '🐱', 'dog': '🐕', 'horse': '🐴',
            'bear': '🐻', 'monkey': '🐵', 'snake': '🐍', 'fish': '🐟'
        };
        
        // Find best animal match
        let bestMatch = null;
        for (let pred of predictions) {
            const className = pred.className.toLowerCase();
            for (let animal in animalEmojis) {
                if (className.includes(animal)) {
                    if (!bestMatch || pred.probability > bestMatch.probability) {
                        bestMatch = {
                            name: animal.charAt(0).toUpperCase() + animal.slice(1),
                            emoji: animalEmojis[animal],
                            confidence: Math.round(pred.probability * 100),
                            info: `Detected by AI model with ${Math.round(pred.probability * 100)}% confidence.`
                        };
                    }
                }
            }
        }
        
        if (bestMatch) {
            showResult(bestMatch.emoji, bestMatch.name, bestMatch.info);
        } else {
            // Show top prediction
            const top = predictions[0];
            showResult('🔍', top.className.split(',')[0], 
                `AI sees: "${top.className}" (${Math.round(top.probability * 100)}% confidence). Try a clearer animal photo!`);
        }
        
    } catch (error) {
        // Fallback: Use the manual selection hint
        showResult('🤔', 'Could not identify', 
            'Please use the manual selection buttons below for accurate results. Or try a clearer photo!');
    }
    
    document.getElementById('loading').style.display = 'none';
    document.getElementById('identifyBtn').disabled = false;
}

function showResult(emoji, name, info) {
    document.getElementById('resultEmoji').textContent = emoji;
    document.getElementById('resultName').textContent = name;
    document.getElementById('resultInfo').textContent = info;
    
    const resultBox = document.getElementById('resultBox');
    resultBox.style.display = 'block';
    resultBox.style.animation = 'none';
    resultBox.offsetHeight;
    resultBox.style.animation = 'popIn 0.5s';
    
    document.getElementById('loading').style.display = 'none';
}
</script>

</body>
</html>

