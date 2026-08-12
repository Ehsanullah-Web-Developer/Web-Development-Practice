
(function() {
  'use strict';

  // ---------- DOM refs ----------
  const taskInput = document.getElementById('taskInput');
  const dueDateInput = document.getElementById('dueDateInput');
  const prioritySelect = document.getElementById('prioritySelect');
  const categorySelect = document.getElementById('categorySelect');
  const addBtn = document.getElementById('addBtn');
  const taskList = document.getElementById('taskList');
  const searchInput = document.getElementById('searchInput');
  const filterBtns = document.querySelectorAll('.filter-btn');
  const totalCount = document.getElementById('totalCount');
  const completedCount = document.getElementById('completedCount');
  const remainingCount = document.getElementById('remainingCount');
  const progressBar = document.getElementById('progressBar');
  const progressLabel = document.getElementById('progressLabel');
  const clearCompletedBtn = document.getElementById('clearCompletedBtn');
  const deleteAllBtn = document.getElementById('deleteAllBtn');
  const themeToggle = document.getElementById('themeToggle');

  // Modal refs
  const confirmModal = document.getElementById('confirmModal');
  const confirmIcon = document.getElementById('confirmIcon');
  const confirmTitle = document.getElementById('confirmTitle');
  const confirmMessage = document.getElementById('confirmMessage');
  const confirmCancel = document.getElementById('confirmCancel');
  const confirmOk = document.getElementById('confirmOk');

  const successModal = document.getElementById('successModal');
  const successMessage = document.getElementById('successMessage');
  const successOk = document.getElementById('successOk');

  const editModal = document.getElementById('editModal');
  const editTaskName = document.getElementById('editTaskName');
  const editTaskStatus = document.getElementById('editTaskStatus');
  const editTaskPriority = document.getElementById('editTaskPriority');
  const editTaskDueDate = document.getElementById('editTaskDueDate');
  const editTaskCategory = document.getElementById('editTaskCategory');
  const editCancel = document.getElementById('editCancel');
  const editConfirm = document.getElementById('editConfirm');

  const statusModal = document.getElementById('statusModal');
  const statusIcon = document.getElementById('statusIcon');
  const statusMessage = document.getElementById('statusMessage');
  const statusCancel = document.getElementById('statusCancel');
  const statusConfirm = document.getElementById('statusConfirm');

  // ---------- state ----------
  let tasks = [];
  let currentFilter = 'all';
  let searchTerm = '';
  let confirmCallback = null;
  let currentEditTask = null;
  let currentStatusTask = null;
  let currentStatusValue = null;

  const STATUS_MAP = {
    'pending': { label: '⏳ Pending', color: 'status-pending' },
    'in-progress': { label: '🔄 In Progress', color: 'status-in-progress' },
    'completed': { label: '✅ Completed', color: 'status-completed' },
    'on-hold': { label: '⏸️ On Hold', color: 'status-on-hold' },
    'cancelled': { label: '❌ Cancelled', color: 'status-cancelled' }
  };

  const STATUS_CYCLE = ['pending', 'in-progress', 'completed', 'on-hold', 'cancelled'];

  // ---------- Modal Helpers ----------
  function openModal(modal) {
    modal.classList.add('active');
  }

  function closeModal(modal) {
    modal.classList.remove('active');
  }

  function showConfirm(title, message, icon, onConfirm, onCancel) {
    confirmTitle.textContent = title;
    confirmMessage.textContent = message;
    confirmIcon.textContent = icon || '⚠️';
    confirmCallback = onConfirm;
    openModal(confirmModal);

    const handleConfirm = () => {
      closeModal(confirmModal);
      confirmOk.removeEventListener('click', handleConfirm);
      confirmCancel.removeEventListener('click', handleCancel);
      if (onConfirm) onConfirm();
    };

    const handleCancel = () => {
      closeModal(confirmModal);
      confirmOk.removeEventListener('click', handleConfirm);
      confirmCancel.removeEventListener('click', handleCancel);
      if (onCancel) onCancel();
    };

    confirmOk.addEventListener('click', handleConfirm);
    confirmCancel.addEventListener('click', handleCancel);

    // Close on overlay click
    confirmModal.onclick = (e) => {
      if (e.target === confirmModal) handleCancel();
    };
  }

  function showSuccess(message) {
    successMessage.textContent = message;
    openModal(successModal);

    const handleOk = () => {
      closeModal(successModal);
      successOk.removeEventListener('click', handleOk);
    };

    successOk.addEventListener('click', handleOk);

    successModal.onclick = (e) => {
      if (e.target === successModal) handleOk();
    };
  }

  // ---------- load from localStorage ----------
  function loadTasks() {
    const stored = localStorage.getItem('glassTasks');
    if (stored) {
      try {
        tasks = JSON.parse(stored);
        tasks = tasks.map(t => ({
          id: t.id || Date.now() + Math.random(),
          text: t.text || 'untitled',
          completed: t.completed || false,
          status: t.status || (t.completed ? 'completed' : 'pending'),
          priority: t.priority || 'medium',
          dueDate: t.dueDate || '',
          category: t.category || 'other',
        }));
      } catch { tasks = []; }
    } else {
      tasks = [
        { id: 1, text: 'Design glass UI', completed: true, status: 'completed', priority: 'high', dueDate: '2026-07-20', category: 'work' },
        { id: 2, text: 'Write JavaScript logic', completed: false, status: 'in-progress', priority: 'medium', dueDate: '2026-07-18', category: 'study' },
        { id: 3, text: 'Test drag & drop', completed: false, status: 'pending', priority: 'low', dueDate: '', category: 'personal' },
      ];
    }
    saveTasks();
  }

  function saveTasks() {
    localStorage.setItem('glassTasks', JSON.stringify(tasks));
    render();
  }

  // ---------- render ----------
  function render() {
    let filtered = tasks.slice();
    if (currentFilter === 'completed') {
      filtered = filtered.filter(t => t.status === 'completed');
    } else if (currentFilter === 'pending') {
      filtered = filtered.filter(t => t.status !== 'completed');
    }
    if (searchTerm.trim() !== '') {
      const term = searchTerm.trim().toLowerCase();
      filtered = filtered.filter(t => t.text.toLowerCase().includes(term));
    }

    // sort: non-completed first, then by priority, then by due date
    filtered.sort((a, b) => {
      const aDone = a.status === 'completed' || a.status === 'cancelled';
      const bDone = b.status === 'completed' || b.status === 'cancelled';
      if (aDone !== bDone) return aDone ? 1 : -1;
      const prio = { high: 3, medium: 2, low: 1 };
      const diff = prio[b.priority] - prio[a.priority];
      if (diff !== 0) return diff;
      if (a.dueDate && b.dueDate) return a.dueDate.localeCompare(b.dueDate);
      if (a.dueDate) return -1;
      if (b.dueDate) return 1;
      return a.text.localeCompare(b.text);
    });

    taskList.innerHTML = '';

    if (filtered.length === 0) {
      const empty = document.createElement('li');
      empty.className = 'task-item';
      empty.style.justifyContent = 'center';
      empty.style.opacity = '0.5';
      empty.textContent = '✨ no tasks yet';
      taskList.appendChild(empty);
    } else {
      filtered.forEach((task, index) => {
        const li = createTaskElement(task, index);
        taskList.appendChild(li);
      });
    }

    updateStatsAndProgress();
    updateFilterButtons();
  }

  // ---------- create task DOM element ----------
  function createTaskElement(task, index) {
    const li = document.createElement('li');
    li.className = 'task-item';
    li.draggable = true;
    li.dataset.id = task.id;
    li.dataset.index = index;

    // checkbox (toggles completed status)
    const check = document.createElement('input');
    check.type = 'checkbox';
    check.className = 'task-check';
    check.checked = task.status === 'completed';
    check.addEventListener('change', () => {
      const newStatus = check.checked ? 'completed' : 'pending';
      if (newStatus === task.status) return;

      showConfirm(
        'Change Status?',
        `Change status from "${STATUS_MAP[task.status].label}" to "${STATUS_MAP[newStatus].label}"?`,
        '🔄',
        () => {
          task.status = newStatus;
          task.completed = (newStatus === 'completed');
          saveTasks();
          if (task.status === 'completed' && Notification.permission === 'granted') {
            new Notification('✅ Task completed', { body: `"${task.text}" is done!` });
          }
        },
        () => {
          check.checked = task.status === 'completed';
        }
      );
    });

    // text
    const textSpan = document.createElement('span');
    textSpan.className = 'task-text' + (task.status === 'completed' ? ' completed' : '');
    textSpan.textContent = task.text;

    // status badge (clickable to cycle status)
    const statusSpan = document.createElement('span');
    const statusInfo = STATUS_MAP[task.status] || STATUS_MAP['pending'];
    statusSpan.className = 'task-status ' + statusInfo.color;
    statusSpan.textContent = statusInfo.label;
    statusSpan.title = 'Click to change status';
    statusSpan.addEventListener('click', () => {
      const currentIndex = STATUS_CYCLE.indexOf(task.status);
      const nextIndex = (currentIndex + 1) % STATUS_CYCLE.length;
      const nextStatus = STATUS_CYCLE[nextIndex];

      showConfirm(
        'Change Status?',
        `Change status from "${STATUS_MAP[task.status].label}" to "${STATUS_MAP[nextStatus].label}"?`,
        '🔄',
        () => {
          task.status = nextStatus;
          task.completed = (nextStatus === 'completed');
          saveTasks();
          if (task.status === 'completed' && Notification.permission === 'granted') {
            new Notification('✅ Task completed', { body: `"${task.text}" is done!` });
          }
        }
      );
    });

    // priority badge
    const prioritySpan = document.createElement('span');
    prioritySpan.className = 'task-priority';
    const priorityMap = { high: '🔴 High', medium: '🟡 Medium', low: '🟢 Low' };
    prioritySpan.textContent = priorityMap[task.priority] || task.priority;

    // due date
    const dueSpan = document.createElement('span');
    dueSpan.className = 'task-due';
    dueSpan.textContent = task.dueDate ? '📅 ' + task.dueDate : '';

    // category
    const catSpan = document.createElement('span');
    catSpan.className = 'task-category';
    const catMap = { work: '💼 Work', study: '📚 Study', personal: '🧘 Personal', other: '📌 Other' };
    catSpan.textContent = catMap[task.category] || task.category;

    // actions
    const actions = document.createElement('div');
    actions.className = 'task-actions';

    const editBtn = document.createElement('button');
    editBtn.className = 'edit-btn';
    editBtn.textContent = '✏️';
    editBtn.title = 'Edit task';
    editBtn.addEventListener('click', () => openEditModal(task));

    const deleteBtn = document.createElement('button');
    deleteBtn.className = 'delete-btn';
    deleteBtn.textContent = '🗑️';
    deleteBtn.title = 'Delete task';
    deleteBtn.addEventListener('click', () => {
      showConfirm(
        'Delete Task?',
        `Are you sure you want to delete "${task.text}"? This action cannot be undone.`,
        '🗑️',
        () => {
          tasks = tasks.filter(t => t.id !== task.id);
          saveTasks();
        }
      );
    });

    actions.appendChild(editBtn);
    actions.appendChild(deleteBtn);

    li.appendChild(check);
    li.appendChild(textSpan);
    li.appendChild(statusSpan);
    li.appendChild(prioritySpan);
    li.appendChild(dueSpan);
    li.appendChild(catSpan);
    li.appendChild(actions);

    // drag & drop events
    li.addEventListener('dragstart', handleDragStart);
    li.addEventListener('dragend', handleDragEnd);
    li.addEventListener('dragover', handleDragOver);
    li.addEventListener('drop', handleDrop);

    return li;
  }

  // ---------- Edit Modal ----------
  function openEditModal(task) {
    currentEditTask = task;
    editTaskName.value = task.text;
    editTaskStatus.value = task.status;
    editTaskPriority.value = task.priority;
    editTaskDueDate.value = task.dueDate;
    editTaskCategory.value = task.category;
    openModal(editModal);
  }

  function closeEditModal() {
    closeModal(editModal);
    currentEditTask = null;
  }

  function saveEditChanges() {
    if (!currentEditTask) return;

    const newName = editTaskName.value.trim();
    if (newName === '') {
      showConfirm('Empty Task Name', 'Task name cannot be empty. Please enter a valid name.', '⚠️',
        () => {}, () => {}
      );
      return;
    }

    const oldStatus = currentEditTask.status;
    const newStatus = editTaskStatus.value;

    // If status changed, show confirmation
    if (oldStatus !== newStatus) {
      showConfirm(
        'Confirm Status Change',
        `You are changing status from "${STATUS_MAP[oldStatus].label}" to "${STATUS_MAP[newStatus].label}". Proceed?`,
        '🔄',
        () => {
          applyEditChanges(newName, newStatus);
        }
      );
    } else {
      applyEditChanges(newName, newStatus);
    }
  }

  function applyEditChanges(newName, newStatus) {
    currentEditTask.text = newName;
    currentEditTask.status = newStatus;
    currentEditTask.completed = (newStatus === 'completed');
    currentEditTask.priority = editTaskPriority.value;
    currentEditTask.dueDate = editTaskDueDate.value;
    currentEditTask.category = editTaskCategory.value;
    saveTasks();
    closeEditModal();
    showSuccess(`Task "${newName}" updated successfully!`);
  }

  editCancel.addEventListener('click', closeEditModal);
  editConfirm.addEventListener('click', saveEditChanges);

  editModal.onclick = (e) => {
    if (e.target === editModal) closeEditModal();
  };

  // Enter key in edit modal
  editTaskName.addEventListener('keypress', e => { if (e.key === 'Enter') saveEditChanges(); });

  // ---------- drag & drop ----------
  let draggedId = null;

  function handleDragStart(e) {
    draggedId = this.dataset.id;
    this.classList.add('dragging');
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/plain', this.dataset.id);
  }

  function handleDragEnd(e) {
    this.classList.remove('dragging');
    document.querySelectorAll('.task-item').forEach(el => el.classList.remove('drag-over'));
  }

  function handleDragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
    this.classList.add('drag-over');
  }

  function handleDrop(e) {
    e.preventDefault();
    this.classList.remove('drag-over');
    const targetId = this.dataset.id;
    if (draggedId && draggedId !== targetId) {
      const draggedIndex = tasks.findIndex(t => t.id == draggedId);
      const targetIndex = tasks.findIndex(t => t.id == targetId);
      if (draggedIndex !== -1 && targetIndex !== -1) {
        const [moved] = tasks.splice(draggedIndex, 1);
        tasks.splice(targetIndex, 0, moved);
        saveTasks();
      }
    }
    draggedId = null;
  }

  // ---------- stats & progress ----------
  function updateStatsAndProgress() {
    const total = tasks.length;
    const completed = tasks.filter(t => t.status === 'completed').length;
    const remaining = total - completed;
    totalCount.textContent = total;
    completedCount.textContent = completed;
    remainingCount.textContent = remaining;
    const pct = total === 0 ? 0 : Math.round((completed / total) * 100);
    progressBar.style.width = pct + '%';
    progressLabel.textContent = pct + '% completed';
  }

  // ---------- filter buttons ----------
  function updateFilterButtons() {
    filterBtns.forEach(btn => {
      btn.classList.toggle('active', btn.dataset.filter === currentFilter);
    });
  }

  // ---------- add task ----------
  function addTask() {
    const text = taskInput.value.trim();
    if (text === '') {
      showConfirm('Empty Task', 'Please enter a task name before adding.', '⚠️', () => {}, () => {});
      return;
    }

    showConfirm(
      'Add New Task?',
      `Are you sure you want to add the task: "${text}"?`,
      '📌',
      () => {
        const dueDate = dueDateInput.value;
        const priority = prioritySelect.value;
        const category = categorySelect.value;
        const newTask = {
          id: Date.now() + Math.random(),
          text,
          completed: false,
          status: 'pending',
          priority,
          dueDate,
          category,
        };
        tasks.push(newTask);
        saveTasks();
        taskInput.value = '';
        dueDateInput.value = '';

        showSuccess(`Task "${text}" has been added successfully!`);

        if (Notification.permission === 'default') {
          Notification.requestPermission();
        }
        if (Notification.permission === 'granted') {
          new Notification('📌 New task added', { body: `"${text}"` });
        }
      }
    );
  }

  // ---------- clear completed ----------
  function clearCompleted() {
    const completedTasks = tasks.filter(t => t.status === 'completed');
    if (completedTasks.length === 0) {
      showConfirm('No Completed Tasks', 'There are no completed tasks to clear.', 'ℹ️', () => {}, () => {});
      return;
    }
    showConfirm(
      'Clear Completed Tasks?',
      `Delete ${completedTasks.length} completed task(s)? This action cannot be undone.`,
      '🧹',
      () => {
        tasks = tasks.filter(t => t.status !== 'completed');
        saveTasks();
        showSuccess(`${completedTasks.length} completed task(s) cleared!`);
      }
    );
  }

  // ---------- delete all ----------
  function deleteAll() {
    if (tasks.length === 0) {
      showConfirm('No Tasks', 'There are no tasks to delete.', 'ℹ️', () => {}, () => {});
      return;
    }
    showConfirm(
      'Delete ALL Tasks?',
      `⚠️ This will permanently delete all ${tasks.length} task(s). This action cannot be undone. Are you absolutely sure?`,
      '⚠️',
      () => {
        tasks = [];
        saveTasks();
        showSuccess('All tasks have been deleted.');
      }
    );
  }

  // ---------- theme toggle ----------
  function toggleTheme() {
    document.body.classList.toggle('light');
    const isLight = document.body.classList.contains('light');
    themeToggle.textContent = isLight ? '☀️' : '🌙';
    localStorage.setItem('glassTheme', isLight ? 'light' : 'dark');
  }

  function loadTheme() {
    const stored = localStorage.getItem('glassTheme');
    if (stored === 'light') {
      document.body.classList.add('light');
      themeToggle.textContent = '☀️';
    } else {
      document.body.classList.remove('light');
      themeToggle.textContent = '🌙';
    }
  }

  // ---------- event listeners ----------
  addBtn.addEventListener('click', addTask);
  taskInput.addEventListener('keypress', e => { if (e.key === 'Enter') addTask(); });

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      currentFilter = btn.dataset.filter;
      render();
    });
  });

  searchInput.addEventListener('input', () => {
    searchTerm = searchInput.value;
    render();
  });

  clearCompletedBtn.addEventListener('click', clearCompleted);
  deleteAllBtn.addEventListener('click', deleteAll);
  themeToggle.addEventListener('click', toggleTheme);

  // ---------- init ----------
  loadTheme();
  loadTasks();

  if (Notification.permission === 'default') {
    Notification.requestPermission();
  }

})();