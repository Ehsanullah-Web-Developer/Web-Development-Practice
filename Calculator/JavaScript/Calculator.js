/* ---------- DOM References ---------- */
const resultDisplay = document.getElementById('resultDisplay');
const expressionDisplay = document.getElementById('expressionDisplay');
const buttonGrid = document.getElementById('buttonGrid');
const sciGrid = document.getElementById('sciGrid');
const historyList = document.getElementById('historyList');
const historyPanel = document.getElementById('historyPanel');
const themeToggle = document.getElementById('themeToggle');
const historyToggle = document.getElementById('historyToggle');
const sciToggle = document.getElementById('sciToggle');
const copyBtn = document.getElementById('copyResult');
const clearHistoryBtn = document.getElementById('clearHistory');

/* ---------- State ---------- */
let currentInput = '0';         // displayed value
let previousInput = '';         // stored before operator
let operator = null;            // current operator
let shouldResetInput = false;   // flag to start fresh after operator
let history = [];              // array of {expression, result}
let isDark = false;

/* ---------- Helper Functions ---------- */
function updateDisplay() {
    // Limit display length for readability
    let displayVal = currentInput;
    if (displayVal.length > 14) {
        // Try to format as number with limited decimals
        if (!isNaN(parseFloat(displayVal)) && isFinite(displayVal)) {
            const num = parseFloat(displayVal);
            displayVal = num.toPrecision(10);
            if (displayVal.length > 14) displayVal = num.toExponential(6);
        } else {
            displayVal = displayVal.slice(0, 14) + '…';
        }
    }
    resultDisplay.textContent = displayVal || '0';
    expressionDisplay.textContent = previousInput + (operator || '');
}

function addHistory(expression, result) {
    history.push({ expression, result });
    if (history.length > 50) history.shift(); // limit
    renderHistory();
}

function renderHistory() {
    historyList.innerHTML = '';
    if (history.length === 0) {
        const empty = document.createElement('li');
        empty.className = 'history-empty';
        empty.textContent = 'No calculations yet';
        historyList.appendChild(empty);
        return;
    }
    // Show newest first
    const reversed = [...history].reverse();
    reversed.forEach(item => {
        const li = document.createElement('li');
        li.innerHTML = `<span>${item.expression}</span><span>= ${item.result}</span>`;
        historyList.appendChild(li);
    });
}

function clearAll() {
    currentInput = '0';
    previousInput = '';
    operator = null;
    shouldResetInput = false;
    updateDisplay();
}

function deleteLast() {
    if (currentInput.length > 1) {
        currentInput = currentInput.slice(0, -1);
    } else {
        currentInput = '0';
    }
    updateDisplay();
}

function toggleSign() {
    if (currentInput === '0') return;
    if (currentInput.startsWith('-')) {
        currentInput = currentInput.slice(1);
    } else {
        currentInput = '-' + currentInput;
    }
    updateDisplay();
}

function percent() {
    const num = parseFloat(currentInput);
    if (!isNaN(num) && isFinite(num)) {
        currentInput = String(num / 100);
        updateDisplay();
    }
}

