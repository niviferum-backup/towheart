(function () {
    'use strict';

    /* ── Audio system ── */
    var isMuted      = localStorage.getItem('towheart_muted') === 'true';
    var bgMusic      = new Audio();
    var voiceAudio   = new Audio();
    var musicStarted       = false;
    var line0Played        = false;
    var pendingGustaveHide = null;

    bgMusic.loop    = true;
    bgMusic.volume  = 0.1;
    bgMusic.muted   = isMuted;
    voiceAudio.volume = 1;
    voiceAudio.muted  = isMuted;

    function startMusic() {
        if (musicStarted) return;
        musicStarted = true;
        bgMusic.src = '/audio/music/floor-' + FLOOR_NUMBER + '.mp3';
        bgMusic.play().catch(function () {});
    }

    function switchMusic(newSrc) {
        bgMusic.pause();
        bgMusic.src   = newSrc;
        bgMusic.muted = isMuted;
        bgMusic.play().catch(function () {});
    }

    function playVoiceLine(index) {
        voiceAudio.pause();
        voiceAudio.currentTime = -1;
        voiceAudio.src = '/audio/lines/' + FLOOR_NUMBER + (index + 1) + '.wav';
        voiceAudio.play().catch(function () {});
    }

    function updateMuteBtn() {
        var btn = document.getElementById('muteBtn');
        if (!btn) return;
        btn.textContent = isMuted ? '🔇' : '🔊';
        btn.title = isMuted ? 'Activer le son' : 'Couper le son';
    }

    window.toggleMute = function () {
        isMuted = !isMuted;
        localStorage.setItem('towheart_muted', isMuted ? 'true' : 'false');
        bgMusic.muted    = isMuted;
        voiceAudio.muted = isMuted;
        updateMuteBtn();
    };

    /* ── Session persistence via localStorage ── */
    const STORAGE_KEY = 'towheart_progress';

    function saveProgress(floor) {
        try {
            const data = JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}');
            data[`floor_${floor}_done`] = true;
            localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
        } catch (_) {}
    }

    /* ── Dialogue system ── */
    let dialogueIndex = 0;
    let voiceIndex    = 0;
    const dialogueText = document.getElementById('dialogueText');
    const dialogueNextBtn = document.getElementById('dialogueNextBtn');

    function showDialogue(index) {
        if (!dialogueText || !DIALOGUES || !DIALOGUES.length) return;

        if (index >= DIALOGUES.length) {
            onDialogueEnd();
            return;
        }

        const entry   = DIALOGUES[index];
        const text    = typeof entry === 'string' ? entry : entry.text;
        const speaker = typeof entry === 'string' ? 'gustave' : (entry.speaker || 'gustave');

        const gustaveBox = document.getElementById('gustaveBox');
        const playerBtn  = document.getElementById('playerBtn');

        const belovedBox = document.getElementById('belovedBox');

        if (speaker === 'player') {
            if (gustaveBox)  gustaveBox.style.display  = 'none';
            if (belovedBox)  belovedBox.style.display  = 'none';
            if (playerBtn)   { playerBtn.textContent = text; playerBtn.style.display = 'block'; }
            return;
        }

        if (speaker === 'beloved') {
            if (gustaveBox)  gustaveBox.style.display  = 'none';
            if (belovedBox)  belovedBox.style.display  = 'block';
            if (playerBtn)   playerBtn.style.display   = 'none';
            const textEl = document.getElementById('belovedText');
            const btn    = document.getElementById('belovedNextBtn');
            if (!textEl) return;
            textEl.style.opacity = '0';
            setTimeout(() => {
                textEl.textContent = text;
                textEl.style.transition = 'opacity 0.4s';
                textEl.style.opacity = '1';
                playVoiceLine(voiceIndex);
                voiceIndex++;
                const isLast = index === DIALOGUES.length - 1;
                if (btn) btn.textContent = isLast ? 'Compris ✓' : 'Continuer →';
            }, 200);
            return;
        }

        if (belovedBox) belovedBox.style.display = 'none';
        if (gustaveBox) gustaveBox.style.display = 'flex';
        if (playerBtn)  playerBtn.style.display  = 'none';

        dialogueText.style.opacity = 0;
        setTimeout(() => {
            const bubble     = document.getElementById('dialogueBubble');
            const portrait   = document.querySelector('.gustave-img');
            const isMenacing = speaker === 'menacing';

            bubble.classList.toggle('dialogue-bubble--menacing', isMenacing);
            if (portrait) portrait.style.visibility = isMenacing ? 'hidden' : 'visible';

            dialogueText.textContent = text;
            dialogueText.style.transition = 'opacity 0.4s';
            dialogueText.style.opacity = 1;
            playVoiceLine(voiceIndex);
            voiceIndex++;

            const isLast = index === DIALOGUES.length - 1;
            dialogueNextBtn.textContent = isLast ? 'Compris ✓' : 'Continuer →';
        }, 200);
    }

    window.nextDialogue = function () {
        startMusic();
        dialogueIndex++;
        showDialogue(dialogueIndex);
    };

    let dialogueDone = false;

    function triggerSpaceTransition(newImageUrl, onDone) {
        var bgCurrent = document.getElementById('sceneBg');
        var bgNext    = document.getElementById('sceneBgNext');
        var flash     = document.getElementById('spaceFlash');

        bgNext.style.backgroundImage = 'url(\'' + newImageUrl + '\')';

        if (bgCurrent) bgCurrent.classList.add('launching');

        setTimeout(function () {
            if (flash) flash.style.opacity = '1';
            switchMusic('/audio/music/floor-7.mp3');
        }, 700);

        setTimeout(function () {
            if (flash) flash.style.opacity = '0';
            if (bgNext) bgNext.classList.add('arriving');
        }, 900);

        setTimeout(function () {
            if (bgCurrent) bgCurrent.style.display = 'none';
            if (onDone) onDone();
        }, 2000);
    }

    function onDialogueEnd() {
        dialogueDone = true;
        const belovedBox = document.getElementById('belovedBox');
        if (FLOOR_TYPE !== 'finale') {
            if (belovedBox) belovedBox.style.display = 'none';
        }
        if (FLOOR_TYPE === 'intro') {
            const panel = document.getElementById('introPanel');
            if (panel) { panel.style.display = 'block'; panel.style.animation = 'fadeInUp 0.5s ease both'; }
        } else if (FLOOR_TYPE === 'password' || FLOOR_TYPE === 'book_password') {
            const panel = document.getElementById('passwordPanel');
            if (panel) { panel.style.display = 'block'; panel.style.animation = 'fadeInUp 0.5s ease both'; }
        } else if (FLOOR_TYPE === 'digicode') {
            const panel = document.getElementById('digicodePanel');
            if (panel) { panel.style.display = 'block'; panel.style.animation = 'fadeInUp 0.5s ease both'; }
        } else if (FLOOR_TYPE === 'finale') {
            saveProgress(FLOOR_NUMBER);
            if (FINALE_BG) {
                if (belovedBox) belovedBox.classList.add('fading-out');
                setTimeout(function () { if (belovedBox) belovedBox.style.display = 'none'; }, 560);
                triggerSpaceTransition('/images/' + FINALE_BG, function () {
                    const panel = document.getElementById('finalePanel');
                    if (panel) { panel.style.display = 'flex'; }
                });
            } else {
                const panel = document.getElementById('finalePanel');
                if (panel) { panel.style.display = 'flex'; }
            }
        }
        // click_password: password panel revealed when all hotspots found
    };

    /* ── Password check (AJAX) ── */
    function submitPassword(value) {
        fetch(CHECK_URL, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'password=' + encodeURIComponent(value),
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.correct) {
                triggerCorrectDialogue(data.nextUrl);
            } else {
                // Password floor error
                const err = document.getElementById('passwordError');
                if (err) { err.textContent = "Ce n'est pas le bon mot… Cherche encore."; err.style.display = 'block'; }
                // Digicode floor error
                const display = document.getElementById('digicodeDisplay');
                if (display) { display.textContent = '✗'; setTimeout(function () { display.textContent = digicodeValue || '—'; }, 800); }
            }
        });
    }

    function triggerCorrectDialogue(nextUrl) {
        if (pendingGustaveHide) { clearTimeout(pendingGustaveHide); pendingGustaveHide = null; }

        const gustaveBox = document.getElementById('gustaveBox');
        if (gustaveBox) { gustaveBox.style.transition = ''; gustaveBox.style.opacity = ''; }

        ['passwordPanel', 'digicodePanel'].forEach(function (id) {
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        });

        if (!CORRECT_DIALOGUE || !CORRECT_DIALOGUE.length) {
            window.location.href = nextUrl;
            return;
        }

        runDialogue(CORRECT_DIALOGUE, function () { window.location.href = nextUrl; });
    }

    function runDialogue(lines, onEnd) {
        let idx = 0;

        function showLine() {
            if (idx >= lines.length) { onEnd(); return; }

            const entry   = lines[idx];
            const text    = typeof entry === 'string' ? entry : entry.text;
            const speaker = typeof entry === 'string' ? 'gustave' : (entry.speaker || 'gustave');

            const gustaveBox = document.getElementById('gustaveBox');
            const playerBtn  = document.getElementById('playerBtn');

            if (speaker === 'player') {
                if (gustaveBox) gustaveBox.style.display = 'none';
                if (playerBtn)  { playerBtn.textContent = text; playerBtn.style.display = 'block'; }
                playerBtn.onclick = function () { idx++; showLine(); };
                return;
            }

            const belovedBox  = document.getElementById('belovedBox');
            const isBeloved   = speaker === 'beloved';
            const activeText  = document.getElementById(isBeloved ? 'belovedText' : 'dialogueText');
            const activeBtn   = document.getElementById(isBeloved ? 'belovedNextBtn' : 'dialogueNextBtn');

            if (isBeloved) {
                if (gustaveBox) gustaveBox.style.display = 'none';
                if (belovedBox) belovedBox.style.display = 'block';
            } else {
                const bubble     = document.getElementById('dialogueBubble');
                const portrait   = document.querySelector('.gustave-img');
                const isMenacing = speaker === 'menacing';
                if (belovedBox) belovedBox.style.display = 'none';
                if (gustaveBox) { gustaveBox.style.display = 'flex'; gustaveBox.style.opacity = '1'; }
                bubble.classList.toggle('dialogue-bubble--menacing', isMenacing);
                if (portrait) portrait.style.visibility = isMenacing ? 'hidden' : 'visible';
            }
            if (playerBtn) playerBtn.style.display = 'none';

            if (!activeText) { if (activeBtn) activeBtn.onclick = function () { idx++; showLine(); }; return; }

            activeText.style.opacity = '0';
            const capturedVoiceIdx = voiceIndex;
            voiceIndex++;
            setTimeout(function () {
                activeText.textContent      = text;
                activeText.style.transition = 'opacity 0.4s';
                activeText.style.opacity    = '1';
                if (activeBtn) activeBtn.textContent = 'Continuer →';
                voiceAudio.pause();
                voiceAudio.currentTime = -1;
                voiceAudio.src = '/audio/lines/' + FLOOR_NUMBER + (capturedVoiceIdx + 1) + '.wav';
                voiceAudio.play().catch(function () {});
            }, 200);

            if (activeBtn) activeBtn.onclick = function () { idx++; showLine(); };
        }

        showLine();
    }

    /* ── Digicode ── */
    var digicodeValue = '';

    window.digicodePress = function (digit) {
        if (digicodeValue.length >= 6) return;
        digicodeValue += digit;
        updateDigicodeDisplay();
    };

    window.digicodeDelete = function () {
        digicodeValue = digicodeValue.slice(0, -1);
        updateDigicodeDisplay();
    };

    window.digicodeSubmit = function () {
        if (!digicodeValue) return;
        submitPassword(digicodeValue);
    };

    function updateDigicodeDisplay() {
        var el = document.getElementById('digicodeDisplay');
        if (el) el.textContent = digicodeValue || '—';
    }

    /* ── Conversion table ── */
    window.openConversionTable = function () {
        const overlay = document.getElementById('tableOverlay');
        if (overlay) { overlay.style.display = 'flex'; overlay.style.animation = 'fadeIn 0.25s ease'; }
    };

    window.closeConversionTable = function () {
        const overlay = document.getElementById('tableOverlay');
        if (overlay) overlay.style.display = 'none';
    };

    window.handleTableOverlayClick = function (e) {
        if (e.target === document.getElementById('tableOverlay')) closeConversionTable();
    };

    /* ── Clue hotspots ── */
    window.triggerClue = function (el, text) {
        if (!dialogueDone) return;

        const gustaveBox = document.getElementById('gustaveBox');
        const textEl     = document.getElementById('dialogueText');
        const btn        = document.getElementById('dialogueNextBtn');
        if (!textEl || !btn) return;

        el.classList.add('triggered');

        if (gustaveBox) { gustaveBox.style.display = 'flex'; gustaveBox.style.opacity = '1'; }

        textEl.style.opacity = '0';
        const capturedVoiceIdx = voiceIndex;
        voiceIndex++;
        setTimeout(function () {
            textEl.textContent            = text;
            textEl.style.transition       = 'opacity 0.4s';
            textEl.style.opacity          = '1';
            btn.textContent               = 'Compris ✓';
            voiceAudio.pause();
            voiceAudio.currentTime = -1;
            voiceAudio.src = '/audio/lines/' + FLOOR_NUMBER + (capturedVoiceIdx + 1) + '.wav';
            voiceAudio.play().catch(function () {});
        }, 200);

        btn.onclick = function () {
            fadeOutGustave();
            btn.onclick = window.nextDialogue;
        };
    };

    /* ── Hint hotspot ── */
    var hintRunning = false;

    window.triggerHint = function () {
        if (!dialogueDone || hintRunning || typeof HINT_LINE === 'undefined' || !HINT_LINE.length) return;
        hintRunning = true;
        runDialogue(HINT_LINE, function () { hintRunning = false; fadeOutGustave(); });
    };

    /* ── Book puzzle ── */
    function fadeOutGustave() {
        const belovedBox = document.getElementById('belovedBox');
        if (belovedBox) belovedBox.style.display = 'none';
        const gustaveBox = document.getElementById('gustaveBox');
        if (!gustaveBox) return;
        gustaveBox.style.transition = 'opacity 0.3s';
        gustaveBox.style.opacity    = '0';
        pendingGustaveHide = setTimeout(function () {
            pendingGustaveHide              = null;
            gustaveBox.style.display    = 'none';
            gustaveBox.style.opacity    = '';
            gustaveBox.style.transition = '';
        }, 300);
    }

    window.openBook = function (bookId) {
        if (typeof BOOKS === 'undefined') return;
        const book = BOOKS.find(function (b) { return b.id === bookId; });
        if (!book) return;

        document.getElementById('bookSpine').style.background = book.color;
        document.getElementById('bookSpineTitle').textContent  = book.title;
        document.getElementById('bookTitle').textContent       = book.title;
        document.getElementById('bookAuthor').textContent      = book.author;
        document.getElementById('bookSummary').textContent     = book.summary;

        const overlay = document.getElementById('bookOverlay');
        overlay.style.display     = 'flex';
        overlay.style.animation   = 'fadeIn 0.25s ease';
        document.getElementById('bookCard').style.animation = 'fadeInUp 0.3s ease both';
    };

    window.closeBook = function () {
        const overlay = document.getElementById('bookOverlay');
        if (overlay) overlay.style.display = 'none';
    };

    window.handleOverlayClick = function (e) {
        if (e.target === document.getElementById('bookOverlay')) closeBook();
    };

    /* ── Hotspot / click puzzle ── */
    let foundCount = 0;

    window.discoverHotspot = function (el) {
        if (el.classList.contains('found')) return;

        el.classList.add('found');
        foundCount++;

        // Reveal letter in tray
        const slot = document.getElementById('slot-' + el.id);
        if (slot) {
            slot.textContent = el.dataset.hint;
            slot.classList.add('revealed');
        }

        if (foundCount >= TOTAL_HOTSPOTS) {
            setTimeout(() => {
                const panel = document.getElementById('passwordPanel');
                if (panel) {
                    panel.style.display = 'block';
                    panel.style.animation = 'fadeInUp 0.5s ease both';
                }
            }, 400);
        }
    };

    window.startAdventure = function () {
        const startPanel = document.getElementById('startPanel');
        if (startPanel) startPanel.style.display = 'none';
        startMusic();
        showDialogue(0);
    };

    /* ── Init ── */
    document.addEventListener('DOMContentLoaded', function () {
        updateMuteBtn();

        const passwordForm = document.getElementById('passwordForm');
        if (passwordForm) {
            passwordForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const input = document.getElementById('passwordInput');
                if (input) submitPassword(input.value);
            });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { closeBook(); closeConversionTable(); }
            if (FLOOR_TYPE === 'digicode' && dialogueDone) {
                if (e.key >= '0' && e.key <= '9') digicodePress(e.key);
                else if (e.key === 'Backspace') { e.preventDefault(); digicodeDelete(); }
                else if (e.key === 'Enter') digicodeSubmit();
            }
        });

        // For password-only floors, show after dialogue ends (handled by onDialogueEnd)
        // For click_password floors: hotspots are always visible, password revealed after all found

        // Auto-uppercase the password input
        const input = document.querySelector('.password-input');
        if (input) {
            input.addEventListener('input', function () {
                const pos = this.selectionStart;
                this.value = this.value.toUpperCase();
                this.setSelectionRange(pos, pos);
            });
        }
    });

})();
