<?php
/**
 * Music Producer Project Tracker - Display & Analysis
 * Shows detailed project analysis and statistics
 */

session_start();
require_once 'functions.php';

// Get project to display
$projectIndex = $_SESSION['lastProjectIndex'] ?? null;
$mode = $_GET['mode'] ?? 'project';
$project = null;

if ($mode === 'project' && isset($_SESSION['projects'][$projectIndex])) {
    $project = $_SESSION['projects'][$projectIndex];
}

// Display message if available
$message = $_SESSION['message'] ?? '';
$messageType = $_SESSION['messageType'] ?? 'info';

// Clear message after display
unset($_SESSION['message']);
unset($_SESSION['messageType']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Analysis - Music Producer Tracker</title>
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
            max-width: 1000px;
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
            font-size: 2em;
            margin-bottom: 10px;
        }

        .content {
            padding: 40px;
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

        .project-title {
            font-size: 2em;
            color: #333;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
        }

        .status-on-pace {
            background: #d4edda;
            color: #155724;
        }

        .status-behind {
            background: #f8d7da;
            color: #721c24;
        }

        .metadata {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .metadata-item {
            text-align: center;
        }

        .metadata-label {
            font-size: 0.85em;
            color: #666;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .metadata-value {
            font-size: 1.3em;
            color: #667eea;
            font-weight: 700;
        }

        @media (max-width: 800px) {
            .metadata {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #667eea;
        }

        .statistics-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            border-left: 5px solid #667eea;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-label {
            font-size: 0.9em;
            color: #666;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 2em;
            color: #667eea;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-subtext {
            font-size: 0.85em;
            color: #999;
            font-style: italic;
        }

        @media (max-width: 700px) {
            .statistics-grid {
                grid-template-columns: 1fr;
            }
        }

        .progress-container {
            margin-bottom: 20px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .progress-bar {
            background: #e0e0e0;
            height: 20px;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75em;
            font-weight: 700;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th {
            background: #f5f5f5;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #ddd;
        }

        .table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        .table tr:hover {
            background: #f9f9f9;
        }

        .table-row-highlight {
            background: #fffbea;
        }

        .recommendation {
            background: linear-gradient(135deg, #fff5e1 0%, #ffe6cc 100%);
            padding: 20px;
            border-radius: 8px;
            border-left: 5px solid #ff9800;
            margin-bottom: 20px;
        }

        .recommendation-title {
            font-weight: 700;
            color: #e65100;
            margin-bottom: 10px;
        }

        .recommendation-text {
            color: #5d4c3b;
            line-height: 1.6;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        button {
            padding: 12px 25px;
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

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
        }

        .divider {
            border-top: 2px solid #e0e0e0;
            margin: 30px 0;
        }

        .track-list {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-top: 15px;
        }

        .track-item {
            padding: 10px;
            background: white;
            margin-bottom: 8px;
            border-radius: 3px;
            border-left: 4px solid #667eea;
        }

        .track-item.completed {
            border-left-color: #28a745;
            background: #f0fdf4;
        }

        .track-item.remaining {
            border-left-color: #ffc107;
            background: #fffbf0;
        }

        .file-content {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
            line-height: 1.6;
            white-space: pre-wrap;
            word-wrap: break-word;
            max-height: 600px;
            overflow-y: auto;
            border-left: 4px solid #667eea;
        }

        .notes-section {
            background: #f0f4ff;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            border-left: 4px solid #667eea;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state-icon {
            font-size: 3em;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Project Analysis</h1>
            <p>Detailed breakdown and recommendations</p>
        </div>

        <div class="content">
            <?php if ($message): ?>
                <div class="alert alert-<?php echo htmlspecialchars($messageType); ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <?php if ($mode === 'view-file' && isset($_SESSION['loadedFileContent'])): ?>
                <!-- Loaded File View -->
                <h2><?php echo htmlspecialchars($_SESSION['loadedFileName'] ?? 'Project File'); ?></h2>
                
                <div class="file-content">
                    <?php echo htmlspecialchars($_SESSION['loadedFileContent']); ?>
                </div>

                <div class="button-group">
                    <form method="GET" action="index.php" style="display: inline;">
                        <button type="submit" class="btn-primary">← Back to Main</button>
                    </form>
                    <form method="POST" action="process.php" style="display: inline;">
                        <input type="hidden" name="filename" value="<?php echo htmlspecialchars($_SESSION['loadedFileName'] ?? ''); ?>">
                        <button type="submit" name="action" value="downloadfile" class="btn-secondary">
                            ⬇️ Download File
                        </button>
                    </form>
                </div>

            <?php elseif ($project): ?>
                <!-- Project Analysis View -->
                <div class="project-title">
                    🎵 <?php echo htmlspecialchars($project['projectName']); ?>
                    <span class="status-badge <?php echo $project['isOnPace'] ? 'status-on-pace' : 'status-behind'; ?>">
                        <?php echo $project['isOnPace'] ? '✓ ON PACE' : '⚠ BEHIND PACE'; ?>
                    </span>
                </div>

                <div class="metadata">
                    <div class="metadata-item">
                        <div class="metadata-label">Artist</div>
                        <div class="metadata-value"><?php echo htmlspecialchars($project['artist']); ?></div>
                    </div>
                    <div class="metadata-item">
                        <div class="metadata-label">Genre</div>
                        <div class="metadata-value"><?php echo htmlspecialchars($project['genre']); ?></div>
                    </div>
                    <div class="metadata-item">
                        <div class="metadata-label">Created</div>
                        <div class="metadata-value"><?php echo date('M d', strtotime($project['dateCreated'])); ?></div>
                    </div>
                    <div class="metadata-item">
                        <div class="metadata-label">Completion</div>
                        <div class="metadata-value"><?php echo formatPercentage($project['completionPercentage']); ?></div>
                    </div>
                </div>

                <!-- Progress Section -->
                <div class="section">
                    <div class="section-title">📈 Project Progress</div>
                    
                    <div class="progress-container">
                        <div class="progress-label">
                            <span>Track Recording Progress</span>
                            <span><?php echo $project['tracksRecorded']; ?> / <?php echo $project['totalPlanned']; ?> tracks</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo $project['completionPercentage']; ?>%">
                                <?php if ($project['completionPercentage'] > 10): ?>
                                    <?php echo formatPercentage($project['completionPercentage']); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="progress-container">
                        <div class="progress-label">
                            <span>Time Allocation</span>
                            <span><?php echo formatHours($project['hoursSpent']); ?> / <?php echo formatHours($project['targetHours']); ?></span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo min(100, ($project['hoursSpent'] / $project['targetHours']) * 100); ?>%">
                                <?php if (($project['hoursSpent'] / $project['targetHours']) * 100 > 10): ?>
                                    <?php echo round(($project['hoursSpent'] / $project['targetHours']) * 100, 1); ?>%
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Key Metrics -->
                <div class="section">
                    <div class="section-title">📊 Key Metrics</div>
                    
                    <div class="statistics-grid">
                        <div class="stat-card">
                            <div class="stat-label">Average Time Per Track</div>
                            <div class="stat-value"><?php echo formatHours($project['avgTimePerTrack']); ?></div>
                            <div class="stat-subtext">Time spent on average</div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-label">Required Speed (Remaining)</div>
                            <div class="stat-value"><?php echo formatHours($project['requiredSpeed']); ?></div>
                            <div class="stat-subtext">Per track to meet target</div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-label">Estimated Time Remaining</div>
                            <div class="stat-value"><?php echo formatHours($project['estimatedTimeRemaining']); ?></div>
                            <div class="stat-subtext">Based on current pace</div>
                        </div>
                    </div>

                    <?php 
                        $totalEstimated = $project['hoursSpent'] + $project['estimatedTimeRemaining'];
                        $timeOverTarget = $totalEstimated - $project['targetHours'];
                    ?>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Metric</th>
                                <th>Value</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Hours Spent</td>
                                <td><?php echo formatHours($project['hoursSpent']); ?></td>
                                <td>✓ Tracked</td>
                            </tr>
                            <tr>
                                <td>Target Hours</td>
                                <td><?php echo formatHours($project['targetHours']); ?></td>
                                <td>🎯 Goal</td>
                            </tr>
                            <tr>
                                <td>Estimated Total Time</td>
                                <td><?php echo formatHours($totalEstimated); ?></td>
                                <td><?php echo $project['isOnPace'] ? '✓ Within Target' : '⚠ Over Target'; ?></td>
                            </tr>
                            <tr <?php echo $timeOverTarget > 0 ? 'class="table-row-highlight"' : ''; ?>>
                                <td>Time Difference</td>
                                <td><?php echo $timeOverTarget > 0 ? '+' . formatHours($timeOverTarget) : formatHours(abs($timeOverTarget)); ?></td>
                                <td><?php echo $timeOverTarget > 0 ? '⚠ Over' : '✓ Under'; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Track List -->
                <div class="section">
                    <div class="section-title">🎵 Track Overview</div>
                    
                    <div class="track-list">
                        <?php for ($i = 1; $i <= $project['totalPlanned']; $i++): ?>
                            <?php $isCompleted = $i <= $project['tracksRecorded']; ?>
                            <div class="track-item <?php echo $isCompleted ? 'completed' : 'remaining'; ?>">
                                <strong><?php echo formatTrackName($project['projectName'], $i); ?></strong>
                                <span style="float: right; color: #999;">
                                    <?php echo $isCompleted ? '✓ Recorded' : '⏳ Pending'; ?>
                                </span>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="section">
                    <div class="section-title">💡 Recommendations</div>
                    
                    <?php if ($project['isOnPace']): ?>
                        <div class="recommendation">
                            <div class="recommendation-title">✓ Great News!</div>
                            <div class="recommendation-text">
                                Your project is on pace to meet the target deadline. At your current rate of 
                                <strong><?php echo formatHours($project['avgTimePerTrack']); ?> per track</strong>, 
                                you will complete the remaining 
                                <strong><?php echo $project['totalPlanned'] - $project['tracksRecorded']; ?> tracks</strong> 
                                within your target of 
                                <strong><?php echo formatHours($project['targetHours']); ?></strong>. 
                                Keep up the excellent work!
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="recommendation">
                            <div class="recommendation-title">⚠️ Pace Alert</div>
                            <div class="recommendation-text">
                                Your project is currently behind pace. You've spent 
                                <strong><?php echo formatHours($project['hoursSpent']); ?></strong> so far 
                                and have <strong><?php echo $project['totalPlanned'] - $project['tracksRecorded']; ?> tracks</strong> remaining.
                                <br><br>
                                To meet your target of <strong><?php echo formatHours($project['targetHours']); ?></strong>, 
                                you need to average <strong><?php echo formatHours($project['requiredSpeed']); ?> per track</strong> 
                                for the remaining tracks. Your current rate is 
                                <strong><?php echo formatHours($project['avgTimePerTrack']); ?> per track</strong>.
                                <br><br>
                                <strong>Options:</strong>
                                <ul style="margin-top: 10px; margin-left: 20px;">
                                    <li>Increase recording efficiency to achieve the required speed</li>
                                    <li>Extend your target deadline</li>
                                    <li>Allocate more studio hours per week</li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($project['tracksRecorded'] == 0): ?>
                        <div class="recommendation">
                            <div class="recommendation-title">ℹ️ Getting Started</div>
                            <div class="recommendation-text">
                                You have <strong><?php echo $project['totalPlanned']; ?> tracks</strong> planned for this project 
                                with a target of <strong><?php echo formatHours($project['targetHours']); ?></strong>.
                                Once you start recording, this tracker will provide detailed analytics on your progress.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Notes -->
                <?php if (!empty($project['notes'])): ?>
                    <div class="section">
                        <div class="section-title">📝 Project Notes</div>
                        <div class="notes-section">
                            <?php echo htmlspecialchars($project['notes']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Historical Data / Multidimensional Array Display -->
                <div class="section">
                    <div class="section-title">📚 Historical Data Structure</div>
                    
                    <?php 
                        $historicalData = generateHistoricalData($_SESSION['projects']);
                    ?>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Album</th>
                                <th>Artist</th>
                                <th>Tracks</th>
                                <th>Completion</th>
                                <th>Avg Time/Track</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($historicalData['albums'] as $album): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($album['projectName']); ?></td>
                                    <td><?php echo htmlspecialchars($album['artist']); ?></td>
                                    <td><?php echo $album['tracks']['recorded']; ?>/<?php echo $album['totalTracks']; ?></td>
                                    <td><?php echo formatPercentage($album['metrics']['completion']); ?></td>
                                    <td><?php echo formatHours($album['metrics']['avgTimePerTrack']); ?></td>
                                    <td><?php echo $album['metrics']['isOnPace'] ? '✓ On Pace' : '⚠ Behind'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div style="margin-top: 20px; background: #f5f5f5; padding: 15px; border-radius: 5px;">
                        <strong>Historical Summary:</strong>
                        <ul style="margin-top: 10px; margin-left: 20px;">
                            <li>Total Projects: <?php echo $historicalData['totalProjects']; ?></li>
                            <li>Total Hours Recorded: <?php echo formatHours($historicalData['totalHoursRecorded']); ?></li>
                            <li>Average Completion Time: <?php echo formatHours($historicalData['averageCompletionTime']); ?></li>
                        </ul>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="divider"></div>
                <div class="button-group">
                    <form method="GET" action="index.php" style="display: inline;">
                        <button type="submit" class="btn-primary">← Back to Main</button>
                    </form>
                    <form method="POST" action="process.php" style="display: inline;">
                        <input type="hidden" name="projectIndex" value="<?php echo $projectIndex; ?>">
                        <button type="submit" name="action" value="delete" class="btn-secondary"
                                onclick="return confirm('Delete this project?');">
                            🗑️ Delete Project
                        </button>
                    </form>
                    <form method="POST" action="process.php" style="display: inline;">
                        <button type="submit" name="action" value="savesession" class="btn-primary">
                            💾 Save to File
                        </button>
                    </form>
                </div>

            <?php else: ?>
                <!-- No Project Found -->
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <h2>No Project Selected</h2>
                    <p>Please create or select a project to view details.</p>
                    <div class="button-group" style="justify-content: center; margin-top: 30px;">
                        <form method="GET" action="index.php" style="display: inline;">
                            <button type="submit" class="btn-primary">← Back to Main</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
