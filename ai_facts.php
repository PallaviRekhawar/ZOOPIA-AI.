<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔮 AI Animal Facts Generator</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1a0033, #0a1f0a);
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
            max-width: 550px;
            width: 90%;
            text-align: center;
        }
        h1 { color: #2d6a4f; margin-bottom: 5px; }
        .subtitle { color: #666; margin-bottom: 25px; }
        
        .animal-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin: 20px 0;
        }
        .animal-btn {
            padding: 20px 10px;
            background: #f0f4f0;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            cursor: pointer;
            font-size: 30px;
            transition: all 0.3s;
        }
        .animal-btn:hover {
            background: #2d6a4f;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .animal-btn.active {
            background: #2d6a4f;
            border-color: #1b4332;
            color: white;
        }
        .animal-btn .name {
            font-size: 10px;
            display: block;
            margin-top: 5px;
            color: #333;
        }
        .animal-btn:hover .name,
        .animal-btn.active .name { color: white; }
        
        .generate-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #6a1b9a, #9c27b0);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            margin: 20px 0;
        }
        .generate-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(106,27,154,0.4);
        }
        .generate-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .fact-card {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            padding: 30px;
            border-radius: 15px;
            display: none;
            animation: popIn 0.6s ease-out;
        }
        @keyframes popIn {
            0% { transform: scale(0); opacity: 0; }
            70% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
        .fact-card .emoji { font-size: 60px; margin-bottom: 10px; }
        .fact-card h3 { color: #4caf50; font-size: 22px; margin: 10px 0; }
        .fact-card p { font-size: 16px; line-height: 1.8; color: #ddd; }
        .fact-card .category {
            display: inline-block;
            background: #6a1b9a;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .loader {
            display: none;
            margin: 20px 0;
        }
        .loader span {
            display: inline-block;
            width: 12px;
            height: 12px;
            background: #6a1b9a;
            border-radius: 50%;
            margin: 0 5px;
            animation: bounce 1.4s infinite;
        }
        .loader span:nth-child(2) { animation-delay: 0.2s; }
        .loader span:nth-child(3) { animation-delay: 0.4s; }
        @keyframes bounce {
            0%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-20px); }
        }
        .back-link { display: block; margin-top: 20px; color: #2d6a4f; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h1>🔮 AI Animal Facts Generator</h1>
    <p class="subtitle">Select an animal and AI will generate amazing facts!</p>
    
    <div class="animal-grid">
        <button class="animal-btn" onclick="selectAnimal('lion')">
            🦁<span class="name">Lion</span>
        </button>
        <button class="animal-btn" onclick="selectAnimal('tiger')">
            🐯<span class="name">Tiger</span>
        </button>
        <button class="animal-btn" onclick="selectAnimal('elephant')">
            🐘<span class="name">Elephant</span>
        </button>
        <button class="animal-btn" onclick="selectAnimal('giraffe')">
            🦒<span class="name">Giraffe</span>
        </button>
        <button class="animal-btn" onclick="selectAnimal('zebra')">
            🦓<span class="name">Zebra</span>
        </button>
        <button class="animal-btn" onclick="selectAnimal('deer')">
            🦌<span class="name">Deer</span>
        </button>
        <button class="animal-btn" onclick="selectAnimal('parrot')">
            🦜<span class="name">Parrot</span>
        </button>
        <button class="animal-btn" onclick="selectAnimal('eagle')">
            🦅<span class="name">Eagle</span>
        </button>
    </div>
    
    <button class="generate-btn" id="generateBtn" disabled onclick="generateFact()">
        🔮 Generate AI Fact
    </button>
    
    <div class="loader" id="loader">
        <span></span><span></span><span></span>
        <p style="margin-top:10px; color:#666;">AI is thinking...</p>
    </div>
    
    <div class="fact-card" id="factCard">
        <div class="emoji" id="factEmoji"></div>
        <h3 id="factTitle"></h3>
        <p id="factContent"></p>
        <span class="category" id="factCategory"></span>
    </div>
    
    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
</div>

<script>
let selectedAnimal = null;

// AI-generated facts database
const factDatabase = {
    lion: {
        emoji: '🦁',
        title: 'The King of the Jungle',
        facts: [
            { text: 'A lion\'s roar can be heard from 8 kilometers away! That\'s louder than a rock concert!', category: 'Amazing Ability' },
            { text: 'Lions sleep for 16-20 hours every day. Talk about beauty sleep!', category: 'Fun Fact' },
            { text: 'Female lions do 90% of the hunting while males protect the pride.', category: 'Behavior' },
            { text: 'A lion can eat up to 40 kg of meat in a single meal - that\'s like 400 burgers!', category: 'Diet' },
            { text: 'Lion cubs are born with spots that fade as they grow older.', category: 'Development' },
            { text: 'The mane of a male lion is unique - like a human fingerprint!', category: 'Unique Feature' },
            { text: 'Lions are the only cats that live in social groups called prides.', category: 'Social Behavior' },
            { text: 'A lion\'s night vision is 6 times better than a human\'s!', category: 'Super Ability' }
        ]
    },
    tiger: {
        emoji: '🐯',
        title: 'The Striped Warrior',
        facts: [
            { text: 'No two tigers have the same stripe pattern - it\'s their natural barcode!', category: 'Unique Feature' },
            { text: 'Tigers are excellent swimmers and can cross rivers up to 6 km wide!', category: 'Amazing Ability' },
            { text: 'A tiger\'s night vision is 6 times better than a human\'s.', category: 'Super Ability' },
            { text: 'Tiger stripes are not just on their fur - they\'re on their skin too!', category: 'Unique Feature' },
            { text: 'Tigers can jump up to 20 feet in a single leap!', category: 'Physical Power' },
            { text: 'Despite their size, tigers can run at speeds of 65 km/h!', category: 'Speed' },
            { text: 'Tiger cubs are born blind and completely dependent on their mother.', category: 'Development' },
            { text: 'A tiger\'s tail is 3-4 feet long and helps them balance while running!', category: 'Anatomy' }
        ]
    },
    elephant: {
        emoji: '🐘',
        title: 'The Gentle Giant',
        facts: [
            { text: 'Elephants are the only animals that can\'t jump! Their legs are too heavy!', category: 'Fun Fact' },
            { text: 'An elephant\'s trunk has 40,000 muscles - more than the entire human body!', category: 'Anatomy' },
            { text: 'Elephants can recognize themselves in mirrors - a sign of self-awareness!', category: 'Intelligence' },
            { text: 'Baby elephants suck their trunks for comfort, just like human babies suck thumbs!', category: 'Cute Behavior' },
            { text: 'Elephants can \'hear\' through their feet by detecting ground vibrations!', category: 'Super Ability' },
            { text: 'An elephant\'s brain is 3 times larger than a human\'s!', category: 'Anatomy' },
            { text: 'Elephants mourn their dead and have funeral rituals.', category: 'Emotional Intelligence' },
            { text: 'Elephants can consume up to 300 kg of food per day!', category: 'Diet' }
        ]
    },
    giraffe: {
        emoji: '🦒',
        title: 'The Tall Wonder',
        facts: [
            { text: 'A giraffe\'s neck is too short to reach the ground - they must spread legs to drink!', category: 'Fun Fact' },
            { text: 'Giraffes only need 5-30 minutes of sleep per day!', category: 'Amazing Ability' },
            { text: 'A giraffe\'s spots are unique like human fingerprints!', category: 'Unique Feature' },
            { text: 'Giraffes have the same number of neck vertebrae as humans - just 7!', category: 'Anatomy' },
            { text: 'A giraffe\'s heart weighs 11 kg and pumps 60 liters of blood per minute!', category: 'Anatomy' },
            { text: 'Baby giraffes can stand within 30 minutes of being born!', category: 'Development' },
            { text: 'Giraffes have blue-black tongues to protect them from sunburn!', category: 'Unique Feature' },
            { text: 'A giraffe\'s kick is so powerful it can kill a lion!', category: 'Defense' }
        ]
    },
    zebra: {
        emoji: '🦓',
        title: 'The Striped Beauty',
        facts: [
            { text: 'Each zebra\'s stripe pattern is unique - like a fingerprint!', category: 'Unique Feature' },
            { text: 'Zebras can run at speeds of 65 km/h to escape predators!', category: 'Speed' },
            { text: 'Zebra stripes confuse predators by creating visual illusions!', category: 'Defense' },
            { text: 'Zebras sleep standing up and only when in groups for safety!', category: 'Behavior' },
            { text: 'A group of zebras is called a \'dazzle\' or \'zeal\'!', category: 'Fun Fact' },
            { text: 'Zebras are black with white stripes, not white with black!', category: 'Surprising Truth' },
            { text: 'Zebra foals can walk within 20 minutes of being born!', category: 'Development' },
            { text: 'Zebras use their stripes as a natural insect repellent!', category: 'Adaptation' }
        ]
    },
    deer: {
        emoji: '🦌',
        title: 'The Graceful Runner',
        facts: [
            { text: 'Male deer grow and shed antlers every single year!', category: 'Unique Feature' },
            { text: 'Deer can run at speeds of up to 80 km/h!', category: 'Speed' },
            { text: 'A deer\'s eyes are on the sides of its head, giving 310-degree vision!', category: 'Anatomy' },
            { text: 'Deer antlers are the fastest growing tissue in any mammal!', category: 'Amazing Ability' },
            { text: 'Fawns are born scentless to protect them from predators!', category: 'Defense' },
            { text: 'Deer can jump up to 10 feet high!', category: 'Physical Power' },
            { text: 'Some deer species can swim up to 15 km!', category: 'Amazing Ability' },
            { text: 'Deer have excellent hearing due to their large ears!', category: 'Super Sense' }
        ]
    },
    parrot: {
        emoji: '🦜',
        title: 'The Intelligent Bird',
        facts: [
            { text: 'Some parrots can live over 80 years - they might outlive you!', category: 'Longevity' },
            { text: 'Parrots are among the most intelligent birds, with problem-solving skills!', category: 'Intelligence' },
            { text: 'African Grey Parrots can learn over 1,000 words!', category: 'Amazing Ability' },
            { text: 'Parrots have zygodactyl feet - two toes forward, two backward!', category: 'Anatomy' },
            { text: 'Some parrots can mimic sounds like phones, alarms, and car horns!', category: 'Mimicry' },
            { text: 'Parrots mate for life and show signs of grief when losing a partner!', category: 'Emotional Intelligence' },
            { text: 'A parrot\'s beak is strong enough to crack open hard nuts!', category: 'Physical Power' },
            { text: 'Parrots\' vibrant colors help them blend into tropical forests!', category: 'Camouflage' }
        ]
    },
    eagle: {
        emoji: '🦅',
        title: 'The Sky King',
        facts: [
            { text: 'Eagles can spot prey from 3 km away - 8x better than human vision!', category: 'Super Vision' },
            { text: 'Eagles can fly at speeds of up to 240 km/h when diving!', category: 'Speed' },
            { text: 'An eagle\'s nest can weigh up to 1 ton!', category: 'Amazing Ability' },
            { text: 'Eagles can fly at altitudes of 10,000 feet!', category: 'Flight' },
            { text: 'Bald Eagles mate for life and work together to raise young!', category: 'Behavior' },
            { text: 'An eagle\'s grip is 10x stronger than a human\'s!', category: 'Physical Power' },
            { text: 'Eagles can turn their heads 210 degrees!', category: 'Anatomy' },
            { text: 'The largest eagle has a wingspan of 2.5 meters!', category: 'Size' }
        ]
    }
};

function selectAnimal(animal) {
    selectedAnimal = animal;
    
    // Highlight selected button
    document.querySelectorAll('.animal-btn').forEach(btn => btn.classList.remove('active'));
    event.target.closest('.animal-btn').classList.add('active');
    
    // Enable generate button
    document.getElementById('generateBtn').disabled = false;
    document.getElementById('generateBtn').textContent = '🔮 Generate AI Fact for ' + animal.charAt(0).toUpperCase() + animal.slice(1);
}

function generateFact() {
    if (!selectedAnimal) return;
    
    const data = factDatabase[selectedAnimal];
    const allFacts = data.facts;
    
    // Get random fact (different from last time if possible)
    let randomFact;
    const lastFact = sessionStorage.getItem('lastFact_' + selectedAnimal);
    
    do {
        randomFact = allFacts[Math.floor(Math.random() * allFacts.length)];
    } while (allFacts.length > 1 && lastFact && randomFact.text === JSON.parse(lastFact).text);
    
    sessionStorage.setItem('lastFact_' + selectedAnimal, JSON.stringify(randomFact));
    
    // Show loading
    document.getElementById('factCard').style.display = 'none';
    document.getElementById('loader').style.display = 'block';
    document.getElementById('generateBtn').disabled = true;
    
    // Simulate AI processing
    setTimeout(() => {
        document.getElementById('loader').style.display = 'none';
        
        document.getElementById('factEmoji').textContent = data.emoji;
        document.getElementById('factTitle').textContent = data.title;
        document.getElementById('factContent').textContent = '💡 "' + randomFact.text + '"';
        document.getElementById('factCategory').textContent = '📂 ' + randomFact.category;
        
        const factCard = document.getElementById('factCard');
        factCard.style.display = 'block';
        factCard.style.animation = 'none';
        factCard.offsetHeight;
        factCard.style.animation = 'popIn 0.6s ease-out';
        
        document.getElementById('generateBtn').disabled = false;
        document.getElementById('generateBtn').textContent = '🔄 Generate Another Fact';
    }, 1500 + Math.random() * 2000);
}
</script>

</body>
</html>