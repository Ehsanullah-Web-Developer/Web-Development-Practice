// script.js – complete logic with vibrant charts and improved sample data

document.addEventListener('DOMContentLoaded', () => {
  // ---------- state ----------
  let transactions = JSON.parse(localStorage.getItem('flowwise_tx')) || [];
  let currencyCode = 'PKR';
  let budgetLimit = parseFloat(localStorage.getItem('flowwise_budget')) || 0;

  // DOM refs
  const txList = document.getElementById('transactionList');
  const totalBalanceEl = document.getElementById('totalBalance');
  const totalIncomeEl = document.getElementById('totalIncome');
  const totalExpensesEl = document.getElementById('totalExpenses');
  const txCount = document.getElementById('txCount');
  const form = document.getElementById('transactionForm');
  const titleInp = document.getElementById('txTitle');
  const amountInp = document.getElementById('txAmount');
  const typeSelect = document.getElementById('txType');
  const categorySelect = document.getElementById('txCategory');
  const dateInp = document.getElementById('txDate');
  const searchInp = document.getElementById('searchInput');
  const filterType = document.getElementById('filterType');
  const filterCategory = document.getElementById('filterCategory');
  const filterDate = document.getElementById('filterDate');
  const clearFilters = document.getElementById('clearFilters');
  const deleteAllBtn = document.getElementById('deleteAllBtn');
  const downloadBtn = document.getElementById('downloadBtn');
  const printBtn = document.getElementById('printBtn');
  const themeToggle = document.getElementById('themeToggle');
  const sortSelect = document.getElementById('sortSelect');
  const modalOverlay = document.getElementById('modalOverlay');
  const modalContent = document.getElementById('modalContent');
  const currencySelect = document.getElementById('currencySelect');
  const budgetInput = document.getElementById('budgetLimit');
  const setBudgetBtn = document.getElementById('setBudgetBtn');
  const budgetStatus = document.getElementById('budgetStatus');

  // ---------- theme persistence ----------
  const savedTheme = localStorage.getItem('flowwise_theme');
  if (savedTheme === 'dark') {
    document.body.classList.add('dark');
    themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
  }
  themeToggle.addEventListener('click', () => {
    document.body.classList.toggle('dark');
    const isDark = document.body.classList.contains('dark');
    themeToggle.innerHTML = isDark ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
    localStorage.setItem('flowwise_theme', isDark ? 'dark' : 'light');
  });

  // ---------- helpers ----------
  function formatCurrency(amount) {
    return currencyCode + ' ' + Number(amount).toFixed(0);
  }

  // All predefined categories
  const INCOME_CATEGORIES = ['Salary', 'Business', 'Freelance', 'Gift', 'Other'];
  const EXPENSE_CATEGORIES = ['Food', 'Transport', 'Shopping', 'Bills', 'Education', 'Entertainment', 'Health', 'Others'];
  const ALL_CATEGORIES = [...INCOME_CATEGORIES, ...EXPENSE_CATEGORIES];

  function getCategories(type) {
    return type === 'income' ? INCOME_CATEGORIES : EXPENSE_CATEGORIES;
  }

  function populateCategories(selectEl, type) {
    const cats = getCategories(type);
    selectEl.innerHTML = cats.map(c => `<option value="${c}">${c}</option>`).join('');
  }

  // initial categories
  populateCategories(categorySelect, 'expense');

  typeSelect.addEventListener('change', () => {
    populateCategories(categorySelect, typeSelect.value);
  });

  function getDefaultDate() {
    return new Date().toISOString().split('T')[0];
  }
  dateInp.value = getDefaultDate();

  // ---------- sorting ----------
  function sortTransactions(list, sortKey) {
    const copy = [...list];
    switch (sortKey) {
      case 'date-desc':
        return copy.sort((a, b) => new Date(b.date) - new Date(a.date));
      case 'date-asc':
        return copy.sort((a, b) => new Date(a.date) - new Date(b.date));
      case 'amount-desc':
        return copy.sort((a, b) => b.amount - a.amount);
      case 'amount-asc':
        return copy.sort((a, b) => a.amount - b.amount);
      default:
        return copy;
    }
  }

  // ---------- update dashboard & storage ----------
  function updateDashboard() {
    const totalIncome = transactions.filter(t => t.type === 'income').reduce((s, t) => s + t.amount, 0);
    const totalExpense = transactions.filter(t => t.type === 'expense').reduce((s, t) => s + t.amount, 0);
    const balance = totalIncome - totalExpense;
    totalBalanceEl.textContent = formatCurrency(balance);
    totalIncomeEl.textContent = formatCurrency(totalIncome);
    totalExpensesEl.textContent = formatCurrency(totalExpense);
    txCount.textContent = transactions.length;

    // budget warning
    if (budgetLimit > 0 && totalExpense > budgetLimit) {
      budgetStatus.innerHTML = `<span style="color:var(--expense);">⚠️ Over budget! (${formatCurrency(totalExpense)} / ${formatCurrency(budgetLimit)})</span>`;
    } else if (budgetLimit > 0) {
      budgetStatus.innerHTML = `✅ Under budget: ${formatCurrency(totalExpense)} / ${formatCurrency(budgetLimit)}`;
    } else {
      budgetStatus.textContent = 'No budget set';
    }

    localStorage.setItem('flowwise_tx', JSON.stringify(transactions));
    updateCharts();
    populateFilterCategories();
  }

  // ---------- render list with filters and sorting ----------
  function renderTransactions() {
    let list = [...transactions];

    // search
    const search = searchInp.value.toLowerCase().trim();
    if (search) {
      list = list.filter(t => t.title.toLowerCase().includes(search) || t.category.toLowerCase().includes(search));
    }
    // type filter
    const type = filterType.value;
    if (type !== 'all') list = list.filter(t => t.type === type);
    // category filter
    const cat = filterCategory.value;
    if (cat !== 'all') list = list.filter(t => t.category === cat);
    // date filter
    const date = filterDate.value;
    if (date) list = list.filter(t => t.date === date);

    // sorting
    const sortKey = sortSelect.value;
    list = sortTransactions(list, sortKey);

    if (!list.length) {
      txList.innerHTML = `<div class="tx-item" style="justify-content:center; color: var(--text-secondary);">No transactions found</div>`;
      return;
    }

    txList.innerHTML = list.map((t, idx) => {
      const realIdx = transactions.indexOf(t);
      return `<div class="tx-item" data-idx="${realIdx}">
        <div class="tx-info">
          <span class="tx-title">${t.title}</span>
          <span class="tx-category">${t.category}</span>
          <span class="tx-date">${t.date}</span>
          <span class="tx-amount ${t.type}">${t.type === 'income' ? '+' : '-'} ${formatCurrency(t.amount)}</span>
        </div>
        <div class="tx-actions">
          <button class="btn outline small edit-btn" data-idx="${realIdx}"><i class="fas fa-edit"></i></button>
          <button class="btn danger small delete-btn" data-idx="${realIdx}"><i class="fas fa-trash"></i></button>
        </div>
      </div>`;
    }).join('');

    // attach events
    document.querySelectorAll('.delete-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const idx = parseInt(btn.dataset.idx);
        showDeleteModal(idx);
      });
    });
    document.querySelectorAll('.edit-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const idx = parseInt(btn.dataset.idx);
        showEditModal(idx);
      });
    });
  }

  // ---------- modal system ----------
  function openModal(html) {
    modalContent.innerHTML = html;
    modalOverlay.classList.remove('hidden');
  }
  function closeModal() {
    modalOverlay.classList.add('hidden');
  }

  // delete modal
  function showDeleteModal(idx) {
    const tx = transactions[idx];
    if (!tx) return;
    openModal(`
      <h3><i class="fas fa-trash-alt" style="color:var(--expense);"></i> Delete Transaction</h3>
      <p>Are you sure you want to delete "<strong>${tx.title}</strong>" (${formatCurrency(tx.amount)})?</p>
      <div class="modal-actions">
        <button class="btn outline" id="modalCancel">Cancel</button>
        <button class="btn danger" id="modalConfirm">Confirm Delete</button>
      </div>
    `);
    document.getElementById('modalCancel').addEventListener('click', closeModal);
    document.getElementById('modalConfirm').addEventListener('click', () => {
      transactions.splice(idx, 1);
      closeModal();
      updateDashboard();
      renderTransactions();
      showToast('🗑️ Transaction deleted.');
    });
  }

  // edit modal
  function showEditModal(idx) {
    const tx = transactions[idx];
    if (!tx) return;
    const cats = getCategories(tx.type).map(c => `<option value="${c}" ${c===tx.category?'selected':''}>${c}</option>`).join('');
    openModal(`
      <h3><i class="fas fa-edit"></i> Edit Transaction</h3>
      <form id="editForm">
        <div class="input-group"><label>Title</label><input type="text" id="editTitle" value="${tx.title}" required /></div>
        <div class="input-group"><label>Amount</label><input type="number" id="editAmount" value="${tx.amount}" step="0.01" required /></div>
        <div class="input-group"><label>Type</label>
          <select id="editType">
            <option value="income" ${tx.type==='income'?'selected':''}>Income</option>
            <option value="expense" ${tx.type==='expense'?'selected':''}>Expense</option>
          </select>
        </div>
        <div class="input-group"><label>Category</label><select id="editCategory">${cats}</select></div>
        <div class="input-group"><label>Date</label><input type="date" id="editDate" value="${tx.date}" /></div>
        <div class="modal-actions">
          <button type="button" class="btn outline" id="editCancel">Cancel</button>
          <button type="submit" class="btn primary">Save Changes</button>
        </div>
      </form>
    `);
    const editType = document.getElementById('editType');
    const editCategory = document.getElementById('editCategory');
    editType.addEventListener('change', () => {
      populateCategories(editCategory, editType.value);
    });

    document.getElementById('editCancel').addEventListener('click', closeModal);
    document.getElementById('editForm').addEventListener('submit', (e) => {
      e.preventDefault();
      const newTitle = document.getElementById('editTitle').value.trim();
      const newAmount = parseFloat(document.getElementById('editAmount').value);
      const newType = document.getElementById('editType').value;
      const newCategory = document.getElementById('editCategory').value;
      const newDate = document.getElementById('editDate').value || getDefaultDate();
      if (!newTitle || !newAmount) return alert('Please fill all fields.');
      transactions[idx] = { title: newTitle, amount: newAmount, type: newType, category: newCategory, date: newDate };
      closeModal();
      updateDashboard();
      renderTransactions();
      showToast('✅ Transaction updated.');
    });
  }

  // delete all modal
  function showDeleteAllModal() {
    openModal(`
      <h3><i class="fas fa-exclamation-triangle" style="color:var(--expense);"></i> Delete All Transactions</h3>
      <p>This will permanently remove all transactions. Are you sure?</p>
      <div class="modal-actions">
        <button class="btn outline" id="modalCancel">Cancel</button>
        <button class="btn danger" id="modalConfirm">Delete All</button>
      </div>
    `);
    document.getElementById('modalCancel').addEventListener('click', closeModal);
    document.getElementById('modalConfirm').addEventListener('click', () => {
      transactions = [];
      closeModal();
      // After clearing, generate fresh sample data
      generateSampleData();
      updateDashboard();
      renderTransactions();
      showToast('🗑️ All transactions deleted. Sample data added.');
    });
  }

  // toast
  function showToast(msg) {
    const toast = document.createElement('div');
    toast.style.cssText = `position:fixed; bottom:20px; left:50%; transform:translateX(-50%); background:var(--surface); color:var(--text); padding:0.8rem 2rem; border-radius:60px; box-shadow:0 10px 30px rgba(0,0,0,0.2); border:1px solid var(--border); z-index:1000; font-weight:500; transition:0.3s;`;
    toast.textContent = msg;
    document.body.appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 400); }, 2000);
  }

  // ---------- add transaction ----------
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const title = titleInp.value.trim();
    const amount = parseFloat(amountInp.value);
    const type = typeSelect.value;
    const category = categorySelect.value;
    const date = dateInp.value || getDefaultDate();
    if (!title || !amount || amount <= 0) return alert('Please fill all fields.');
    transactions.push({ title, amount, type, category, date });
    form.reset();
    dateInp.value = getDefaultDate();
    updateDashboard();
    renderTransactions();
    showToast('✅ Transaction added.');
  });

  // ---------- search, filter, sort events ----------
  searchInp.addEventListener('input', renderTransactions);
  filterType.addEventListener('change', renderTransactions);
  filterCategory.addEventListener('change', renderTransactions);
  filterDate.addEventListener('change', renderTransactions);
  sortSelect.addEventListener('change', renderTransactions);

  clearFilters.addEventListener('click', () => {
    searchInp.value = '';
    filterType.value = 'all';
    filterCategory.value = 'all';
    filterDate.value = '';
    renderTransactions();
  });

  // populate filter categories with ALL predefined categories
  function populateFilterCategories() {
    filterCategory.innerHTML = `<option value="all">All Categories</option>` + 
      ALL_CATEGORIES.map(c => `<option value="${c}">${c}</option>`).join('');
  }

  // ---------- delete all ----------
  deleteAllBtn.addEventListener('click', showDeleteAllModal);

  // ---------- download & print ----------
  function getTransactionText() {
    return transactions.map(t => `${t.title} | ${t.category} | ${t.date} | ${t.type} | ${formatCurrency(t.amount)}`).join('\n');
  }
  downloadBtn.addEventListener('click', () => {
    const blob = new Blob([getTransactionText()], { type: 'text/plain' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'transactions.txt';
    a.click();
  });
  printBtn.addEventListener('click', () => {
    const win = window.open('', '_blank');
    win.document.write(`<pre>${getTransactionText()}</pre>`);
    win.document.close();
    win.print();
  });

  // ---------- currency ----------
  currencySelect.addEventListener('change', () => {
    currencyCode = currencySelect.value;
    updateDashboard();
    renderTransactions();
  });

  // ---------- budget ----------
  setBudgetBtn.addEventListener('click', () => {
    const val = parseFloat(budgetInput.value);
    if (!isNaN(val) && val > 0) {
      budgetLimit = val;
      localStorage.setItem('flowwise_budget', val);
      updateDashboard();
      showToast('💰 Budget set.');
    } else {
      alert('Enter a valid amount');
    }
  });

  // ---------- charts (canvas) – now with multiple colors & variable bars ----------
  function updateCharts() {
    drawPie();
    drawBar();
  }

  function drawPie() {
    const canvas = document.getElementById('pieChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Aggregate expenses by category
    const exp = transactions.filter(t => t.type === 'expense');
    const catMap = {};
    exp.forEach(t => { catMap[t.category] = (catMap[t.category] || 0) + t.amount; });

    // Include all expense categories, even if zero
    const allExpenseCategories = EXPENSE_CATEGORIES;
    const labels = allExpenseCategories;
    const data = labels.map(cat => catMap[cat] || 0);

    const total = data.reduce((a,b) => a+b, 0);
    if (total === 0) {
      ctx.fillStyle = '#888';
      ctx.font = '12px Inter';
      ctx.fillText('No expense data', 30, 100);
      return;
    }

    // Vibrant color palette (one per category)
    const colors = ['#f97316', '#8b5cf6', '#06b6d4', '#22c55e', '#eab308', '#ef4444', '#ec4899', '#6366f1'];
    let start = -Math.PI/2;
    data.forEach((val, i) => {
      const angle = (val / total) * 2 * Math.PI;
      ctx.beginPath();
      ctx.moveTo(100, 100);
      ctx.arc(100, 100, 80, start, start + angle);
      ctx.closePath();
      ctx.fillStyle = colors[i % colors.length];
      ctx.fill();
      start += angle;
    });

    // Legend with values
    ctx.font = '10px Inter';
    labels.forEach((l, i) => {
      const val = data[i];
      if (val > 0) { // only show categories that have expenses
        ctx.fillStyle = colors[i % colors.length];
        ctx.fillRect(10, 10 + (labels.filter((_, idx) => data[idx] > 0).indexOf(l) * 16), 10, 10);
        ctx.fillStyle = '#333';
        ctx.fillText(`${l} (${formatCurrency(val)})`, 24, 18 + (labels.filter((_, idx) => data[idx] > 0).indexOf(l) * 16));
      }
    });
  }

  function drawBar() {
    const canvas = document.getElementById('barChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    const exp = transactions.filter(t => t.type === 'expense');
    if (!exp.length) {
      ctx.fillStyle = '#888';
      ctx.font = '12px Inter';
      ctx.fillText('No spending data', 30, 80);
      return;
    }

    // Aggregate by month (all months with data)
    const monthly = {};
    exp.forEach(t => {
      const m = t.date.slice(0,7);
      monthly[m] = (monthly[m] || 0) + t.amount;
    });
    const sortedMonths = Object.keys(monthly).sort();
    const data = sortedMonths.map(m => monthly[m]);
    const max = Math.max(...data, 1);
    const barWidth = 28;
    const gap = (canvas.width - 20 - barWidth * data.length) / (data.length + 1);
    const baseY = 140;
    const maxHeight = 120;

    // Different color gradient for each bar to make it variable
    const colors = ['#2563eb', '#7c3aed', '#db2777', '#dc2626', '#ea580c', '#ca8a04', '#16a34a', '#0d9488'];
    data.forEach((val, i) => {
      const x = 10 + gap + i * (barWidth + gap);
      const height = (val / max) * maxHeight;
      const y = baseY - height;
      // Use a gradient or distinct color
      const grad = ctx.createLinearGradient(x, y, x, baseY);
      const col = colors[i % colors.length];
      grad.addColorStop(0, col);
      grad.addColorStop(1, col + '88'); // lighter version
      ctx.fillStyle = grad;
      ctx.shadowColor = 'rgba(0,0,0,0.2)';
      ctx.shadowBlur = 6;
      ctx.fillRect(x, y, barWidth, height);
      ctx.shadowBlur = 0;
      ctx.fillStyle = '#333';
      ctx.font = '8px Inter';
      ctx.textAlign = 'center';
      ctx.fillText(sortedMonths[i] || '', x + barWidth/2, baseY + 14);
      ctx.fillStyle = '#2563eb';
      ctx.font = 'bold 8px Inter';
      ctx.fillText(formatCurrency(val), x + barWidth/2, y - 4);
    });
  }

  // ---------- sample data generation (vibrant and variable) ----------
  function generateSampleData() {
    if (transactions.length > 0) return; // only if empty

    const now = new Date();
    const categories = ['Food', 'Transport', 'Shopping', 'Bills', 'Entertainment', 'Health', 'Education', 'Others'];
    const titles = ['Lunch', 'Bus pass', 'New phone', 'Electricity bill', 'Movie night', 'Pharmacy', 'Online course', 'Misc'];

    // Generate 3 transactions per month for the last 3 months, using different categories
    for (let monthOffset = 0; monthOffset < 4; monthOffset++) {
      const monthDate = new Date(now);
      monthDate.setMonth(monthDate.getMonth() - monthOffset);
      for (let i = 0; i < 2; i++) {
        const day = 5 + i * 10;
        monthDate.setDate(day);
        const catIndex = (monthOffset * 2 + i) % categories.length;
        const amount = (Math.floor(Math.random() * 60) + 20) * 10; // 200–800
        transactions.push({
          title: titles[catIndex] + ' ' + (monthOffset + 1),
          amount: amount,
          type: 'expense',
          category: categories[catIndex],
          date: monthDate.toISOString().split('T')[0]
        });
      }
    }

    // Add two income transactions
    transactions.push({
      title: 'Salary',
      amount: 50000,
      type: 'income',
      category: 'Salary',
      date: new Date(now.getFullYear(), now.getMonth(), 1).toISOString().split('T')[0]
    });
    transactions.push({
      title: 'Freelance',
      amount: 15000,
      type: 'income',
      category: 'Freelance',
      date: new Date(now.getFullYear(), now.getMonth() - 1, 15).toISOString().split('T')[0]
    });

    localStorage.setItem('flowwise_tx', JSON.stringify(transactions));
  }

  // ---------- init ----------
  generateSampleData(); // adds rich sample data if empty
  document.getElementById('currentDate').textContent = new Date().toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' });
  if (budgetLimit > 0) {
    budgetInput.value = budgetLimit;
  }
  updateDashboard();
  renderTransactions();
  currencySelect.value = 'PKR';
  sortSelect.value = 'date-desc';
});