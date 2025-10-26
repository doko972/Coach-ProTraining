@extends('user.layout')

@section('title', 'Calcul 1RM')

@section('content')
<div class="page active" id="calc1rm">
    <h1>Calculateur 1RM</h1>
    <div class="container">
        <div class="card">
            <h2>Calcul des pourcentages</h2>
            <div class="input-group">
                <label for="oneRM">Entre ton 1RM (kg) :</label>
                <input type="number" id="oneRM" placeholder="Ex : 100" oninput="calculate()">
            </div>
            
            <div class="percentage-grid">
                <div class="percentage-item">
                    <div class="percentage-label">60%</div>
                    <div class="percentage-value"><span id="p60">0</span> kg</div>
                </div>
                <div class="percentage-item">
                    <div class="percentage-label">65%</div>
                    <div class="percentage-value"><span id="p65">0</span> kg</div>
                </div>
                <div class="percentage-item">
                    <div class="percentage-label">70%</div>
                    <div class="percentage-value"><span id="p70">0</span> kg</div>
                </div>
                <div class="percentage-item">
                    <div class="percentage-label">75%</div>
                    <div class="percentage-value"><span id="p75">0</span> kg</div>
                </div>
                <div class="percentage-item">
                    <div class="percentage-label">80%</div>
                    <div class="percentage-value"><span id="p80">0</span> kg</div>
                </div>
                <div class="percentage-item">
                    <div class="percentage-label">85%</div>
                    <div class="percentage-value"><span id="p85">0</span> kg</div>
                </div>
                <div class="percentage-item">
                    <div class="percentage-label">90%</div>
                    <div class="percentage-value"><span id="p90">0</span> kg</div>
                </div>
                <div class="percentage-item">
                    <div class="percentage-label">95%</div>
                    <div class="percentage-value"><span id="p95">0</span> kg</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function calculate() {
    const oneRM = parseFloat(document.getElementById('oneRM').value);
    if (oneRM) {
        document.getElementById('p60').textContent = (oneRM * 0.6).toFixed(1);
        document.getElementById('p65').textContent = (oneRM * 0.65).toFixed(1);
        document.getElementById('p70').textContent = (oneRM * 0.7).toFixed(1);
        document.getElementById('p75').textContent = (oneRM * 0.75).toFixed(1);
        document.getElementById('p80').textContent = (oneRM * 0.8).toFixed(1);
        document.getElementById('p85').textContent = (oneRM * 0.85).toFixed(1);
        document.getElementById('p90').textContent = (oneRM * 0.9).toFixed(1);
        document.getElementById('p95').textContent = (oneRM * 0.95).toFixed(1);
    }
}
</script>
@endpush