// ======================== QUESTION BANK ========================
const questionBank = [
    // General
    { question: "What is the capital of France?", options: ["London", "Paris", "Berlin", "Madrid"], correct: 1, category: "General", difficulty: "Easy" },
    { question: "Which planet is known as the Red Planet?", options: ["Venus", "Mars", "Jupiter", "Saturn"], correct: 1, category: "General", difficulty: "Easy" },
    { question: "What is the largest ocean on Earth?", options: ["Atlantic", "Indian", "Arctic", "Pacific"], correct: 3, category: "General", difficulty: "Easy" },
    { question: "How many continents are there?", options: ["5", "6", "7", "8"], correct: 2, category: "General", difficulty: "Easy" },
    { question: "What is the chemical symbol for water?", options: ["H2O", "CO2", "NaCl", "HCl"], correct: 0, category: "General", difficulty: "Easy" },
    { question: "Who wrote 'Romeo and Juliet'?", options: ["Shakespeare", "Dickens", "Hemingway", "Tolkien"], correct: 0, category: "General", difficulty: "Medium" },
    { question: "What is the fastest land animal?", options: ["Lion", "Cheetah", "Horse", "Gazelle"], correct: 1, category: "General", difficulty: "Medium" },
    { question: "What is the largest mammal?", options: ["Elephant", "Blue Whale", "Giraffe", "Hippo"], correct: 1, category: "General", difficulty: "Medium" },
    // History
    { question: "Who was the first President of the United States?", options: ["Adams", "Jefferson", "Washington", "Lincoln"], correct: 2, category: "History", difficulty: "Easy" },
    { question: "In which year did World War II end?", options: ["1944", "1945", "1946", "1947"], correct: 1, category: "History", difficulty: "Easy" },
    { question: "What civilization built Machu Picchu?", options: ["Aztec", "Maya", "Inca", "Olmec"], correct: 2, category: "History", difficulty: "Medium" },
    { question: "Who was the first Emperor of Rome?", options: ["Julius Caesar", "Augustus", "Nero", "Caligula"], correct: 1, category: "History", difficulty: "Medium" },
    { question: "The Magna Carta was signed in which year?", options: ["1215", "1315", "1415", "1515"], correct: 0, category: "History", difficulty: "Hard" },
    { question: "Which ancient wonder was located in Babylon?", options: ["Colossus", "Hanging Gardens", "Lighthouse", "Temple"], correct: 1, category: "History", difficulty: "Hard" },
    // Political
    { question: "Who was the first Prime Minister of Britain?", options: ["Churchill", "Walpole", "Disraeli", "Gladstone"], correct: 1, category: "Political", difficulty: "Easy" },
    { question: "What is the political system of the USA?", options: ["Parliamentary", "Presidential", "Semi-presidential", "Constitutional Monarchy"], correct: 1, category: "Political", difficulty: "Easy" },
    { question: "Which country has the largest democracy?", options: ["USA", "UK", "India", "Brazil"], correct: 2, category: "Political", difficulty: "Medium" },
    { question: "What is the UN Security Council's permanent member count?", options: ["3", "5", "7", "9"], correct: 1, category: "Political", difficulty: "Medium" },
    { question: "Who was the first female Prime Minister of the UK?", options: ["Thatcher", "May", "Johnson", "Truss"], correct: 0, category: "Political", difficulty: "Hard" },
    // Technology
    { question: "What does CPU stand for?", options: ["Central Process Unit", "Computer Personal Unit", "Central Processing Unit", "Core Process Unit"], correct: 2, category: "Technology", difficulty: "Easy" },
    { question: "Which company developed the iPhone?", options: ["Samsung", "Google", "Apple", "Microsoft"], correct: 2, category: "Technology", difficulty: "Easy" },
    { question: "What is the most popular programming language in 2025?", options: ["Python", "Java", "C++", "JavaScript"], correct: 0, category: "Technology", difficulty: "Medium" },
    { question: "What does 'HTTP' stand for?", options: ["Hyper Transfer Text Protocol", "Hyper Text Transfer Protocol", "High Tech Transfer Protocol", "Hyper Text Transmission Protocol"], correct: 1, category: "Technology", difficulty: "Medium" },
    { question: "Which company created the Android OS?", options: ["Apple", "Google", "Microsoft", "IBM"], correct: 1, category: "Technology", difficulty: "Easy" },
    { question: "What is the latest version of Windows?", options: ["10", "11", "12", "8"], correct: 1, category: "Technology", difficulty: "Medium" },
    { question: "What is the name of the first computer virus?", options: ["Creeper", "Brain", "Melissa", "ILOVEYOU"], correct: 0, category: "Technology", difficulty: "Hard" },
    { question: "Which company is known for the 'ThinkPad' laptop?", options: ["Dell", "HP", "Lenovo", "Acer"], correct: 2, category: "Technology", difficulty: "Hard" },
    // Additional to fill 25+ 
    { question: "What is the smallest country in the world?", options: ["Monaco", "Vatican City", "Liechtenstein", "San Marino"], correct: 1, category: "General", difficulty: "Medium" },
    { question: "What is the longest river in the world?", options: ["Amazon", "Nile", "Yangtze", "Mississippi"], correct: 1, category: "General", difficulty: "Medium" },
    { question: "Who painted the Mona Lisa?", options: ["Michelangelo", "Da Vinci", "Raphael", "Donatello"], correct: 1, category: "History", difficulty: "Easy" },
    { question: "Which country gifted the Statue of Liberty to the USA?", options: ["England", "France", "Germany", "Spain"], correct: 1, category: "History", difficulty: "Medium" },
    { question: "What is the currency of Japan?", options: ["Yuan", "Won", "Yen", "Ringgit"], correct: 2, category: "General", difficulty: "Easy" },
    { question: "What is the main component of the Sun?", options: ["Helium", "Hydrogen", "Oxygen", "Carbon"], correct: 1, category: "General", difficulty: "Hard" },
    { question: "Which country has the most natural lakes?", options: ["USA", "Canada", "Russia", "Brazil"], correct: 1, category: "General", difficulty: "Hard" },
];

