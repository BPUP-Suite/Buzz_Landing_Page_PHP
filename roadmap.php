<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Roadmap</title>
    <style>
        :root {
            --primary-dark: #0d1b24;
            --primary-darker: #081218;
            --primary-light: #1a2c3a;
            --accent-blue: #1e70aa;
            --accent-light: #56ccf2;
            --text-light: #e0e6eb;
            --text-muted: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--primary-dark);
            color: var(--text-light);
            line-height: 1.6;
        }
        
        .container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background-color: var(--primary-darker);
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            color: var(--text-light);
            font-weight: bold;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .logo span {
            color: var(--accent-light);
            margin-left: 8px;
        }
        
        .menu-icon {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
        }
        
        .page-title {
            font-size: 2rem;
            margin: 20px 0;
            color: var(--text-light);
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .info-bar {
            background-color: rgba(30, 112, 170, 0.1);
            border-radius: 4px;
            padding: 10px 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        
        .info-bar span {
            margin-right: 15px;
        }
        
        .info-bar a {
            color: var(--accent-light);
            text-decoration: none;
        }
        
        .view-controls {
            display: flex;
            margin: 20px 0;
        }
        
        .view-tab {
            padding: 10px 20px;
            background-color: var(--primary-light);
            color: var(--text-light);
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: 500;
            border-radius: 4px 4px 0 0;
        }
        
        .view-tab.active {
            background-color: var(--accent-blue);
            color: white;
        }
        
        .view-content {
            display: none;
            animation: fadeIn 0.5s;
        }
        
        .view-content.active {
            display: block;
        }
        
        /* Release View Styles */
        .release-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .release-card {
            background-color: var(--primary-light);
            border-radius: 6px;
            overflow: hidden;
            transition: transform 0.3s;
            border: 1px solid var(--border-color);
        }
        
        .release-card:hover {
            transform: translateY(-5px);
        }
        
        .release-header {
            background-color: rgba(30, 112, 170, 0.3);
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .release-version {
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .release-date {
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        
        .release-status {
            display: inline-block;
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 12px;
            background-color: #2e445a;
        }
        
        .status-released {
            background-color: #10B981;
        }
        
        .status-tentative {
            background-color: #F59E0B;
        }
        
        .release-content {
            padding: 15px;
        }
        
        .category {
            margin-bottom: 15px;
        }
        
        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .category-name {
            font-weight: 500;
        }
        
        .category-toggle {
            transition: transform 0.3s;
        }
        
        .category-toggle.expanded {
            transform: rotate(180deg);
        }
        
        .category-items {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        
        .category-items.expanded {
            max-height: 500px;
        }
        
        .feature-item {
            margin: 10px 0;
            padding: 8px;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
            font-size: 0.9rem;
        }
        
        .feature-item img {
            max-width: 100%;
            border-radius: 4px;
            margin: 8px 0;
        }
        
        .feature-tag {
            display: inline-block;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 4px;
            margin-right: 5px;
            background-color: var(--accent-blue);
        }
        
        /* Progress Tracker Styles */
        .tracker-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .time-navigation {
            display: flex;
            align-items: center;
        }
        
        .time-btn {
            background-color: var(--primary-light);
            color: var(--text-light);
            border: none;
            padding: 8px 15px;
            margin-right: 5px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .time-btn.active {
            background-color: var(--accent-blue);
        }
        
        .current-period {
            margin: 0 10px;
            font-weight: 500;
        }
        
        .tracker-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .tracker-header {
            background-color: var(--primary-light);
            position: sticky;
            top: 0;
            z-index: 1;
        }
        
        .tracker-header th {
            padding: 12px 15px;
            text-align: left;
            font-weight: 500;
            border-bottom: 1px solid var(--border-color);
        }
        
        .time-cell {
            min-width: 120px;
            font-size: 0.85rem;
            text-align: center;
            color: var(--text-muted);
        }
        
        .team-row {
            background-color: rgba(255, 255, 255, 0.05);
            transition: background-color 0.3s;
        }
        
        .team-row:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .team-cell {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            cursor: pointer;
        }
        
        .team-name {
            display: flex;
            align-items: center;
        }
        
        .toggle-icon {
            margin-right: 10px;
            transition: transform 0.3s;
        }
        
        .expanded .toggle-icon {
            transform: rotate(90deg);
        }
        
        .timeline-cell {
            padding: 0;
            border-bottom: 1px solid var(--border-color);
            position: relative;
            min-width: 120px;
        }
        
        .deliverable-bar {
            position: absolute;
            height: 20px;
            top: 50%;
            transform: translateY(-50%);
            background-color: var(--accent-blue);
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .deliverable-bar:hover {
            background-color: var(--accent-light);
        }
        
        /* Tooltips */
        .tooltip {
            position: relative;
        }
        
        .tooltip:hover .tooltip-content {
            visibility: visible;
            opacity: 1;
        }
        
        .tooltip-content {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--primary-darker);
            color: var(--text-light);
            padding: 8px 12px;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            width: 200px;
            font-size: 0.85rem;
            z-index: 1;
            transition: opacity 0.3s, visibility 0.3s;
        }
        
        .tooltip-content::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: var(--primary-darker) transparent transparent transparent;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Media Queries */
        @media screen and (max-width: 768px) {
            .release-grid {
                grid-template-columns: 1fr;
            }
            
            .tracker-table {
                display: block;
                overflow-x: auto;
            }
            
            .menu-icon {
                display: block;
            }
            
            .view-tab {
                flex: 1;
                text-align: center;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">
                PRO<span>DUCT</span> / Roadmap
            </div>
            <div class="menu-icon">&#9776;</div>
        </div>
    </header>
    
    <div class="container">
        <div id="releaseView" class="view-section">
            <h1 class="page-title">RELEASE VIEW</h1>
            <div class="info-bar">
                <span>Updated Feb. 26th 2025</span>
                <span>Live Version: 4.01 (<a href="#" class="info-link">more info</a>)</span>
                <span>Latest Roadmap Roundup: 12/11/2024 (<a href="#" class="info-link">more info</a>)</span>
            </div>
            
            <div class="view-controls">
                <button class="view-tab active" onclick="switchView('release')">RELEASE VIEW</button>
                <button class="view-tab" onclick="switchView('progress')">PROGRESS TRACKER</button>
                <button class="view-tab all-categories-btn">EXPAND ALL CATEGORIES</button>
                <button class="view-tab all-categories-btn">COLLAPSE ALL CATEGORIES</button>
            </div>
            
            <div id="releaseContent" class="view-content active">
                <div class="release-grid">
                    <!-- 3.23 Release Card -->
                    <div class="release-card">
                        <div class="release-header">
                            <div class="release-version">3.23</div>
                            <div class="release-status status-released">RELEASED</div>
                        </div>
                        <div class="release-date">May 10, 2024</div>
                        <div class="release-content">
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">AI</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">2 Entries</span>
                                        Improved NPC pathfinding algorithms
                                    </div>
                                </div>
                            </div>
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">Characters</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">1 Entry</span>
                                        New character customization options
                                    </div>
                                </div>
                            </div>
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">Core Tech</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">5 Entries</span>
                                        Performance optimizations for low-end systems
                                    </div>
                                </div>
                            </div>
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">Gameplay</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">12 Entries</span>
                                        New mission types and gameplay loops
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 3.24 Release Card -->
                    <div class="release-card">
                        <div class="release-header">
                            <div class="release-version">3.24</div>
                            <div class="release-status status-released">RELEASED</div>
                        </div>
                        <div class="release-date">August 28, 2024</div>
                        <div class="release-content">
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">Characters</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">RELEASED</span>
                                        Additional Player Customization
                                        <img src="/api/placeholder/400/200" alt="Character customization" />
                                        <p>Adding new hair and face options for the character customizer.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">Gameplay</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">5 Entries</span>
                                        Enhanced trading mechanics and economy balance
                                    </div>
                                </div>
                            </div>
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">Locations</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">2 Entries</span>
                                        New explorable areas added to existing locations
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 4.0 Release Card -->
                    <div class="release-card">
                        <div class="release-header">
                            <div class="release-version">4.0</div>
                            <div class="release-status status-released">RELEASED</div>
                        </div>
                        <div class="release-date">Q4 2024</div>
                        <div class="release-content">
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">AI</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">RELEASED</span>
                                        Fauna - Quasi Grazer
                                        <img src="/api/placeholder/400/200" alt="Quasi Grazer fauna" />
                                        <p>Introducing the Quasi Grazer fauna into the persistent universe.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">Core Tech</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">2 Entries</span>
                                        Major engine upgrade and performance improvements
                                    </div>
                                </div>
                            </div>
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">Gameplay</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">3 Entries</span>
                                        New profession: Salvage operations
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 4.1 Release Card -->
                    <div class="release-card">
                        <div class="release-header">
                            <div class="release-version">4.1</div>
                            <div class="release-status status-tentative">TENTATIVE</div>
                        </div>
                        <div class="release-date">Q1-Q2 2025</div>
                        <div class="release-content">
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">Characters</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">2 Entries</span>
                                        Enhanced character animations and expressions
                                    </div>
                                </div>
                            </div>
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">Gameplay</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">2 Entries</span>
                                        Dynamic mission system and reputation overhaul
                                    </div>
                                </div>
                            </div>
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">Locations</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">3 Entries</span>
                                        New star system with multiple landing zones
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Star Citizen 1.0 Card -->
                    <div class="release-card">
                        <div class="release-header">
                            <div class="release-version">Star Citizen 1.0</div>
                            <div class="release-status status-tentative">TENTATIVE</div>
                        </div>
                        <div class="release-date">TBD</div>
                        <div class="release-content">
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">Characters</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">1 Entry</span>
                                        Final character progression and skill system
                                    </div>
                                </div>
                            </div>
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">Core Tech</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">8 Entries</span>
                                        Server meshing and complete persistence
                                    </div>
                                </div>
                            </div>
                            <div class="category">
                                <div class="category-header" onclick="toggleCategory(this)">
                                    <div class="category-name">Gameplay</div>
                                    <div class="category-toggle">▼</div>
                                </div>
                                <div class="category-items">
                                    <div class="feature-item">
                                        <span class="feature-tag">30 Entries</span>
                                        All core gameplay systems and professions
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="progressContent" class="view-content">
                <div class="tracker-controls">
                    <div class="view-controls">
                        <button class="view-tab active" onclick="switchTrackerView('teams')">TEAMS</button>
                        <button class="view-tab" onclick="switchTrackerView('deliverables')">DELIVERABLES</button>
                    </div>
                    
                    <div class="time-navigation">
                        <button class="time-btn" onclick="navigateTime('prev')">◀</button>
                        <div class="current-period">Q2 2025</div>
                        <button class="time-btn" onclick="navigateTime('next')">▶</button>
                        <button class="time-btn active">CURRENT QUARTER</button>
                        <button class="time-btn">FILTERS</button>
                    </div>
                </div>
                
                <div class="tracker-table-container">
                    <table class="tracker-table">
                        <thead class="tracker-header">
                            <tr>
                                <th>Teams</th>
                                <th class="time-cell">March</th>
                                <th class="time-cell">April</th>
                                <th class="time-cell">May</th>
                                <th class="time-cell">June</th>
                                <th class="time-cell">July</th>
                                <th class="time-cell">August</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="team-row">
                                <td class="team-cell">
                                    <div class="team-name">
                                        <span class="toggle-icon">▶</span>
                                        SC & SQ42 - CHARACTER ART AND TECH
                                    </div>
                                </td>
                                <td class="timeline-cell" colspan="6">
                                    <div class="deliverable-bar tooltip" style="width: 15%; left: 5%;">
                                        <div class="tooltip-content">
                                            <strong>1 deliverable</strong><br>
                                            Character visual improvements
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="team-row">
                                <td class="team-cell">
                                    <div class="team-name">
                                        <span class="toggle-icon">▶</span>
                                        SC & SQ42 - CORE GAMEPLAY PILLAR
                                    </div>
                                </td>
                                <td class="timeline-cell" colspan="6">
                                    <div class="deliverable-bar tooltip" style="width: 40%; left: 0%;">
                                        <div class="tooltip-content">
                                            <strong>41 deliverables</strong><br>
                                            Core gameplay mechanics and features
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="team-row">
                                <td class="team-cell">
                                    <div class="team-name">
                                        <span class="toggle-icon">▶</span>
                                        SC & SQ42 - VEHICLE CONTENT EU
                                    </div>
                                </td>
                                <td class="timeline-cell" colspan="6"></td>
                            </tr>
                            <tr class="team-row">
                                <td class="team-cell">
                                    <div class="team-name">
                                        <span class="toggle-icon">▶</span>
                                        SC & SQ42 - VEHICLE CONTENT NA
                                    </div>
                                </td>
                                <td class="timeline-cell" colspan="6"></td>
                            </tr>
                            <tr class="team-row">
                                <td class="team-cell">
                                    <div class="team-name">
                                        <span class="toggle-icon">▶</span>
                                        SC - LOCATIONS
                                    </div>
                                </td>
                                <td class="timeline-cell" colspan="6">
                                    <div class="deliverable-bar tooltip" style="width: 30%; left: 15%;">
                                        <div class="tooltip-content">
                                            <strong>13 deliverables</strong><br>
                                            New locations and environment improvements
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="team-row">
                                <td class="team-cell">
                                    <div class="team-name">
                                        <span class="toggle-icon">▶</span>
                                        SQ42 - CHAPTER STRIKE TEAM 0
                                    </div>
                                </td>
                                <td class="timeline-cell" colspan="6"></td>
                            </tr>
                            <tr class="team-row">
                                <td class="team-cell">
                                    <div class="team-name">
                                        <span class="toggle-icon">▶</span>
                                        SQ42 - CHAPTER STRIKE TEAM 1
                                    </div>
                                </td>
                                <td class="timeline-cell" colspan="6"></td>
                            </tr>
                            <tr class="team-row">
                                <td class="team-cell">
                                    <div class="team-name">
                                        <span class="toggle-icon">▶</span>
                                        SQ42 - CHAPTER STRIKE TEAM 2
                                    </div>
                                </td>
                                <td class="timeline-cell" colspan="6"></td>
                            </tr>
                            <tr class="team-row">
                                <td class="team-cell">
                                    <div class="team-name">
                                        <span class="toggle-icon">▶</span>
                                        SQ42 - SOCIAL STRIKE TEAM
                                    </div>
                                </td>
                                <td class="timeline-cell" colspan="6"></td>
                            </tr>
                            <tr class="team-row">
                                <td class="team-cell">
                                    <div class="team-name">
                                        <span class="toggle-icon">▶</span>
                                        Z-ARCHIVE - ACTOR FEATURE TEAM
                                    </div>
                                </td>
                                <td class="timeline-cell" colspan="6"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // View switching
    function switchView(view) {
        const releaseTab = document.querySelector('.view-tab:nth-child(1)');
        const progressTab = document.querySelector('.view-tab:nth-child(2)');
        const releaseContent = document.getElementById('releaseContent');
        const progressContent = document.getElementById('progressContent');
        
        if (view === 'release') {
            releaseTab.classList.add('active');
            progressTab.classList.remove('active');
            releaseContent.classList.add('active');
            progressContent.classList.remove('active');
        } else {
            releaseTab.classList.remove('active');
            progressTab.classList.add('active');
            releaseContent.classList.remove('active');
            progressContent.classList.add('active');
        }
    }
    
    // Toggle category expansion
    function toggleCategory(element) {
        const categoryItems = element.nextElementSibling;
        const toggle = element.querySelector('.category-toggle');
        
        if (categoryItems.classList.contains('expanded')) {
            categoryItems.classList.remove('expanded');
            toggle.style.transform = 'rotate(0deg)';
        } else {
            categoryItems.classList.add('expanded');
            toggle.style.transform = 'rotate(180deg)';
        }
    }
    
    // Expand/collapse all categories
    document.querySelectorAll('.all-categories-btn').forEach((btn, index) => {
        btn.addEventListener('click', () => {
            const categoryItems = document.querySelectorAll('.category-items');
            const toggles = document.querySelectorAll('.category-toggle');
            
            if (index === 0) { // Expand all
                categoryItems.forEach(item => item.classList.add('expanded'));
                toggles.forEach(toggle => toggle.style.transform = 'rotate(180deg)');
            } else { // Collapse all
                categoryItems.forEach(item => item.classList.remove('expanded'));
                toggles.forEach(toggle => toggle.style.transform = 'rotate(0deg)');
            }
        });
    });
    
    // Switch tracker view (teams/deliverables)
    function switchTrackerView(view) {
        const tabs = document.querySelectorAll('.tracker-controls .view-tab');
        tabs.forEach(tab => tab.classList.remove('active'));
        
        if (view === 'teams') {
            tabs[0].classList.add('active');
        } else {
            tabs[1].classList.add('active');
        }
        
        // In a real implementation, you would update the table content here
    }
    
    // Navigate timeline
    function navigateTime(direction) {
        const currentPeriod = document.querySelector('.current-period');
        const periods = ['Q1 2025', 'Q2 2025', 'Q3 2025', 'Q4 2025', 'Q1 2026'];
        const currentIndex = periods.indexOf(currentPeriod.textContent);
        
        if (direction === 'prev' && currentIndex > 0) {
            currentPeriod.textContent = periods[currentIndex - 1];
        } else if (direction === 'next' && currentIndex < periods.length - 1) {
            currentPeriod.textContent = periods[currentIndex + 1];
        }
        
        // In a real implementation, you would update the timeline data here
    }
    
    // Toggle team expansion (for more details)
    document.querySelectorAll('.team-name').forEach(team => {
        team.addEventListener('click', () => {
            const row = team.closest('.team-row');
            const icon = team.querySelector('.toggle-icon');
            
            if (row.classList.contains('expanded')) {
                row.classList.remove('expanded');
                icon.textContent = '▶';
            } else {
                row.classList.add('expanded');
                icon.textContent = '▼';
                
                // In a real implementation, you would dynamically add detail rows here
            }
        });
    });
    
    // Show tooltip on hover for deliverable bars
    document.querySelectorAll('.deliverable-bar').forEach(bar => {
        bar.addEventListener('mouseenter', () => {
            const tooltip = bar.querySelector('.tooltip-content');
            tooltip.style.visibility = 'visible';
            tooltip.style.opacity = '1';
        });
        
        bar.addEventListener('mouseleave', () => {
            const tooltip = bar.querySelector('.tooltip-content');
            tooltip.style.visibility = 'hidden';
            tooltip.style.opacity = '0';
        });
    });
    
    // Add responsive handling for small screens
    function handleResponsive() {
        if (window.innerWidth <= 768) {
            // Adjust table view for mobile
            document.querySelector('.tracker-table-container').style.overflowX = 'auto';
        } else {
            document.querySelector('.tracker-table-container').style.overflowX = 'visible';
        }
    }
    
    // Run on page load and window resize
    window.addEventListener('load', handleResponsive);
    window.addEventListener('resize', handleResponsive);
    
    // Initialize with some expanded categories for demonstration
    document.querySelectorAll('.category-header').forEach((header, index) => {
        if (index % 3 === 0) { // Expand every third category for demo
            toggleCategory(header);
        }
    });
</script>
</body>
</html>