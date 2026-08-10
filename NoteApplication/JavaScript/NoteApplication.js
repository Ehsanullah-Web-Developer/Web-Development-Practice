// ========== STATE ==========
let notes = [];
let editingId = null;
let deletingId = null;
let isDeleteAllMode = false;
let selectedColor = '#ffffff';
let selectedEditColor = '#ffffff';

// ========== DOM REFS ==========
const notesGrid = document.getElementById('notesGrid');
const emptyState = document.getElementById('emptyState');
const searchInput = document.getElementById('searchInput');
const themeToggle = document.getElementById('themeToggle');
const addBtn = document.getElementById('addNoteBtn');
const noteTitle = document.getElementById('noteTitle');
const noteDesc = document.getElementById('noteDescription');
const noteCategory = document.getElementById('noteCategory');
const wordCounter = document.getElementById('wordCounter');
const sortSelect = document.getElementById('sortSelect');
const deleteAllBtn = document.getElementById('deleteAllBtn');
const toast = document.getElementById('toast');
const toastMsg = document.getElementById('toastMessage');

// Modals
const editModal = document.getElementById('editModal');
const editTitle = document.getElementById('editTitle');
const editDesc = document.getElementById('editDescription');
const editCategory = document.getElementById('editCategory');
const editCancel = document.getElementById('editCancelBtn');
const editSave = document.getElementById('editSaveBtn');
const deleteModal = document.getElementById('deleteModal');
const deleteCancel = document.getElementById('deleteCancelBtn');
const deleteConfirm = document.getElementById('deleteConfirmBtn');
const deleteAllModal = document.getElementById('deleteAllModal');
const deleteAllCancel = document.getElementById('deleteAllCancelBtn');
const deleteAllConfirm = document.getElementById('deleteAllConfirmBtn');

// Color pickers
const colorDots = document.querySelectorAll('.color-picker:not(.modal-color-picker) .color-dot');
const editColorDots = document.querySelectorAll('.modal-color-picker .color-dot');

// ========== INIT ==========
document.addEventListener('DOMContentLoaded', () => {
  loadNotes();
  renderNotes();
  applyThemeFromStorage();
  setupEventListeners();
  updateWordCounter();
});

// ========== LOCAL STORAGE ==========
function loadNotes() {
  const stored = localStorage.getItem('notesVault');
  notes = stored ? JSON.parse(stored) : [];
}

function saveNotes() {
  localStorage.setItem('notesVault', JSON.stringify(notes));
}

// ========== RENDER ==========
function renderNotes() {
  const query = searchInput.value.trim().toLowerCase();
  let filtered = notes.filter(n => {
    const titleMatch = n.title.toLowerCase().includes(query);
    const descMatch = n.description.toLowerCase().includes(query);
    return titleMatch || descMatch;
  });

  // Sort
  const sortVal = sortSelect.value;
  if (sortVal === 'title') {
    filtered.sort((a, b) => a.title.localeCompare(b.title));
  } else if (sortVal === 'updated') {
    filtered.sort((a, b) => b.updatedAt - a.updatedAt);
  } else { // date
    filtered.sort((a, b) => b.createdAt - a.createdAt);
  }

  // Pinned first
  const pinned = filtered.filter(n => n.pinned);
  const unpinned = filtered.filter(n => !n.pinned);
  const sorted = [...pinned, ...unpinned];

  if (sorted.length === 0) {
    notesGrid.innerHTML = '';
    emptyState.classList.add('visible');
    return;
  }
  emptyState.classList.remove('visible');

  notesGrid.innerHTML = sorted.map(note => {
    const isFavorite = note.favorite || false;
    const isPinned = note.pinned || false;
    const color = note.color || '#ffffff';
    const category = note.category || 'Personal';
    const created = new Date(note.createdAt).toLocaleString();
    const updated = new Date(note.updatedAt).toLocaleString();

    // sanitize description (allow HTML from contenteditable)
    const descHtml = note.description || '';

    return `
      <div class="note-card" style="background:${color}; ${color !== '#ffffff' ? 'border-color:'+color : ''}" data-id="${note.id}">
        <div class="card-header">
          <div class="card-title">${escapeHtml(note.title) || 'Untitled'}</div>
          <div class="card-actions">
            <button class="pin-btn ${isPinned ? 'active' : ''}" data-action="pin" title="Pin">📌</button>
            <button class="favorite-btn ${isFavorite ? 'active' : ''}" data-action="favorite" title="Favorite">⭐</button>
            <button data-action="edit" title="Edit">✏️</button>
            <button data-action="delete" title="Delete">🗑️</button>
            <button data-action="download" title="Download as .txt">⬇️</button>
          </div>
        </div>
        <div class="card-desc">${descHtml}</div>
        <div class="card-meta">
          <span class="badge">${category}</span>
          <div class="date-group">
            <span>📅 ${created}</span>
            <span style="font-size:0.65rem;">🔄 ${updated}</span>
          </div>
        </div>
        <div class="card-footer-extra">
          <span></span>
          <button class="download-btn" data-action="download">Download .txt</button>
        </div>
      </div>
    `;
  }).join('');

  // Attach event listeners to card buttons
  document.querySelectorAll('.note-card').forEach(card => {
    const id = card.dataset.id;
    card.querySelectorAll('[data-action]').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const action = btn.dataset.action;
        if (action === 'edit') handleEdit(id);
        else if (action === 'delete') handleDelete(id);
        else if (action === 'pin') togglePin(id);
        else if (action === 'favorite') toggleFavorite(id);
        else if (action === 'download') downloadNote(id);
      });
    });
  });
}