// ======================== GLOBAL STATE ========================
let currentQuestions = [];
let currentIndex = 0;
let selectedAnswers = [];
let correctCount = 0;
let wrongCount = 0;
let score = 0;
let timer = 300;   // <-- changed from 100 to 300
let timerInterval = null;
let quizActive = false;
let isSubmitted = false;
let filteredQuestions = [];

// DOM refs
const welcomeScreen = document.getElementById('welcome-screen');
const quizScreen = document.getElementById('quiz-screen');
const resultScreen = document.getElementById('result-screen');
const startBtn = document.getElementById('start-btn');
const restartBtn = document.getElementById('restart-btn');
const questionText = document.getElementById('question-text');
const optionsContainer = document.getElementById('options-container');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');
const submitBtn = document.getElementById('submit-btn');
const questionCounter = document.getElementById('question-counter');
const progressBar = document.getElementById('progress-bar');
const correctCountSpan = document.getElementById('correct-count');
const wrongCountSpan = document.getElementById('wrong-count');
const scoreSpan = document.getElementById('current-score');
const timerDisplay = document.getElementById('timer-display');
const categoryBadge = document.getElementById('question-category');
const difficultyBadge = document.getElementById('question-difficulty');
const categoryFilter = document.getElementById('category-filter');
const difficultyFilter = document.getElementById('difficulty-filter');
const applyFilterBtn = document.getElementById('apply-filter-btn');
const resetFilterBtn = document.getElementById('reset-filter-btn');
const themeToggle = document.getElementById('theme-toggle');

// Sound effects using Web Audio API
const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
function playBeep(freq, duration, type = 'sine') {
    const osc = audioCtx.createOscillator();
    const gain = audioCtx.createGain();
    osc.type = type;
    osc.frequency.value = freq;
    gain.gain.value = 0.15;
    gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + duration);
    osc.connect(gain);
    gain.connect(audioCtx.destination);
    osc.start();
    osc.stop(audioCtx.currentTime + duration);
}
function playCorrect() { playBeep(880, 0.15); }
function playWrong() { playBeep(330, 0.25, 'sawtooth'); }
function playSubmit() { playBeep(660, 0.1); setTimeout(() => playBeep(880, 0.1), 150); }

// ======================== UTILITY ========================
function shuffle(arr) {
    for (let i = arr.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [arr[i], arr[j]] = [arr[j], arr[i]];
    }
    return arr;
}

// ======================== HIGH SCORES ========================
function getHighScores() {
    try { return JSON.parse(localStorage.getItem('quizHighScores')) || []; } catch { return []; }
}
function saveHighScore(score) {
    const scores = getHighScores();
    scores.push(score);
    scores.sort((a,b) => b - a);
    if (scores.length > 10) scores.length = 10;
    localStorage.setItem('quizHighScores', JSON.stringify(scores));
}
function renderHighScores() {
    const container = document.getElementById('high-scores-container');
    const scores = getHighScores();
    if (scores.length === 0) {
        container.innerHTML = '<p style="color:#888;font-size:0.9rem;">No scores yet. Be the first!</p>';
        return;
    }
    container.innerHTML = '<div class="high-scores-list">' + scores.map(s => `<span class="high-score-entry">🏅 ${s}</span>`).join('') + '</div>';
}

