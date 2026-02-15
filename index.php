<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sumbong Alalay - Barangay Emergency System</title>
    <link rel="stylesheet" href="styles.css">
    <meta name="robots" content="noindex">
    <style>
      
        .radio-option.selected {
            border-color: #ef4444;
            background-color: #fef2f2;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="logo">
                    <div class="logo-icon"></div>
                    <div class="logo-text">
                        <h1><span class="brand-red">Sumbong</span> Alalay</h1>
                        <p>Barangay Emergency System</p>
                    </div>
                </a>
                
                <div class="nav-links">
                    <a href="index.php" class="btn btn-outline">Submit Report</a>
                    <a href="login.php" class="btn btn-primary">Admin Dashboard</a>
                </div>
                
                <div class="emergency-hotline">
                    <p>Emergency Hotline</p>
                    <p class="hotline-number">911</p>
                </div>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div>
                    <div class="hero-badge">24/7 Emergency Response</div>
                    <h1>Mabilis na Tulong, <span class="text-red">Sumbong Alalay</span></h1>
                    <p>Magsumbong ng emergency o reklamo sa inyong Barangay. Nandito kami para tumulong 24/7.</p>
                    <div class="hero-stats">
                        <div class="stat-card"><h3>Emergency Hotline</h3><p>911</p></div>
                        <div class="stat-card"><h3>Barangay Hall</h3><p>Open 24/7</p></div>
                    </div>
                    <div class="alert-box">
                        <p><strong>Paalala:</strong> Para sa medical emergency, fire, o krimen, tumawag agad sa <strong>911</strong> para sa mas mabilis na tulong.</p>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1764684994219-8347a5ab0e5e?w=800" alt="Emergency Response Team">
                </div>
            </div>
        </div>
    </section>

    <section class="form-section">
        <div class="container">
            <div class="form-card">
                <div class="form-header">
                    <h2>Submit a Report</h2>
                    <p>Magsumbong ng Emergency o Reklamo sa Barangay</p>
                    <div class="progress-bar">
                        <div class="progress-step active" id="progress1"></div>
                        <div class="progress-step" id="progress2"></div>
                        <div class="progress-step" id="progress3"></div>
                    </div>
                </div>
                
                <div class="form-content">
                    <form action="submit_report.php" method="POST" id="reportForm">
                        <div class="form-step" id="step1">
                            <div class="step-header"><span>👤</span><h3>Step 1: Personal Information</h3></div>
                            <div class="form-group">
                                <label for="name">Full Name (Buong Pangalan)</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Juan Dela Cruz" required>
                            </div>
                            <div class="form-group">
                                <label for="age">Age (Edad)</label>
                                <input type="number" id="age" name="age" class="form-control" placeholder="25" min="1" max="120" required>
                            </div>
                            <div class="form-group">
                                <label for="location">Location (Lokasyon)</label>
                                <input type="text" id="location" name="location" class="form-control" placeholder="Blk 5, Lot 10" required>
                            </div>
                            <button type="button" class="btn btn-primary btn-block" onclick="nextStep(2)">Next: Select Concern</button>
                        </div>

                        <div class="form-step hidden" id="step2">
                            <div class="step-header"><span>Concern</span><h3>Step 2: Select Your Concern</h3></div>
                            <div class="radio-group">
                                <label class="radio-option">
                                    <input type="radio" name="concern_id" value="1" required>
                                    <div class="radio-label"><span>Medical Emergency</span><span class="badge-emergency">EMERGENCY</span></div>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="concern_id" value="2" required>
                                    <div class="radio-label"><span>Fire Incident</span><span class="badge-emergency">EMERGENCY</span></div>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="concern_id" value="3" required>
                                    <div class="radio-label"><span>Noise Complaint</span></div>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="concern_id" value="4" required>
                                    <div class="radio-label"><span>Dog Waste Complaint</span></div>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="concern_id" value="others" required>
                                    <div class="radio-label"><span>Others</span></div>
                                </label>
                            </div>

                            <div id="otherInputContainer" style="display:none; margin-top: 15px;">
                                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Pakisulat ang iyong concern:</label>
                                <textarea name="custom_concern" id="custom_concern" class="form-control" rows="3" placeholder="Type your concern here..."></textarea>
                            </div>
                            
                            <div class="button-group mt-1">
                                <button type="button" class="btn btn-outline btn-block" onclick="prevStep(1)">Back</button>
                                <button type="button" class="btn btn-primary btn-block" onclick="nextStep(3)">Susunod</button>
                            </div>
                        </div>

                        <div class="form-step hidden" id="step3">
                            <div class="step-header"><span>Review</span><h3>Step 3: Review & Emergency Contacts</h3></div>
                            <div class="review-box">
                                <div class="review-item"><label>Name</label><p id="review-name">-</p></div>
                                <div class="review-item"><label>Age</label><p id="review-age">-</p></div>
                                <div class="review-item"><label>Location</label><p id="review-location">-</p></div>
                                <div class="review-item"><label>Concern</label><p id="review-concern" style="word-break: break-all;">-</p></div>
                            </div>
                            <div class="emergency-contacts">
                                <h4>Emergency Hotlines (Para sa Agarang Tulong)</h4>
                                <div class="hotlines-grid">
                                    <div class="hotline-card hotline-911"><p>National Emergency</p><a href="tel:911">911</a></div>
                                    <div class="hotline-card hotline-pnp"><p>PNP Hotline</p><a href="tel:117">117</a></div>
                                </div>
                            </div>
                            <div class="button-group">
                                <button type="button" class="btn btn-outline btn-block" onclick="prevStep(2)">Back</button>
                                <button type="submit" class="btn btn-primary btn-block">Submit Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-bottom"><p>© 2026 Sumbong Alalay. All rights reserved.</p></div>
        </div>
    </footer>

    <script>
        let currentStep = 1;

        // Toggle Others Input Visibility
        document.querySelectorAll('input[name="concern_id"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const container = document.getElementById('otherInputContainer');
                if (this.value === 'others') {
                    container.style.display = 'block';
                    document.getElementById('custom_concern').required = true;
                } else {
                    container.style.display = 'none';
                    document.getElementById('custom_concern').required = false;
                }
            });
        });

        function nextStep(step) {
            if (step === 2) {
                const name = document.getElementById('name').value;
                const age = document.getElementById('age').value;
                const location = document.getElementById('location').value;
                if (!name || !age || !location) { alert('Please fill in all fields'); return; }
            }
            if (step === 3) {
                const concernRadio = document.querySelector('input[name="concern_id"]:checked');
                if (!concernRadio) { alert('Please select a concern'); return; }
                
                document.getElementById('review-name').textContent = document.getElementById('name').value;
                document.getElementById('review-age').textContent = document.getElementById('age').value;
                document.getElementById('review-location').textContent = document.getElementById('location').value;

                if (concernRadio.value === 'others') {
                    const otherText = document.getElementById('custom_concern').value;
                    if (!otherText) { alert('Please specify your concern'); return; }
                    document.getElementById('review-concern').textContent = otherText;
                } else {
                    const concernTexts = {'1':'Medical Emergency','2':'Fire Incident','3':'Noise Complaint','4':'Dog Waste Complaint'};
                    document.getElementById('review-concern').textContent = concernTexts[concernRadio.value];
                }
            }
            document.getElementById('step' + currentStep).classList.add('hidden');
            document.getElementById('step' + step).classList.remove('hidden');
            updateProgress(step);
            currentStep = step;
        }

        function prevStep(step) {
            document.getElementById('step' + currentStep).classList.add('hidden');
            document.getElementById('step' + step).classList.remove('hidden');
            updateProgress(step);
            currentStep = step;
        }

        function updateProgress(step) {
            for (let i=1; i<=3; i++){
                if (i<=step) document.getElementById('progress'+i).classList.add('active');
                else document.getElementById('progress'+i).classList.remove('active');
            }
        }

        document.querySelectorAll('.radio-option input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function(){
                document.querySelectorAll('.radio-option').forEach(option => option.classList.remove('selected'));
                this.closest('.radio-option').classList.add('selected');
            });
        });
    </script>
</body>
</html>