// ========== HELPERS ==========
function escapeHtml(unsafe) {
  if (!unsafe) return '';
  return unsafe.replace(/[&<>"]/g, function(m) {
    if (m === '&') return '&amp;';
    if (m === '<') return '&lt;';
    if (m === '>') return '&gt;';
    if (m === '"') return '&quot;';
    return m;
  });
}

function generateId() {
  return Date.now().toString(36) + Math.random().toString(36).slice(2);
}

function showToast(message, icon = '✅') {
  toastMsg.textContent = message;
  toast.querySelector('.toast-icon').textContent = icon;
  toast.classList.add('show');
  clearTimeout(toast._timer);
  toast._timer = setTimeout(() => toast.classList.remove('show'), 3000);
}

// ========== CRUD OPERATIONS ==========
function addNote() {
  const title = noteTitle.value.trim();
  const description = noteDesc.innerHTML.trim();
  const category = noteCategory.value;
  const color = selectedColor;

  if (!title && !description) {
    showToast('Please add a title or description.', '⚠️');
    return;
  }

  const newNote = {
    id: generateId(),
    title: title || 'Untitled',
    description: description || '',
    category,
    color,
    pinned: false,
    favorite: false,
    createdAt: Date.now(),
    updatedAt: Date.now()
  };

  notes.push(newNote);
  saveNotes();
  renderNotes();
  noteTitle.value = '';
  noteDesc.innerHTML = '';
  noteCategory.value = 'Personal';
  selectedColor = '#ffffff';
  updateColorPickerUI();
  updateWordCounter();
  showToast('Note added successfully!', '✅');
}

function handleEdit(id) {
  const note = notes.find(n => n.id === id);
  if (!note) return;
  editingId = id;
  editTitle.value = note.title;
  editDesc.innerHTML = note.description;
  editCategory.value = note.category;
  // set color
  selectedEditColor = note.color || '#ffffff';
  updateEditColorPickerUI();
  editModal.classList.add('open');
}

function saveEdit() {
  if (!editingId) return;
  const title = editTitle.value.trim();
  const description = editDesc.innerHTML.trim();
  const category = editCategory.value;
  const color = selectedEditColor;

  if (!title && !description) {
    showToast('Title or description required.', '⚠️');
    return;
  }

  const note = notes.find(n => n.id === editingId);
  if (note) {
    note.title = title || 'Untitled';
    note.description = description || '';
    note.category = category;
    note.color = color;
    note.updatedAt = Date.now();
    saveNotes();
    renderNotes();
    closeEditModal();
    showToast('Note updated successfully!', '✅');
  }
}

function closeEditModal() {
  editModal.classList.remove('open');
  editingId = null;
}

function handleDelete(id) {
  deletingId = id;
  deleteModal.classList.add('open');
}

function confirmDelete() {
  if (deletingId) {
    notes = notes.filter(n => n.id !== deletingId);
    saveNotes();
    renderNotes();
    deleteModal.classList.remove('open');
    deletingId = null;
    showToast('Note deleted.', '🗑️');
  }
}

function cancelDelete() {
  deleteModal.classList.remove('open');
  deletingId = null;
}

function togglePin(id) {
  const note = notes.find(n => n.id === id);
  if (note) {
    note.pinned = !note.pinned;
    note.updatedAt = Date.now();
    saveNotes();
    renderNotes();
  }
}

function toggleFavorite(id) {
  const note = notes.find(n => n.id === id);
  if (note) {
    note.favorite = !note.favorite;
    note.updatedAt = Date.now();
    saveNotes();
    renderNotes();
  }
}

