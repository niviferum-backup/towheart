@extends('layouts.game')

@section('content')

<div class="scene">

    {{-- Background layers --}}
    <div class="scene-bg" id="sceneBg" style="background-image: url('{{ asset('images/' . $data['image']) }}')"></div>
    <div class="scene-bg" id="sceneBgNext"></div>
    <div id="spaceFlash"></div>

    {{-- Floor indicator --}}
    <div class="floor-badge">
        Étage {{ $floor }} / {{ $totalFloors }}
    </div>

    {{-- Audio toggle --}}
    <button class="mute-btn" id="muteBtn" onclick="toggleMute()"></button>

    {{-- Click hotspots (only for click_password floors) --}}
    @if($data['type'] === 'click_password')
        @foreach($data['hotspots'] as $spot)
        <div class="hotspot"
             id="{{ $spot['id'] }}"
             style="left: {{ $spot['x'] }}%; top: {{ $spot['y'] }}%"
             data-hint="{{ $spot['hint'] }}"
             onclick="discoverHotspot(this)">
            <div class="hotspot-ring"></div>
            <div class="hotspot-letter">{{ $spot['hint'] }}</div>
        </div>
        @endforeach

        {{-- Discovered letters tray --}}
        <div class="letters-tray" id="lettersTray">
            @foreach($data['hotspots'] as $spot)
            <span class="letter-slot" id="slot-{{ $spot['id'] }}">_</span>
            @endforeach
        </div>
    @endif

    {{-- Book hotspots (only for book_password floors) --}}
    @if($data['type'] === 'book_password')
        @foreach($data['hotspots'] as $book)
        <div class="book-hotspot"
             id="{{ $book['id'] }}"
             style="left: {{ $book['x'] }}%; top: {{ $book['y'] }}%; background: {{ $book['color'] }}"
             onclick="openBook('{{ $book['id'] }}')">
            <span class="book-spine-label">{{ $book['title'] }}</span>
        </div>
        @endforeach

        {{-- Book detail modal --}}
        <div class="book-overlay" id="bookOverlay" style="display:none" onclick="handleOverlayClick(event)">
            <div class="book-card" id="bookCard">
                <div class="book-spine" id="bookSpine">
                    <span class="book-spine-title" id="bookSpineTitle"></span>
                </div>
                <div class="book-content">
                    <button class="book-close" onclick="closeBook()">✕</button>
                    <p class="book-title" id="bookTitle"></p>
                    <p class="book-author" id="bookAuthor"></p>
                    <hr class="book-divider">
                    <p class="book-summary" id="bookSummary"></p>
                </div>
            </div>
        </div>
    @endif

    {{-- Conversion table hotspot (available on any floor) --}}
    @if(!empty($data['conversion_table']))
    <div class="table-hotspot"
         style="left: {{ $data['conversion_table']['x'] }}%; top: {{ $data['conversion_table']['y'] }}%"
         onclick="openConversionTable()">
        <div class="table-hotspot-ring"></div>
        <img src="{{ asset('images/clef-note.svg') }}" class="table-hotspot-icon" alt="">
    </div>

    <div class="table-overlay" id="tableOverlay" style="display:none" onclick="handleTableOverlayClick(event)">
        <div class="table-card">
            <button class="table-close" onclick="closeConversionTable()">✕</button>
            <h2 class="table-title">Table de Correspondance</h2>
            <div class="table-grid">
                <div class="table-header">Note</div>
                <div class="table-header">Lettre</div>
                @foreach($data['conversion_table']['rows'] as $row)
                <div class="table-cell table-cell-note">
                    <svg viewBox="0 0 40 36" width="80" height="72" xmlns="http://www.w3.org/2000/svg" fill="none">
                        <g stroke="rgba(255,220,140,0.4)" stroke-width="0.8">
                            <line x1="2" y1="5"  x2="38" y2="5"/>
                            <line x1="2" y1="10" x2="38" y2="10"/>
                            <line x1="2" y1="15" x2="38" y2="15"/>
                            <line x1="2" y1="20" x2="38" y2="20"/>
                            <line x1="2" y1="25" x2="38" y2="25"/>
                        </g>
                        @if($row['ledger'])
                        <line x1="16" y1="{{ $row['staff_y'] }}" x2="32" y2="{{ $row['staff_y'] }}"
                              stroke="rgba(255,220,140,0.4)" stroke-width="0.8"/>
                        @endif
                        <ellipse cx="24" cy="{{ $row['staff_y'] }}" rx="4.2" ry="2.2"
                                 transform="rotate(-18 24 {{ $row['staff_y'] }})"
                                 fill="rgba(255,220,140,0.9)"/>
                        <line x1="28" y1="{{ $row['staff_y'] - 1 }}" x2="28" y2="5"
                              stroke="rgba(255,220,140,0.85)" stroke-width="1.2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="table-cell table-cell-letter">{{ $row['letter'] }}</div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Hint hotspot (triggers hint_line dialogue) --}}
    @if(!empty($data['hint_hotspot']) && !empty($data['hint_line']))
    <div class="clue-hotspot" id="hintHotspot"
         style="left: {{ $data['hint_hotspot']['x'] }}%; top: {{ $data['hint_hotspot']['y'] }}%"
         onclick="triggerHint()">
        <div class="clue-ring"></div>
    </div>
    @endif

    {{-- Clue hotspots (available on any floor) --}}
    @if(!empty($data['clue_hotspots']))
        @foreach($data['clue_hotspots'] as $clue)
        <div class="clue-hotspot {{ !empty($clue['label']) ? 'clue-hotspot--labeled' : '' }}"
             id="{{ $clue['id'] }}"
             style="left: {{ $clue['x'] }}%; top: {{ $clue['y'] }}%"
             onclick="triggerClue(this, {{ json_encode($clue['clue']) }})">
            @if(!empty($clue['label']))
                <span class="clue-label">{{ $clue['label'] }}</span>
            @else
                <div class="clue-ring"></div>
            @endif
        </div>
        @endforeach
    @endif

    {{-- Start button --}}
    <div class="start-panel" id="startPanel">
        <button class="btn-start" onclick="startAdventure()">{{ $floor === 1 ? "Commencer l'aventure" : "Commencer l'étage" }}</button>
    </div>

    {{-- Player response button --}}
    <button class="btn-player-line" id="playerBtn" style="display:none" onclick="nextDialogue()"></button>

    {{-- Gustave dialogue box --}}
    <div class="gustave-box" id="gustaveBox" style="display:none">
        <img src="{{ asset('images/Gustave.png') }}" alt="Gustave" class="gustave-img">
        <div class="dialogue-bubble" id="dialogueBubble">
            <p id="dialogueText"></p>
            <button class="btn-next-dialogue" id="dialogueNextBtn" onclick="nextDialogue()">
                Continuer →
            </button>
        </div>
    </div>

    {{-- Beloved character dialogue box (full-width bottom-third bar) --}}
    <div class="beloved-box" id="belovedBox" style="display:none">
        <img src="{{ asset('images/Beloved.png') }}" alt="" class="beloved-sprite">
        <div class="beloved-bar">
            <p id="belovedText"></p>
            <button class="btn-next-dialogue" id="belovedNextBtn" onclick="nextDialogue()">Continuer →</button>
        </div>
    </div>

    {{-- Digicode panel --}}
    @if($data['type'] === 'digicode')
    <div class="digicode-panel" id="digicodePanel" style="display:none">
        <p class="digicode-label">{{ $data['password_prompt'] }}</p>
        <div class="digicode-display" id="digicodeDisplay">—</div>
        <div class="digicode-grid">
            @foreach([1,2,3,4,5,6,7,8,9] as $d)
            <button class="digicode-key" type="button" onclick="digicodePress('{{ $d }}')">{{ $d }}</button>
            @endforeach
            <button class="digicode-key digicode-del" type="button" onclick="digicodeDelete()">⌫</button>
            <button class="digicode-key" type="button" onclick="digicodePress('0')">0</button>
            <button class="digicode-key digicode-enter" type="button" onclick="digicodeSubmit()">✓</button>
        </div>
    </div>
    @endif

    {{-- Password form --}}
    @if(in_array($data['type'], ['password', 'click_password', 'book_password']))
    <div class="password-panel" id="passwordPanel" style="display:none">
        <p id="passwordError" class="error-msg" style="display:none"></p>
        <p class="password-prompt">{{ $data['password_prompt'] }}</p>
        <form id="passwordForm">
            <input type="text"
                   name="password"
                   id="passwordInput"
                   class="password-input"
                   placeholder="Tape le mot de passe…"
                   autocomplete="off"
                   autofocus>
            <button type="submit" class="btn-submit">Valider</button>
        </form>
    </div>
    @endif

    {{-- Intro / next floor button --}}
    @if($data['type'] === 'intro')
    <div class="password-panel" id="introPanel" style="display:none">
        <form method="POST" action="{{ route('floor.next', $floor) }}">
            @csrf
            <button type="submit" class="btn-submit">Entrer dans la tour →</button>
        </form>
    </div>
    @endif

    {{-- Finale --}}
    @if($data['type'] === 'finale')
    <div class="finale-panel" id="finalePanel" style="display:none">
        <div class="love-letter">
            {!! nl2br(e(config('game.floors.6.love_letter'))) !!}
        </div>
    </div>
    @endif

</div>

<script>
    const FLOOR_TYPE       = @json($data['type']);
    const FLOOR_NUMBER     = {{ $floor }};
    const DIALOGUES        = @json($data['gustave']);
    const TOTAL_HOTSPOTS   = {{ count($data['hotspots']) }};
    const CHECK_URL        = "{{ route('floor.check', $floor) }}";
    const CSRF_TOKEN       = "{{ csrf_token() }}";
    const CORRECT_DIALOGUE = @json($data['correct_dialogue'] ?? []);
    const FINALE_BG        = @json($data['finale_bg'] ?? null);
    @if($data['type'] === 'book_password')
    const BOOKS      = @json($data['hotspots']);
    const HINT_LINE  = @json($data['hint_line'] ?? []);
    @endif
</script>

@endsection