/* ---------- Core Calculation ---------- */
function evaluate(expression) {
    // Replace display symbols with JS equivalents
    let sanitized = expression
        .replace(/×/g, '*')
        .replace(/÷/g, '/')
        .replace(/−/g, '-')
        .replace(/π/g, Math.PI)
        .replace(/e/g, Math.E)
        .replace(/sin\(/g, 'Math.sin(')
        .replace(/cos\(/g, 'Math.cos(')
        .replace(/tan\(/g, 'Math.tan(')
        .replace(/log\(/g, 'Math.log10(')
        .replace(/ln\(/g, 'Math.log(')
        .replace(/√\(/g, 'Math.sqrt(')
        .replace(/²/g, '**2')
        .replace(/³/g, '**3')
        .replace(/x\^y/g, '**')  // handled by ^
        .replace(/\^/g, '**')
        .replace(/1\/\(/g, '1/(')
        .replace(/\/\//g, '/')   // integer division handled later
        .replace(/!/g, 'factorial(');

    // Custom factorial function
    if (sanitized.includes('factorial(')) {
        // We'll handle factorial via a function call
        // We'll replace factorial( with a self-invoking function
        // Use a helper: we'll parse and compute after
        // Simpler: we'll implement factorial in the evaluation
        // Use a workaround: replace with a function that computes
        // We'll define a global factorial function.
        // But we can't define inside eval easily.
        // Let's use a safer approach: we'll manually compute factorial for numbers.
        // Since we want to avoid OOP, we'll use a function.
    }

    // Handle factorial: we'll replace factorial(n) with a computed value
    // Use regex to find factorial calls
    let factorialMatch;
    const factRegex = /factorial\(([^)]+)\)/g;
    while ((factorialMatch = factRegex.exec(sanitized)) !== null) {
        const arg = factorialMatch[1];
        const num = parseFloat(arg);
        if (!isNaN(num) && Number.isInteger(num) && num >= 0) {
            let result = 1;
            for (let i = 2; i <= num; i++) result *= i;
            sanitized = sanitized.replace(factorialMatch[0], result);
        } else {
            throw new Error('Invalid factorial argument');
        }
        // Reset regex lastIndex to avoid infinite loop
        factRegex.lastIndex = 0;
    }

    try {
        // Use Function constructor for safer eval (still not perfect but better)
        const result = new Function(`return (${sanitized})`)();
        if (typeof result !== 'number' || !isFinite(result)) {
            throw new Error('Invalid result');
        }
        return String(result);
    } catch (e) {
        return 'Error';
    }
}

function calculate() {
    if (operator === null) {
        // Just return current
        return currentInput;
    }

    const prev = parseFloat(previousInput);
    const curr = parseFloat(currentInput);
    if (isNaN(prev) || isNaN(curr)) return 'Error';

    let result;
    switch (operator) {
        case '+': result = prev + curr; break;
        case '−': result = prev - curr; break;
        case '×': result = prev * curr; break;
        case '÷':
            if (curr === 0) return 'Error: Div by 0';
            result = prev / curr; break;
        case '%': result = prev % curr; break;
        case '//':
            if (curr === 0) return 'Error: Div by 0';
            result = Math.floor(prev / curr); break;
        default: return 'Error';
    }

    // For other operators like ^, we already handle in evaluate for expression.
    // So here we only handle basic operators.
    // If operator is not in this list, we might have used evaluate.
    // But we call calculate only when operator is one of these.
    if (isNaN(result) || !isFinite(result)) return 'Error';
    return String(result);
}

/* ---------- Input Handling ---------- */
function inputDigit(digit) {
    if (shouldResetInput) {
        currentInput = digit;
        shouldResetInput = false;
    } else {
        if (currentInput === '0' && digit !== '.') {
            currentInput = digit;
        } else {
            currentInput += digit;
        }
    }
    updateDisplay();
}

function inputDecimal() {
    if (shouldResetInput) {
        currentInput = '0.';
        shouldResetInput = false;
        updateDisplay();
        return;
    }
    if (!currentInput.includes('.')) {
        currentInput += '.';
    }
    updateDisplay();
}

function inputOperator(op) {
    // If there's a pending operator, compute first
    if (operator !== null && !shouldResetInput) {
        const result = calculate();
        if (result === 'Error' || result === 'Error: Div by 0') {
            currentInput = 'Error';
            updateDisplay();
            operator = null;
            previousInput = '';
            return;
        }
        // Store result as previous and reset current
        previousInput = result;
        currentInput = result;
    } else {
        // No pending operator, store current
        previousInput = currentInput;
    }
    operator = op;
    shouldResetInput = true;
    updateDisplay();
}

function handleEqual() {
    if (operator === null) {
        // Just display current (no operation)
        return;
    }

    // For '//' handle separately
    if (operator === '//') {
        const prev = parseFloat(previousInput);
        const curr = parseFloat(currentInput);
        if (isNaN(prev) || isNaN(curr)) {
            currentInput = 'Error';
            updateDisplay();
            return;
        }
        if (curr === 0) {
            currentInput = 'Error: Div by 0';
            updateDisplay();
            return;
        }
        const result = Math.floor(prev / curr);
        const expr = `${previousInput} // ${currentInput}`;
        addHistory(expr, String(result));
        previousInput = '';
        operator = null;
        currentInput = String(result);
        shouldResetInput = true;
        updateDisplay();
        return;
    }

    // For standard operators, build expression string and evaluate
    let expr = previousInput + operator + currentInput;
    // Replace display symbols with JS equivalents
    let jsExpr = expr.replace(/×/g, '*').replace(/÷/g, '/').replace(/−/g, '-');
    // Handle percentage: if operator is %, we need to compute percentage
    // But we already have % as an operator, we'll compute using calculate
    // Actually we handle % in calculate. For other operators, we evaluate.
    // But we also have ^, etc. For now, we'll use calculate for basic ops.
    // But we want to support expression with multiple operators, so we use evaluate.
    // However, we store only one operator at a time. So it's always binary.
    // So we can use calculate.
    const result = calculate();
    if (result === 'Error' || result === 'Error: Div by 0') {
        currentInput = result;
        updateDisplay();
        operator = null;
        previousInput = '';
        shouldResetInput = true;
        return;
    }
    // Add to history
    addHistory(expr, result);
    previousInput = '';
    operator = null;
    currentInput = result;
    shouldResetInput = true;
    updateDisplay();
}

/* ---------- Scientific Input ---------- */
function inputScientific(value) {
    if (value === 'π') {
        currentInput = String(Math.PI);
        updateDisplay();
        return;
    }
    if (value === 'e') {
        currentInput = String(Math.E);
        updateDisplay();
        return;
    }
    if (value === '²') {
        // Square current input
        const num = parseFloat(currentInput);
        if (!isNaN(num) && isFinite(num)) {
            currentInput = String(num * num);
            updateDisplay();
        }
        return;
    }
    if (value === '³') {
        const num = parseFloat(currentInput);
        if (!isNaN(num) && isFinite(num)) {
            currentInput = String(num * num * num);
            updateDisplay();
        }
        return;
    }
    if (value === '!') {
        const num = parseFloat(currentInput);
        if (!isNaN(num) && Number.isInteger(num) && num >= 0) {
            let fact = 1;
            for (let i = 2; i <= num; i++) fact *= i;
            currentInput = String(fact);
            updateDisplay();
        } else {
            currentInput = 'Error';
            updateDisplay();
        }
        return;
    }
    if (value === '1/(') {
        // Reciprocal: 1/(current)
        const num = parseFloat(currentInput);
        if (!isNaN(num) && num !== 0) {
            currentInput = String(1 / num);
            updateDisplay();
        } else {
            currentInput = 'Error';
            updateDisplay();
        }
        return;
    }
    if (value === '^') {
        // x^y: we'll treat as operator ^
        // Store current as previous, set operator to '^'
        if (operator !== null && !shouldResetInput) {
            // Compute previous operation first
            const res = calculate();
            if (res === 'Error' || res === 'Error: Div by 0') {
                currentInput = 'Error';
                updateDisplay();
                operator = null;
                previousInput = '';
                return;
            }
            previousInput = res;
            currentInput = res;
        } else {
            previousInput = currentInput;
        }
        operator = '^';
        shouldResetInput = true;
        updateDisplay();
        return;
    }
    // Functions: sin, cos, etc. they need to be applied to current input
    // We'll apply to current input immediately.
    const funcMap = {
        'sin(': 'Math.sin',
        'cos(': 'Math.cos',
        'tan(': 'Math.tan',
        'log(': 'Math.log10',
        'ln(': 'Math.log',
        '√(': 'Math.sqrt'
    };
    if (funcMap[value]) {
        const num = parseFloat(currentInput);
        if (!isNaN(num) && isFinite(num)) {
            const result = eval(`${funcMap[value]}(${num})`);
            if (typeof result === 'number' && isFinite(result)) {
                currentInput = String(result);
                updateDisplay();
            } else {
                currentInput = 'Error';
                updateDisplay();
            }
        }
        return;
    }
    // Parentheses: just append to current input if not reset
    if (value === '(' || value === ')') {
        // We'll append to current input if not reset
        if (shouldResetInput) {
            currentInput = value;
            shouldResetInput = false;
        } else {
            currentInput += value;
        }
        updateDisplay();
        return;
    }
}

/* ---------- Event Delegation for Buttons ---------- */
buttonGrid.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn');
    if (!btn) return;
    const value = btn.dataset.value;

    if (value === 'AC') {
        clearAll();
    } else if (value === '⌫') {
        deleteLast();
    } else if (value === '%') {
        // Handle percentage as operator if there's a previous input
        // If no pending operator, treat as percent of current
        if (operator === null) {
            percent();
        } else {
            // Treat as operator %
            inputOperator('%');
        }
    } else if (value === '+/-') {
        toggleSign();
    } else if (value === '=') {
        handleEqual();
    } else if (['+', '−', '×', '÷', '//'].includes(value)) {
        inputOperator(value);
    } else if (value === '.') {
        inputDecimal();
    } else if (value >= '0' && value <= '9') {
        inputDigit(value);
    }
});

sciGrid.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-sci');
    if (!btn) return;
    const value = btn.dataset.value;
    inputScientific(value);
});

/* ---------- Keyboard Support ---------- */
document.addEventListener('keydown', function(e) {
    const key = e.key;
    if (key >= '0' && key <= '9') {
        e.preventDefault();
        inputDigit(key);
    } else if (key === '.') {
        e.preventDefault();
        inputDecimal();
    } else if (key === '+') {
        e.preventDefault();
        inputOperator('+');
    } else if (key === '-') {
        e.preventDefault();
        inputOperator('−');
    } else if (key === '*') {
        e.preventDefault();
        inputOperator('×');
    } else if (key === '/') {
        e.preventDefault();
        // Check if Shift+? actually / is /, but we want to differentiate // 
        // We'll treat / as division operator, but if they want //, they can press / twice? Not possible. We'll just treat / as ÷.
        inputOperator('÷');
    } else if (key === '%') {
        e.preventDefault();
        // If no operator, do percent; else operator
        if (operator === null) {
            percent();
        } else {
            inputOperator('%');
        }
    } else if (key === 'Enter' || key === '=') {
        e.preventDefault();
        handleEqual();
    } else if (key === 'Backspace') {
        e.preventDefault();
        deleteLast();
    } else if (key === 'Delete') {
        e.preventDefault();
        clearAll();
    } else if (key === 'Escape') {
        e.preventDefault();
        clearAll();
    } else if (key === '^') {
        e.preventDefault();
        inputOperator('^');
    } else if (key === '(' || key === ')') {
        e.preventDefault();
        inputScientific(key);
    }
    // Additional: for scientific maybe not keyboard
});

/* ---------- Theme Toggle ---------- */
themeToggle.addEventListener('click', function() {
    document.body.classList.toggle('dark');
    isDark = document.body.classList.contains('dark');
    themeToggle.textContent = isDark ? '☀️' : '🌙';
});

/* ---------- History Toggle ---------- */
historyToggle.addEventListener('click', function() {
    historyPanel.classList.toggle('open');
});

/* ---------- Scientific Toggle ---------- */
sciToggle.addEventListener('click', function() {
    sciGrid.classList.toggle('open');
    sciToggle.textContent = sciGrid.classList.contains('open') ? '🔬' : '🔬';
});

/* ---------- Copy Result ---------- */
copyBtn.addEventListener('click', function() {
    const text = resultDisplay.textContent;
    if (text && text !== '0' && text !== 'Error' && !text.includes('Error')) {
        navigator.clipboard.writeText(text).then(() => {
            // Visual feedback
            const original = copyBtn.textContent;
            copyBtn.textContent = '✅ Copied!';
            setTimeout(() => {
                copyBtn.textContent = original;
            }, 1500);
        }).catch(() => {
            alert('Copy not supported');
        });
    } else {
        alert('Nothing to copy');
    }
});

/* ---------- Clear History ---------- */
clearHistoryBtn.addEventListener('click', function() {
    history = [];
    renderHistory();
});

/* ---------- Init ---------- */
updateDisplay();
renderHistory();