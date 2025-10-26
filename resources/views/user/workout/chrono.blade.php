@extends('user.layout')

@section('title', 'Chronomètre')

@section('content')
<div class="page active" id="chrono">
    <h1>Chronomètre de repos</h1>
    <div class="container">
        <div class="card">
            <h2>Timer</h2>
            
            <div class="timer-buttons">
                <button onclick="startTimer(30)">30s</button>
                <button onclick="startTimer(45)">45s</button>
                <button onclick="startTimer(60)">1min</button>
                <button onclick="startTimer(90)">1m30</button>
                <button onclick="startTimer(120)">2min</button>
                <button onclick="startTimer(180)">3min</button>
            </div>

            <div class="custom-timer">
                <input type="number" id="customTime" placeholder="Temps personnalisé (sec)" min="1">
                <button onclick="startCustomTimer()">Go</button>
            </div>

            <div id="countdown">00:00</div>

            <div class="control-buttons">
                <button class="btn-pause" onclick="togglePause()"><span id="pauseText">Pause</span></button>
                <button class="btn-stop" onclick="stopTimer()">Stop</button>
                <button class="btn-repeat" onclick="repeatTimer()">Répéter</button>
            </div>

            <div class="stats">
                <div class="stat-box">
                    <div class="stat-label">Séries complétées</div>
                    <div class="stat-value" id="setsCompleted">0</div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Temps total repos</div>
                    <div class="stat-value" id="totalRestTime">0s</div>
                </div>
            </div>

            <div class="history" id="history"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let timer;
let lastDuration = 0;
let isPaused = false;
let timeLeft = 0;
let setsCompleted = 0;
let totalRestTime = 0;

function startTimer(seconds) {
    clearInterval(timer);
    isPaused = false;
    document.getElementById('pauseText').textContent = 'Pause';
    lastDuration = seconds;
    timeLeft = seconds;
    updateDisplay(timeLeft);

    timer = setInterval(function () {
        if (!isPaused) {
            timeLeft--;
            updateDisplay(timeLeft);

            const display = document.getElementById('countdown');
            if (timeLeft <= 5 && timeLeft > 0) {
                display.className = 'warning';
                if (navigator.vibrate) navigator.vibrate(100);
            } else if (timeLeft <= 0) {
                clearInterval(timer);
                display.className = 'finished';
                display.textContent = 'TERMINÉ !';
                document.getElementById('beep').play();
                if (navigator.vibrate) navigator.vibrate([200, 100, 200]);

                setsCompleted++;
                totalRestTime += lastDuration;
                updateStats();
                addToHistory(lastDuration);

                setTimeout(function () {
                    display.className = '';
                    updateDisplay(0);
                }, 3000);
            } else {
                display.className = '';
            }
        }
    }, 1000);
}

function startCustomTimer() {
    const customTime = parseInt(document.getElementById('customTime').value);
    if (customTime && customTime > 0) {
        startTimer(customTime);
    }
}

function togglePause() {
    isPaused = !isPaused;
    document.getElementById('pauseText').textContent = isPaused ? 'Reprendre' : 'Pause';
}

function stopTimer() {
    clearInterval(timer);
    isPaused = false;
    document.getElementById('pauseText').textContent = 'Pause';
    document.getElementById('countdown').className = '';
    updateDisplay(0);
}

function repeatTimer() {
    if (lastDuration > 0) {
        startTimer(lastDuration);
    }
}

function updateDisplay(sec) {
    const minutes = Math.floor(sec / 60);
    const seconds = sec % 60;
    document.getElementById('countdown').textContent =
        String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
}

function updateStats() {
    document.getElementById('setsCompleted').textContent = setsCompleted;
    const mins = Math.floor(totalRestTime / 60);
    const secs = totalRestTime % 60;
    document.getElementById('totalRestTime').textContent =
        mins > 0 ? mins + 'm ' + secs + 's' : secs + 's';
}

function addToHistory(duration) {
    const historyDiv = document.getElementById('history');
    const time = new Date().toLocaleTimeString('fr-FR');
    const item = document.createElement('div');
    item.className = 'history-item';
    item.textContent = time + ' - Repos de ' + duration + 's complété';
    historyDiv.insertBefore(item, historyDiv.firstChild);

    if (historyDiv.children.length > 10) {
        historyDiv.removeChild(historyDiv.lastChild);
    }
}
</script>
@endpush