// ======================== FILTERING & LOADING ========================
function getFilteredQuestions() {
    const cat = categoryFilter.value;
    const diff = difficultyFilter.value;
    let filtered = questionBank.slice();
    if (cat !== 'all') filtered = filtered.filter(q => q.category === cat);
    if (diff !== 'all') filtered = filtered.filter(q => q.difficulty === diff);
    return filtered;
}

function loadQuiz() {
    // Filter and pick 25 questions (or all if less, but we have many)
    let pool = getFilteredQuestions();
    // Shuffle pool
    shuffle(pool);
    // Take 25
    currentQuestions = pool.slice(0, 25);
    // If fewer than 25, repeat? But we have enough. 
    // But to be safe, if less than 25, we duplicate? Better to just use all.
    if (currentQuestions.length < 25) {
        // Pad with random from full bank
        const extra = questionBank.filter(q => !currentQuestions.includes(q));
        shuffle(extra);
        while (currentQuestions.length < 25 && extra.length > 0) {
            currentQuestions.push(extra.pop());
        }
        shuffle(currentQuestions);
    }
    // Shuffle options for each question
    currentQuestions.forEach(q => {
        // Shuffle options and adjust correct index
        const options = q.options;
        const correctAnswer = options[q.correct];
        const shuffled = shuffle([...options]);
        q.options = shuffled;
        q.correct = shuffled.indexOf(correctAnswer);
    });
    // Reset state
    currentIndex = 0;
    selectedAnswers = new Array(currentQuestions.length).fill(null);
    correctCount = 0;
    wrongCount = 0;
    score = 0;
    isSubmitted = false;
    clearInterval(timerInterval);
    timer = 300;   // <-- changed from 100 to 300
    timerDisplay.textContent = timer + 's';
    updateStatsAndProgress();
    renderQuestion();
    // Show quiz screen
    welcomeScreen.classList.remove('active');
    quizScreen.classList.add('active');
    resultScreen.classList.remove('active');
    // Start timer
    quizActive = true;
    timerInterval = setInterval(() => {
        timer--;
        timerDisplay.textContent = timer + 's';
        if (timer <= 0) {
            clearInterval(timerInterval);
            alert('⏰ Time is up! Submitting automatically.');
            submitQuiz();
        }
    }, 1000);
}

// ======================== RENDER QUESTION ========================
function renderQuestion() {
    if (!currentQuestions.length) return;
    const q = currentQuestions[currentIndex];
    questionText.textContent = q.question;
    categoryBadge.textContent = q.category;
    difficultyBadge.textContent = q.difficulty;
    questionCounter.textContent = `${currentIndex+1} / ${currentQuestions.length}`;
    progressBar.style.width = `${((currentIndex+1)/currentQuestions.length)*100}%`;

    // Render options
    const labels = ['a', 'b', 'c', 'd'];
    optionsContainer.innerHTML = q.options.map((opt, idx) => {
        const selected = selectedAnswers[currentIndex] === idx ? 'selected' : '';
        return `<div class="option-card ${selected}" data-index="${idx}">
                    <span class="option-label">${labels[idx]})</span> ${opt}
                </div>`;
    }).join('');

    // Attach click listeners
    document.querySelectorAll('.option-card').forEach(card => {
        card.addEventListener('click', function() {
            if (isSubmitted) return;
            const idx = parseInt(this.dataset.index);
            selectOption(idx);
        });
    });

    // Update nav buttons
    prevBtn.disabled = currentIndex === 0;
    if (currentIndex === currentQuestions.length - 1) {
        nextBtn.style.display = 'none';
        submitBtn.style.display = 'inline-block';
    } else {
        nextBtn.style.display = 'inline-block';
        submitBtn.style.display = 'none';
    }
    // Show submit if last
    if (currentIndex === currentQuestions.length - 1) {
        submitBtn.style.display = 'inline-block';
        nextBtn.style.display = 'none';
    }
    // Update stats
    updateStatsAndProgress();
}

function selectOption(idx) {
    if (isSubmitted) return;
    // Unselect others
    document.querySelectorAll('.option-card').forEach(card => {
        card.classList.remove('selected');
    });
    const cards = document.querySelectorAll('.option-card');
    if (cards[idx]) cards[idx].classList.add('selected');
    // Save answer
    const prev = selectedAnswers[currentIndex];
    if (prev !== null && prev !== idx) {
        // Adjust counts if changed
        // We'll recalc stats after saving
    }
    selectedAnswers[currentIndex] = idx;
    updateStatsAndProgress();
}

function updateStatsAndProgress() {
    // Recalculate correct/wrong/score from selectedAnswers
    let correct = 0, wrong = 0, sc = 0;
    for (let i = 0; i < currentQuestions.length; i++) {
        const ans = selectedAnswers[i];
        if (ans === null) continue;
        if (ans === currentQuestions[i].correct) {
            correct++;
            sc++;
        } else {
            wrong++;
        }
    }
    correctCount = correct;
    wrongCount = wrong;
    score = sc;
    correctCountSpan.textContent = correctCount;
    wrongCountSpan.textContent = wrongCount;
    scoreSpan.textContent = score;
}