function downloadNote(id) {
  const note = notes.find(n => n.id === id);
  if (!note) return;
  const content = `Title: ${note.title}\n\n${note.description.replace(/<[^>]*>/g, '')}\n\nCategory: ${note.category}\nCreated: ${new Date(note.createdAt).toLocaleString()}\nUpdated: ${new Date(note.updatedAt).toLocaleString()}`;
  const blob = new Blob([content], { type: 'text/plain' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = `${note.title || 'note'}.txt`;
  a.click();
  URL.revokeObjectURL(url);
  showToast('Note downloaded!', '⬇️');
}

function deleteAllNotes() {
  deleteAllModal.classList.add('open');
}

function confirmDeleteAll() {
  notes = [];
  saveNotes();
  renderNotes();
  deleteAllModal.classList.remove('open');
  showToast('All notes deleted.', '🗑️');
}

function cancelDeleteAll() {
  deleteAllModal.classList.remove('open');
}

// ========== COLOR PICKER UI ==========
function updateColorPickerUI() {
  colorDots.forEach(dot => {
    dot.classList.toggle('active', dot.dataset.color === selectedColor);
  });
}

function updateEditColorPickerUI() {
  editColorDots.forEach(dot => {
    dot.classList.toggle('active', dot.dataset.color === selectedEditColor);
  });
}

// ========== WORD COUNTER ==========
function updateWordCounter() {
  const text = noteDesc.innerText || noteDesc.textContent || '';
  const words = text.trim() ? text.trim().split(/\s+/).length : 0;
  wordCounter.textContent = `Words: ${words}`;
}

// ========== THEME ==========
function toggleTheme() {
  const html = document.documentElement;
  const current = html.getAttribute('data-theme');
  const next = current === 'dark' ? 'light' : 'dark';
  html.setAttribute('data-theme', next);
  localStorage.setItem('themeVault', next);
  updateThemeIcon(next);
}

function applyThemeFromStorage() {
  const saved = localStorage.getItem('themeVault') || 'light';
  document.documentElement.setAttribute('data-theme', saved);
  updateThemeIcon(saved);
}

function updateThemeIcon(theme) {
  const icon = themeToggle.querySelector('.theme-icon');
  icon.textContent = theme === 'dark' ? '☀️' : '🌙';
}

// ========== SEARCH ==========
function handleSearch() {
  renderNotes();
}

// ========== SORT ==========
function handleSort() {
  renderNotes();
}

// ========== EVENT LISTENERS ==========
function setupEventListeners() {
  // Add note
  addBtn.addEventListener('click', addNote);

  // Theme
  themeToggle.addEventListener('click', toggleTheme);

  // Search
  searchInput.addEventListener('input', handleSearch);

  // Sort
  sortSelect.addEventListener('change', handleSort);

  // Delete all
  deleteAllBtn.addEventListener('click', deleteAllNotes);

  // Edit modal
  editCancel.addEventListener('click', closeEditModal);
  editSave.addEventListener('click', saveEdit);

  // Delete modal
  deleteCancel.addEventListener('click', cancelDelete);
  deleteConfirm.addEventListener('click', confirmDelete);

  // Delete all modal
  deleteAllCancel.addEventListener('click', cancelDeleteAll);
  deleteAllConfirm.addEventListener('click', confirmDeleteAll);

  // Close modals on overlay click
  document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
      if (e.target === overlay) {
        overlay.classList.remove('open');
        if (overlay.id === 'editModal') editingId = null;
        if (overlay.id === 'deleteModal') deletingId = null;
      }
    });
  });

  // Color pickers (add)
  colorDots.forEach(dot => {
    dot.addEventListener('click', () => {
      selectedColor = dot.dataset.color;
      updateColorPickerUI();
    });
  });

  // Color pickers (edit)
  editColorDots.forEach(dot => {
    dot.addEventListener('click', () => {
      selectedEditColor = dot.dataset.color;
      updateEditColorPickerUI();
    });
  });

  // Word counter on input
  noteDesc.addEventListener('input', updateWordCounter);

  // Rich text toolbar (for add section)
  document.querySelector('.add-form .editor-toolbar').addEventListener('click', (e) => {
    const btn = e.target.closest('.toolbar-btn');
    if (!btn) return;
    const cmd = btn.dataset.cmd;
    document.execCommand(cmd, false, null);
    noteDesc.focus();
    updateWordCounter();
  });

  // Rich text toolbar (for edit modal)
  document.querySelector('.modal-toolbar').addEventListener('click', (e) => {
    const btn = e.target.closest('.toolbar-btn');
    if (!btn) return;
    const cmd = btn.dataset.cmd;
    document.execCommand(cmd, false, null);
    editDesc.focus();
  });

  // Keyboard shortcuts: Enter to add note (but not if in editor)
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && e.ctrlKey && document.activeElement === noteTitle) {
      e.preventDefault();
      addNote();
    }
  });

  // initialize color pickers
  updateColorPickerUI();
  updateEditColorPickerUI();
}