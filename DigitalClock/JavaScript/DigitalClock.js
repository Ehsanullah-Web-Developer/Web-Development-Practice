// script.js - all functionality

document.addEventListener('DOMContentLoaded', () => {
  // ----- DOM refs -----
  const timeDisplay = document.getElementById('timeDisplay');
  const amPmDisplay = document.getElementById('amPmDisplay');
  const dateDisplay = document.getElementById('dateDisplay');
  const worldGrid = document.getElementById('worldGrid');

  // buttons
  const btn12h = document.getElementById('btn12h');
  const btn24h = document.getElementById('btn24h');
  const themeLight = document.getElementById('themeLight');
  const themeDark = document.getElementById('themeDark');
  const themeBlue = document.getElementById('themeBlue');
  const themeGreen = document.getElementById('themeGreen');
  const fullscreenBtn = document.getElementById('fullscreenBtn');
  const minimalBtn = document.getElementById('minimalBtn');

  // stopwatch
  const swDisplay = document.getElementById('stopwatchDisplay');
  const swStart = document.getElementById('swStart');
  const swStop = document.getElementById('swStop');
  const swReset = document.getElementById('swReset');

  // alarm
  const alarmInput = document.getElementById('alarmInput');
  const alarmSetBtn = document.getElementById('alarmSetBtn');
  const alarmClearBtn = document.getElementById('alarmClearBtn');
  const alarmStatus = document.getElementById('alarmStatus');

  // countdown
  const cdMinutes = document.getElementById('cdMinutes');
  const cdSeconds = document.getElementById('cdSeconds');
  const cdStart = document.getElementById('cdStart');
  const cdReset = document.getElementById('cdReset');
  const cdDisplay = document.getElementById('countdownDisplay');

  // ----- state -----
  let use24h = false;
  let stopwatchRunning = false;
  let stopwatchTime = 0; // seconds
  let stopwatchInterval = null;
  let alarmTime = null; // string 'HH:MM'
  let alarmTriggered = false;
  let countdownInterval = null;
  let countdownSeconds = 0;

  // ----- helper: leading zero -----
  const pad = (n) => String(n).padStart(2, '0');

  // ----- update clock -----
  function updateClock() {
    const now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let seconds = now.getSeconds();
    let ampm = '';

    if (use24h) {
      amPmDisplay.textContent = '';
    } else {
      ampm = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12 || 12;
      amPmDisplay.textContent = ampm;
    }
    timeDisplay.textContent = `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
    // date
    const days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    dateDisplay.textContent = `${days[now.getDay()]} ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;

    // alarm check (only if set)
    if (alarmTime && !alarmTriggered) {
      const current = `${pad(now.getHours())}:${pad(now.getMinutes())}`;
      if (current === alarmTime && now.getSeconds() === 0) {
        alarmTriggered = true;
        alert('⏰ ALARM! Time to wake up!');
        alarmStatus.textContent = '🔔 Alarm rang!';
        // auto clear alarm after ring
        alarmTime = null;
        alarmStatus.textContent = '⏰ Alarm not set';
        alarmTriggered = false;
      }
    }
  }

  // ----- world clocks (10 cities) -----
  const worldCities = [
    { city: 'London', tz: 'Europe/London' },
    { city: 'Tokyo', tz: 'Asia/Tokyo' },
    { city: 'New York', tz: 'America/New_York' },
    { city: 'Dubai', tz: 'Asia/Dubai' },
    { city: 'Sydney', tz: 'Australia/Sydney' },
    { city: 'Paris', tz: 'Europe/Paris' },
    { city: 'Moscow', tz: 'Europe/Moscow' },
    { city: 'Singapore', tz: 'Asia/Singapore' },
    { city: 'Los Angeles', tz: 'America/Los_Angeles' },
    { city: 'Karachi', tz: 'Asia/Karachi' }
  ];

  function renderWorldClocks() {
    worldGrid.innerHTML = '';
    const now = new Date();
    worldCities.forEach(({ city, tz }) => {
      const div = document.createElement('div');
      div.className = 'world-item';
      const timeStr = new Date(now.toLocaleString('en-US', { timeZone: tz }));
      const h = timeStr.getHours();
      const m = timeStr.getMinutes();
      const s = timeStr.getSeconds();
      const display = `${pad(h)}:${pad(m)}:${pad(s)}`;
      div.innerHTML = `<div class="city">${city}</div><div class="wtime">${display}</div>`;
      worldGrid.appendChild(div);
    });
  }

  // update world clocks every second (independent)
  function updateWorldClocks() {
    const items = worldGrid.querySelectorAll('.world-item');
    const now = new Date();
    items.forEach((item, idx) => {
      if (idx >= worldCities.length) return;
      const { tz } = worldCities[idx];
      const timeStr = new Date(now.toLocaleString('en-US', { timeZone: tz }));
      const h = timeStr.getHours();
      const m = timeStr.getMinutes();
      const s = timeStr.getSeconds();
      const wtime = item.querySelector('.wtime');
      if (wtime) wtime.textContent = `${pad(h)}:${pad(m)}:${pad(s)}`;
    });
  }

  // ----- stopwatch -----
  function updateStopwatchDisplay() {
    const hrs = Math.floor(stopwatchTime / 3600);
    const mins = Math.floor((stopwatchTime % 3600) / 60);
    const secs = Math.floor(stopwatchTime % 60);
    swDisplay.textContent = `${pad(hrs)}:${pad(mins)}:${pad(secs)}`;
  }

  swStart.addEventListener('click', () => {
    if (stopwatchRunning) return;
    stopwatchRunning = true;
    stopwatchInterval = setInterval(() => {
      stopwatchTime++;
      updateStopwatchDisplay();
    }, 1000);
  });
  swStop.addEventListener('click', () => {
    stopwatchRunning = false;
    clearInterval(stopwatchInterval);
  });
  swReset.addEventListener('click', () => {
    stopwatchRunning = false;
    clearInterval(stopwatchInterval);
    stopwatchTime = 0;
    updateStopwatchDisplay();
  });

  // ----- alarm -----
  alarmSetBtn.addEventListener('click', () => {
    const val = alarmInput.value;
    if (!val) return;
    alarmTime = val;
    alarmTriggered = false;
    alarmStatus.textContent = `⏰ Alarm set for ${val}`;
  });
  alarmClearBtn.addEventListener('click', () => {
    alarmTime = null;
    alarmTriggered = false;
    alarmStatus.textContent = '⏰ Alarm not set';
  });

  // ----- countdown -----
  function updateCountdownDisplay() {
    const mins = Math.floor(countdownSeconds / 60);
    const secs = countdownSeconds % 60;
    cdDisplay.textContent = `${pad(mins)}:${pad(secs)}`;
  }

  cdStart.addEventListener('click', () => {
    if (countdownInterval) clearInterval(countdownInterval);
    const mins = parseInt(cdMinutes.value) || 0;
    const secs = parseInt(cdSeconds.value) || 0;
    countdownSeconds = mins * 60 + secs;
    if (countdownSeconds <= 0) return;
    updateCountdownDisplay();
    countdownInterval = setInterval(() => {
      countdownSeconds--;
      updateCountdownDisplay();
      if (countdownSeconds <= 0) {
        clearInterval(countdownInterval);
        countdownInterval = null;
        alert('⏳ Countdown finished!');
        cdDisplay.textContent = '00:00';
      }
    }, 1000);
  });
  cdReset.addEventListener('click', () => {
    clearInterval(countdownInterval);
    countdownInterval = null;
    countdownSeconds = 0;
    cdDisplay.textContent = '00:00';
    cdMinutes.value = 5;
    cdSeconds.value = 0;
  });

  // ----- time format switch -----
  btn12h.addEventListener('click', () => { use24h = false; btn12h.classList.add('active'); btn24h.classList.remove('active'); });
  btn24h.addEventListener('click', () => { use24h = true; btn24h.classList.add('active'); btn12h.classList.remove('active'); });

  // ----- theme toggle (plus extra) -----
  function setTheme(theme) {
    document.body.setAttribute('data-theme', theme);
  }
  themeLight.addEventListener('click', () => setTheme('light'));
  themeDark.addEventListener('click', () => setTheme('dark'));
  themeBlue.addEventListener('click', () => setTheme('blue'));
  themeGreen.addEventListener('click', () => setTheme('green'));

  // ----- fullscreen & minimal (just toggle fullscreen) -----
  fullscreenBtn.addEventListener('click', () => {
    if (!document.fullscreenElement) {
      document.documentElement.requestFullscreen?.();
    } else {
      document.exitFullscreen?.();
    }
  });
  minimalBtn.addEventListener('click', () => {
    document.body.classList.toggle('minimal');
    // simple minimal: hide some sections? we just add a class
    const sections = document.querySelectorAll('.world-clocks, .extra-tools, .controls');
    if (document.body.classList.contains('minimal')) {
      sections.forEach(el => el.style.display = 'none');
      minimalBtn.textContent = 'Show all';
    } else {
      sections.forEach(el => el.style.display = '');
      minimalBtn.textContent = 'Minimal';
    }
  });

  // ----- init -----
  renderWorldClocks();
  updateClock();
  setTheme('light');

  // update every second
  setInterval(() => {
    updateClock();
    updateWorldClocks();
  }, 1000);

  // also update world clocks on format change (no need extra)
  // footer year
  document.getElementById('footerYear').textContent = new Date().getFullYear();
});