// ======================== NAVIGATION ========================
function goToPrev() {
    if (currentIndex > 0) {
        currentIndex--;
        renderQuestion();
    }
}

function goToNext() {
    if (currentIndex < currentQuestions.length - 1) {
        // If current question unanswered, keep going? We'll allow.
        currentIndex++;
        renderQuestion();
    }
}

// ======================== SUBMIT ========================
function submitQuiz() {
    if (isSubmitted) return;
    if (timerInterval) clearInterval(timerInterval);
    quizActive = false;
    isSubmitted = true;
    playSubmit();

    // Calculate final
    let correct = 0, wrong = 0, sc = 0;
    for (let i = 0; i < currentQuestions.length; i++) {
        const ans = selectedAnswers[i];
        if (ans === null) continue;
        if (ans === currentQuestions[i].correct) {
            correct++;
            sc++;
        } else {
            wrong++;
        }
    }
    correctCount = correct;
    wrongCount = wrong;
    score = sc;

    // Show result
    showResult(correct, wrong, score);
}

function showResult(correct, wrong, score) {
    const total = currentQuestions.length;
    const percentage = Math.round((score / total) * 100);
    let message = '';
    let icon = '';
    if (percentage >= 80) { message = '🌟 Excellent! You are a Quiz Master!'; icon = '🏆'; }
    else if (percentage >= 60) { message = '👍 Good job! Keep learning!'; icon = '🎉'; }
    else if (percentage >= 50) { message = '📚 Not bad, but you can do better!'; icon = '📖'; }
    else { message = '💪 Keep practicing! You\'ll improve!'; icon = '🔄'; }

    document.getElementById('result-icon').textContent = icon;
    document.getElementById('result-title').textContent = 'Quiz Complete!';
    document.getElementById('result-total').textContent = total;
    document.getElementById('result-correct').textContent = correct;
    document.getElementById('result-wrong').textContent = wrong;
    document.getElementById('result-score').textContent = score;
    document.getElementById('result-percentage').textContent = percentage + '%';
    document.getElementById('result-message').textContent = message;

    // Review answers
    const reviewContainer = document.getElementById('review-container');
    reviewContainer.innerHTML = currentQuestions.map((q, idx) => {
        const userAns = selectedAnswers[idx];
        const correctAns = q.correct;
        const userText = userAns !== null ? q.options[userAns] : 'Not answered';
        const correctText = q.options[correctAns];
        let status = userAns === correctAns ? '✅' : (userAns !== null ? '❌' : '⏳');
        return `<div class="review-item">
                    <span class="q">Q${idx+1}: ${q.question}</span><br>
                    <span>Your answer: <span class="your-ans">${userText}</span></span>
                    <span> | Correct: <span class="correct-ans">${correctText}</span></span>
                    <span> ${status}</span>
                </div>`;
    }).join('');

    // Save high score
    saveHighScore(score);
    renderHighScores();

    // Switch screens
    quizScreen.classList.remove('active');
    resultScreen.classList.add('active');
}

// ======================== RESTART ========================
function restartQuiz() {
    clearInterval(timerInterval);
    isSubmitted = false;
    resultScreen.classList.remove('active');
    // Reload with current filters
    loadQuiz();
}

// ======================== THEME TOGGLE ========================
themeToggle.addEventListener('click', function() {
    document.body.classList.toggle('dark');
    this.textContent = document.body.classList.contains('dark') ? '☀️' : '🌙';
});

// ======================== FILTERS ========================
applyFilterBtn.addEventListener('click', function() {
    if (quizActive && !isSubmitted) {
        if (!confirm('Applying filters will restart the quiz. Continue?')) return;
    }
    loadQuiz();
});

resetFilterBtn.addEventListener('click', function() {
    categoryFilter.value = 'all';
    difficultyFilter.value = 'all';
    if (quizActive && !isSubmitted) {
        if (!confirm('Resetting filters will restart the quiz. Continue?')) return;
    }
    loadQuiz();
});

// ======================== EVENT LISTENERS ========================
startBtn.addEventListener('click', loadQuiz);
restartBtn.addEventListener('click', restartQuiz);
prevBtn.addEventListener('click', goToPrev);
nextBtn.addEventListener('click', goToNext);
submitBtn.addEventListener('click', submitQuiz);

// ======================== INITIAL LOAD ========================
// Show welcome, render high scores on welcome? 
renderHighScores();
// Preload filters
categoryFilter.value = 'all';
difficultyFilter.value = 'all';
// Set theme toggle icon
if (document.body.classList.contains('dark')) themeToggle.textContent = '☀️';
else themeToggle.textContent = '🌙';