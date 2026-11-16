<?php
/**
 * Music Producer Project Tracker - Main Interface
 * Displays form for project creation and manages sessions
 */

session_start();
require_once 'functions.php';

// Directory for data storage
$dataDir = __DIR__ . '/Data';

// Initialize projects array in session
if (!isset($_SESSION['projects'])) {
    $_SESSION['projects'] = [];
}

// Handle file upload
$uploadMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploadFile'])) {
    if ($_FILES['uploadFile']['error'] === UPLOAD_ERR_OK) {
        $uploadedFile = $_FILES['uploadFile']['tmp_name'];
        $uploadedFileName = basename($_FILES['uploadFile']['name']);
        
        // Validate file is a txt file
        if (pathinfo($uploadedFileName, PATHINFO_EXTENSION) === 'txt') {
            $targetPath = $dataDir . '/' . $uploadedFileName;
            if (move_uploaded_file($uploadedFile, $targetPath)) {
                $uploadMessage = "<div class='alert alert-success'>File uploaded successfully!</div>";
            } else {
                $uploadMessage = "<div class='alert alert-error'>Failed to upload file.</div>";
            }
        } else {
            $uploadMessage = "<div class='alert alert-error'>Only .txt files are allowed.</div>";
        }
    } else {
        $uploadMessage = "<div class='alert alert-error'>File upload error. Please try again.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Producer Project Tracker</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.95;
        }

        .content {
            padding: 40px;
        }

        .tabs {
            display: flex;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 30px;
            gap: 0;
        }

        .tab-button {
            padding: 12px 25px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1em;
            color: #666;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .tab-button:hover {
            color: #667eea;
        }

        .tab-button.active {
            color: #667eea;
            border-bottom-color: #667eea;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 0.95em;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            font-family: inherit;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="file"]:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .required {
            color: #e74c3c;
        }

        button {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #f5c6cb;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #bee5eb;
        }

        .file-list {
            margin-top: 20px;
        }

        .file-item {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 4px solid #667eea;
        }

        .file-item-name {
            font-weight: 600;
            color: #333;
        }

        .file-item-actions {
            display: flex;
            gap: 10px;
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 0.85em;
        }

        .projects-summary {
            background: #f0f4ff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .project-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 5px solid #667eea;
        }

        .project-title {
            font-size: 1.2em;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .project-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            font-size: 0.9em;
            color: #666;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
        }

        .info-label {
            font-weight: 600;
        }

        .info-value {
            color: #667eea;
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .divider {
            border-top: 2px solid #e0e0e0;
            margin: 30px 0;
        }

        .helper-text {
            font-size: 0.85em;
            color: #888;
            margin-top: 5px;
            font-style: italic;
        }

        .no-data-message {
            text-align: center;
            padding: 40px 20px;
            color: #999;
            background: #f9f9f9;
            border-radius: 5px;
        }

        .progress-bar {
            background: #e0e0e0;
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 5px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s ease;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 600;
            margin-top: 8px;
        }

        .status-on-pace {
            background: #d4edda;
            color: #155724;
        }

        .status-behind {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎵 Music Producer Project Tracker</h1>
            <p>Manage and track your recording projects efficiently</p>
        </div>

        <div class="content">
            <div class="tabs">
                <button class="tab-button active" onclick="switchTab('new-project')">New Project</button>
                <button class="tab-button" onclick="switchTab('session-projects')">Session Projects</button>
                <button class="tab-button" onclick="switchTab('upload-files')">Manage Files</button>
            </div>

            <!-- New Project Tab -->
            <div class="tab-content active" id="new-project">
                <h2>Create New Project</h2>
                <p class="helper-text" style="margin-top: 10px; margin-bottom: 20px;">Enter your project details below. All fields marked with <span class="required">*</span> are required.</p>

                <form method="POST" action="process.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="projectName">Project Name <span class="required">*</span></label>
                            <input type="text" id="projectName" name="projectName" required 
                                   placeholder="e.g., My Album 2026">
                        </div>
                        <div class="form-group">
                            <label for="artist">Artist Name</label>
                            <input type="text" id="artist" name="artist" placeholder="e.g., John Doe">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="genre">Genre</label>
                            <input type="text" id="genre" name="genre" placeholder="e.g., Hip-Hop, Pop, Jazz">
                        </div>
                        <div class="form-group">
                            <label for="totalPlanned">Total Planned Tracks <span class="required">*</span></label>
                            <input type="number" id="totalPlanned" name="totalPlanned" required min="1"
                                   placeholder="e.g., 12">
                            <div class="helper-text">Total number of tracks for this project</div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="tracksRecorded">Tracks Already Recorded <span class="required">*</span></label>
                            <input type="number" id="tracksRecorded" name="tracksRecorded" required min="0"
                                   placeholder="e.g., 3">
                            <div class="helper-text">How many tracks have you completed?</div>
                        </div>
                        <div class="form-group">
                            <label for="hoursSpent">Total Studio Hours Spent <span class="required">*</span></label>
                            <input type="number" id="hoursSpent" name="hoursSpent" required min="0" step="0.5"
                                   placeholder="e.g., 15.5">
                            <div class="helper-text">Total hours spent in the studio so far</div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="targetHours">Target Completion Time (Hours) <span class="required">*</span></label>
                            <input type="number" id="targetHours" name="targetHours" required min="0.1" step="0.5"
                                   placeholder="e.g., 100">
                            <div class="helper-text">Total hours you want to spend on this project</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Recording Notes</label>
                        <textarea id="notes" name="notes" placeholder="Add any notes about this project..."></textarea>
                        <div class="helper-text">Optional: Track progress, issues, or observations</div>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%; padding: 15px;">
                        📊 Analyze Project & Save
                    </button>
                </form>
            </div>

            <!-- Session Projects Tab -->
            <div class="tab-content" id="session-projects">
                <h2>Current Session Projects</h2>
                
                <?php if (empty($_SESSION['projects'])): ?>
                    <div class="no-data-message">
                        <p>No projects in current session yet.</p>
                        <p>Create a new project using the "New Project" tab to get started!</p>
                    </div>
                <?php else: ?>
                    <div class="projects-summary">
                        <strong>Session Summary:</strong> 
                        <?php echo count($_SESSION['projects']); ?> project(s) in session
                    </div>

                    <?php foreach ($_SESSION['projects'] as $index => $project): ?>
                        <div class="project-card">
                            <div class="project-title">
                                <?php echo htmlspecialchars($project['projectName']); ?>
                                <span class="status-badge <?php echo $project['isOnPace'] ? 'status-on-pace' : 'status-behind'; ?>">
                                    <?php echo $project['isOnPace'] ? '✓ ON PACE' : '⚠ BEHIND PACE'; ?>
                                </span>
                            </div>
                            
                            <div class="project-info">
                                <div class="info-item">
                                    <span class="info-label">Artist:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($project['artist']); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Genre:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($project['genre']); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Completion:</span>
                                    <span class="info-value"><?php echo formatPercentage($project['completionPercentage']); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Progress:</span>
                                    <span class="info-value"><?php echo $project['tracksRecorded']; ?>/<?php echo $project['totalPlanned']; ?> tracks</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Hours Spent:</span>
                                    <span class="info-value"><?php echo formatHours($project['hoursSpent']); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Target Hours:</span>
                                    <span class="info-value"><?php echo formatHours($project['targetHours']); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Avg Time/Track:</span>
                                    <span class="info-value"><?php echo formatHours($project['avgTimePerTrack']); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Required Speed:</span>
                                    <span class="info-value"><?php echo formatHours($project['requiredSpeed']); ?></span>
                                </div>
                            </div>

                            <div style="margin-top: 15px;">
                                <strong>Completion Progress:</strong>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?php echo $project['completionPercentage']; ?>%"></div>
                                </div>
                            </div>

                            <?php if (!empty($project['notes'])): ?>
                                <div style="margin-top: 10px; padding: 10px; background: #f9f9f9; border-radius: 3px; font-size: 0.9em;">
                                    <strong>Notes:</strong> <?php echo htmlspecialchars($project['notes']); ?>
                                </div>
                            <?php endif; ?>

                            <div class="action-buttons">
                                <form method="POST" action="process.php" style="display: inline;">
                                    <input type="hidden" name="projectIndex" value="<?php echo $index; ?>">
                                    <button type="submit" name="action" value="viewdetails" class="btn-primary btn-small">
                                        📈 View Details
                                    </button>
                                </form>
                                <form method="POST" action="process.php" style="display: inline;">
                                    <input type="hidden" name="projectIndex" value="<?php echo $index; ?>">
                                    <button type="submit" name="action" value="delete" class="btn-secondary btn-small"
                                            onclick="return confirm('Are you sure you want to delete this project?');">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="divider" style="margin-top: 30px;"></div>
                    
                    <form method="POST" action="process.php" style="display: inline;">
                        <button type="submit" name="action" value="savesession" class="btn-primary">
                            💾 Save All Session Projects to File
                        </button>
                        <button type="submit" name="action" value="clearsession" class="btn-secondary"
                                onclick="return confirm('Clear all projects from session? This cannot be undone.');"
                                style="margin-left: 10px;">
                            🔄 Clear Session
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Upload Files Tab -->
            <div class="tab-content" id="upload-files">
                <h2>Manage Project Files</h2>

                <?php echo $uploadMessage; ?>

                <div class="form-group" style="margin-top: 20px;">
                    <label for="uploadFile">Upload Project File (.txt)</label>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="file" id="uploadFile" name="uploadFile" accept=".txt" required>
                        <button type="submit" class="btn-primary" style="width: 100%; margin-top: 10px;">
                            📤 Upload File
                        </button>
                    </form>
                </div>

                <div class="divider"></div>

                <h3>Available Project Files</h3>
                
                <?php 
                $files = getAvailableProjectFiles($dataDir);
                if (empty($files)): 
                ?>
                    <div class="no-data-message">
                        <p>No project files available yet.</p>
                        <p>Save a project to create the first file!</p>
                    </div>
                <?php else: ?>
                    <div class="file-list">
                        <?php foreach ($files as $file): ?>
                            <div class="file-item">
                                <div class="file-item-name">📄 <?php echo htmlspecialchars($file); ?></div>
                                <div class="file-item-actions">
                                    <form method="POST" action="process.php" style="display: inline;">
                                        <input type="hidden" name="filename" value="<?php echo htmlspecialchars($file); ?>">
                                        <button type="submit" name="action" value="loadfile" class="btn-primary btn-small">
                                            📖 Load
                                        </button>
                                    </form>
                                    <form method="POST" action="process.php" style="display: inline;">
                                        <input type="hidden" name="filename" value="<?php echo htmlspecialchars($file); ?>">
                                        <button type="submit" name="action" value="downloadfile" class="btn-secondary btn-small">
                                            ⬇️ Download
                                        </button>
                                    </form>
                                    <form method="POST" action="process.php" style="display: inline;">
                                        <input type="hidden" name="filename" value="<?php echo htmlspecialchars($file); ?>">
                                        <button type="submit" name="action" value="deletefile" class="btn-secondary btn-small"
                                                onclick="return confirm('Delete this file permanently?');">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => content.classList.remove('active'));

            // Deactivate all tab buttons
            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(button => button.classList.remove('active'));

            // Show selected tab content
            document.getElementById(tabName).classList.add('active');

            // Activate clicked button
            event.target.classList.add('active');
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const totalPlanned = parseInt(document.getElementById('totalPlanned').value);
            const tracksRecorded = parseInt(document.getElementById('tracksRecorded').value);
            const hoursSpent = parseFloat(document.getElementById('hoursSpent').value);
            const targetHours = parseFloat(document.getElementById('targetHours').value);

            if (tracksRecorded > totalPlanned) {
                e.preventDefault();
                alert('Tracks recorded cannot exceed total planned tracks!');
            }

            if (hoursSpent > targetHours) {
                const proceed = confirm('You have already spent more hours than your target. Continue anyway?');
                if (!proceed) {
                    e.preventDefault();
                }
            }
        });
    </script>
</body>
</html>
