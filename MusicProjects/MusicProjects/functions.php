<?php
/**
 * Music Producer Project Tracker - Functions
 * Contains all calculation, data manipulation, and formatting functions
 */

// ============================================================================
// CALCULATION FUNCTIONS
// ============================================================================

/**
 * Calculate average time spent per track
 * 
 * @param float $totalHours Total studio hours spent
 * @param int $tracksRecorded Number of tracks recorded
 * @return float Average hours per track (0 if no tracks recorded)
 */
function calculateAverageTimePerTrack($totalHours, $tracksRecorded) {
    if ($tracksRecorded == 0) {
        return 0;
    }
    return round($totalHours / $tracksRecorded, 2);
}

/**
 * Calculate required average recording speed to finish on time
 * 
 * @param int $totalPlanned Total number of tracks planned
 * @param int $tracksRecorded Number of tracks already recorded
 * @param float $targetHours Target hours to complete project
 * @param float $hoursSpent Hours already spent
 * @return float Required hours per track remaining (0 if already exceeded time)
 */
function calculateRequiredRecordingSpeed($totalPlanned, $tracksRecorded, $targetHours, $hoursSpent) {
    $tracksRemaining = $totalPlanned - $tracksRecorded;
    
    if ($tracksRemaining <= 0) {
        return 0; // Project complete
    }
    
    $hoursRemaining = $targetHours - $hoursSpent;
    
    if ($hoursRemaining <= 0) {
        return -1; // Target time exceeded
    }
    
    return round($hoursRemaining / $tracksRemaining, 2);
}

/**
 * Calculate project completion percentage
 * 
 * @param int $tracksRecorded Number of tracks recorded
 * @param int $totalPlanned Total number of tracks planned
 * @return float Completion percentage (0-100)
 */
function calculateCompletionPercentage($tracksRecorded, $totalPlanned) {
    if ($totalPlanned == 0) {
        return 0;
    }
    return round(($tracksRecorded / $totalPlanned) * 100, 2);
}

/**
 * Calculate estimated remaining time needed
 * 
 * @param int $totalPlanned Total planned tracks
 * @param int $tracksRecorded Recorded tracks
 * @param float $avgTimePerTrack Average hours per track
 * @return float Estimated remaining hours
 */
function calculateEstimatedTimeRemaining($totalPlanned, $tracksRecorded, $avgTimePerTrack) {
    $tracksRemaining = $totalPlanned - $tracksRecorded;
    return round($tracksRemaining * $avgTimePerTrack, 2);
}

/**
 * Calculate if project is on pace to meet target
 * 
 * @param float $targetHours Target hours
 * @param float $hoursSpent Hours already spent
 * @param float $estimatedTimeRemaining Estimated time remaining
 * @return bool True if on pace, false if exceeding target
 */
function isOnPace($targetHours, $hoursSpent, $estimatedTimeRemaining) {
    return ($hoursSpent + $estimatedTimeRemaining) <= $targetHours;
}

// ============================================================================
// DATA VALIDATION FUNCTIONS
// ============================================================================

/**
 * Validate user input for project data
 * 
 * @param array $data Input data to validate
 * @return array Array with 'valid' boolean and 'errors' array of error messages
 */
function validateProjectInput($data) {
    $errors = [];
    
    // Validate project name
    if (empty($data['projectName'] ?? '')) {
        $errors[] = "Project name is required.";
    } elseif (strlen($data['projectName']) > 100) {
        $errors[] = "Project name cannot exceed 100 characters.";
    }
    
    // Validate total planned tracks
    $totalPlanned = $data['totalPlanned'] ?? null;
    if (!is_numeric($totalPlanned) || $totalPlanned <= 0) {
        $errors[] = "Total planned tracks must be a positive number.";
    } elseif (intval($totalPlanned) != $totalPlanned) {
        $errors[] = "Total planned tracks must be a whole number.";
    }
    
    // Validate tracks recorded
    $tracksRecorded = $data['tracksRecorded'] ?? null;
    if (!is_numeric($tracksRecorded) || $tracksRecorded < 0) {
        $errors[] = "Tracks recorded must be a non-negative number.";
    } elseif (intval($tracksRecorded) != $tracksRecorded) {
        $errors[] = "Tracks recorded must be a whole number.";
    }
    
    // Validate tracks recorded doesn't exceed total planned
    if (is_numeric($tracksRecorded) && is_numeric($totalPlanned)) {
        if ($tracksRecorded > $totalPlanned) {
            $errors[] = "Tracks recorded cannot exceed total planned tracks.";
        }
    }
    
    // Validate total hours spent
    $hoursSpent = $data['hoursSpent'] ?? null;
    if (!is_numeric($hoursSpent) || $hoursSpent < 0) {
        $errors[] = "Total hours spent must be a non-negative number.";
    }
    
    // Validate target hours
    $targetHours = $data['targetHours'] ?? null;
    if (!is_numeric($targetHours) || $targetHours <= 0) {
        $errors[] = "Target hours must be a positive number.";
    }
    
    // Validate genre (optional but should be reasonable)
    if (!empty($data['genre'] ?? '') && strlen($data['genre']) > 50) {
        $errors[] = "Genre cannot exceed 50 characters.";
    }
    
    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

// ============================================================================
// STRING FORMATTING FUNCTIONS
// ============================================================================

/**
 * Format track name with proper styling
 * 
 * @param string $projectName Project name
 * @param int $trackNumber Track number
 * @return string Formatted track name
 */
function formatTrackName($projectName, $trackNumber) {
    return htmlspecialchars("$projectName - Track $trackNumber");
}

/**
 * Format hours to readable format (X hours Y minutes)
 * 
 * @param float $hours Decimal hours
 * @return string Formatted time string
 */
function formatHours($hours) {
    $wholeHours = floor($hours);
    $minutes = round(($hours - $wholeHours) * 60);
    
    if ($wholeHours == 0) {
        return "{$minutes} min";
    } elseif ($minutes == 0) {
        return "{$wholeHours} hr";
    }
    
    return "{$wholeHours} hr {$minutes} min";
}

/**
 * Format percentage with symbol
 * 
 * @param float $percentage Percentage value
 * @return string Formatted percentage
 */
function formatPercentage($percentage) {
    return round($percentage, 1) . "%";
}

/**
 * Format status message based on project metrics
 * 
 * @param bool $isOnPace Whether project is on pace
 * @param float $avgRequired Required avg speed
 * @param float $avgActual Actual avg speed
 * @return string Status message
 */
function formatStatusMessage($isOnPace, $avgRequired, $avgActual) {
    if ($isOnPace) {
        return "✓ Project is ON PACE to meet target deadline!";
    } else {
        if ($avgActual > $avgRequired) {
            $difference = round($avgActual - $avgRequired, 2);
            return "⚠ Project is BEHIND PACE. Need to increase speed by {$difference} hr/track.";
        } else {
            return "⚠ Project is BEHIND PACE. Adjust recording speed or extend target timeline.";
        }
    }
}

/**
 * Create summary statistics display
 * 
 * @param array $statistics Array of statistics
 * @return string HTML formatted statistics
 */
function formatStatisticsSummary($statistics) {
    $html = "<table class='statistics-table'>\n";
    $html .= "<tr><th>Metric</th><th>Value</th></tr>\n";
    
    foreach ($statistics as $label => $value) {
        $html .= "<tr><td>" . htmlspecialchars($label) . "</td>";
        $html .= "<td>" . htmlspecialchars($value) . "</td></tr>\n";
    }
    
    $html .= "</table>\n";
    return $html;
}

// ============================================================================
// DATA MANIPULATION FUNCTIONS
// ============================================================================

/**
 * Create a new project record
 * 
 * @param array $input User input data
 * @return array Project record
 */
function createProjectRecord($input) {
    return [
        'projectName' => htmlspecialchars($input['projectName']),
        'genre' => htmlspecialchars($input['genre'] ?? 'Unspecified'),
        'artist' => htmlspecialchars($input['artist'] ?? 'Unknown Artist'),
        'totalPlanned' => intval($input['totalPlanned']),
        'tracksRecorded' => intval($input['tracksRecorded']),
        'hoursSpent' => floatval($input['hoursSpent']),
        'targetHours' => floatval($input['targetHours']),
        'notes' => htmlspecialchars($input['notes'] ?? ''),
        'dateCreated' => date('Y-m-d H:i:s'),
        'completionPercentage' => 0,
        'avgTimePerTrack' => 0,
        'requiredSpeed' => 0
    ];
}

/**
 * Add calculations to project record
 * 
 * @param array $project Project record
 * @return array Project record with calculations
 */
function addCalculationsToProject($project) {
    $project['completionPercentage'] = calculateCompletionPercentage(
        $project['tracksRecorded'],
        $project['totalPlanned']
    );
    
    $project['avgTimePerTrack'] = calculateAverageTimePerTrack(
        $project['hoursSpent'],
        $project['tracksRecorded']
    );
    
    $project['requiredSpeed'] = calculateRequiredRecordingSpeed(
        $project['totalPlanned'],
        $project['tracksRecorded'],
        $project['targetHours'],
        $project['hoursSpent']
    );
    
    $project['estimatedTimeRemaining'] = calculateEstimatedTimeRemaining(
        $project['totalPlanned'],
        $project['tracksRecorded'],
        $project['avgTimePerTrack']
    );
    
    $project['isOnPace'] = isOnPace(
        $project['targetHours'],
        $project['hoursSpent'],
        $project['estimatedTimeRemaining']
    );
    
    return $project;
}

/**
 * Generate historical data multidimensional array for multiple projects
 * 
 * @param array $projects Array of project records
 * @return array Multidimensional array with albums and their tracks
 */
function generateHistoricalData($projects) {
    $historicalData = [
        'albums' => [],
        'totalProjects' => 0,
        'totalHoursRecorded' => 0,
        'averageCompletionTime' => 0,
        'projectStats' => []
    ];
    
    foreach ($projects as $index => $project) {
        $historicalData['albums'][$index] = [
            'projectName' => $project['projectName'],
            'artist' => $project['artist'],
            'genre' => $project['genre'],
            'totalTracks' => $project['totalPlanned'],
            'tracks' => [
                'recorded' => $project['tracksRecorded'],
                'remaining' => $project['totalPlanned'] - $project['tracksRecorded'],
                'list' => array_map(
                    fn($i) => formatTrackName($project['projectName'], $i + 1),
                    range(0, $project['totalPlanned'] - 1)
                )
            ],
            'timeSpent' => $project['hoursSpent'],
            'targetTime' => $project['targetHours'],
            'metrics' => [
                'completion' => $project['completionPercentage'],
                'avgTimePerTrack' => $project['avgTimePerTrack'],
                'requiredSpeed' => $project['requiredSpeed'],
                'estimatedTimeRemaining' => $project['estimatedTimeRemaining'],
                'isOnPace' => $project['isOnPace']
            ],
            'notes' => $project['notes'],
            'dateCreated' => $project['dateCreated']
        ];
        
        $historicalData['totalProjects']++;
        $historicalData['totalHoursRecorded'] += $project['hoursSpent'];
        $historicalData['projectStats'][] = [
            'name' => $project['projectName'],
            'completion' => $project['completionPercentage'],
            'timeSpent' => $project['hoursSpent']
        ];
    }
    
    // Calculate average completion time if projects exist
    if ($historicalData['totalProjects'] > 0) {
        $historicalData['averageCompletionTime'] = 
            round($historicalData['totalHoursRecorded'] / $historicalData['totalProjects'], 2);
    }
    
    return $historicalData;
}

// ============================================================================
// FILE HANDLING FUNCTIONS
// ============================================================================

/**
 * Save project data to file
 * 
 * @param array $projects Array of projects to save
 * @param string $dataDir Directory to save data
 * @return array Array with 'success' boolean and 'message' string
 */
function saveProjectsToFile($projects, $dataDir) {
    try {
        // Ensure directory exists
        if (!is_dir($dataDir)) {
            mkdir($dataDir, 0755, true);
        }
        
        // Create filename with timestamp
        $filename = $dataDir . '/projects_' . date('Y-m-d') . '.txt';
        
        // Serialize data for file storage
        $fileContent = "=== MUSIC PRODUCER PROJECT TRACKER ===\n";
        $fileContent .= "Generated: " . date('Y-m-d H:i:s') . "\n";
        $fileContent .= "============================================\n\n";
        
        foreach ($projects as $index => $project) {
            $fileContent .= "PROJECT #" . ($index + 1) . ": " . $project['projectName'] . "\n";
            $fileContent .= "Artist: " . $project['artist'] . "\n";
            $fileContent .= "Genre: " . $project['genre'] . "\n";
            $fileContent .= "--------------------------------------------\n";
            $fileContent .= "Total Planned Tracks: " . $project['totalPlanned'] . "\n";
            $fileContent .= "Recorded Tracks: " . $project['tracksRecorded'] . "\n";
            $fileContent .= "Hours Spent: " . formatHours($project['hoursSpent']) . "\n";
            $fileContent .= "Target Hours: " . formatHours($project['targetHours']) . "\n";
            $fileContent .= "Completion: " . formatPercentage($project['completionPercentage']) . "\n";
            $fileContent .= "Avg Time/Track: " . formatHours($project['avgTimePerTrack']) . "\n";
            $fileContent .= "Required Speed: " . formatHours($project['requiredSpeed']) . "\n";
            $fileContent .= "Est. Time Remaining: " . formatHours($project['estimatedTimeRemaining']) . "\n";
            $fileContent .= "Status: " . ($project['isOnPace'] ? "ON PACE" : "BEHIND PACE") . "\n";
            
            if (!empty($project['notes'])) {
                $fileContent .= "Notes: " . $project['notes'] . "\n";
            }
            
            $fileContent .= "Created: " . $project['dateCreated'] . "\n";
            $fileContent .= "============================================\n\n";
        }
        
        // Write to file (append if exists)
        if (file_put_contents($filename, $fileContent, FILE_APPEND | LOCK_EX)) {
            return [
                'success' => true,
                'message' => "Project data saved successfully to " . basename($filename),
                'filename' => basename($filename)
            ];
        } else {
            return [
                'success' => false,
                'message' => "Failed to save project data to file."
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error saving file: " . $e->getMessage()
        ];
    }
}

/**
 * Load projects from file
 * 
 * @param string $filepath Path to file to load
 * @return array Array with 'success' boolean, 'message', and 'data' array
 */
function loadProjectsFromFile($filepath) {
    try {
        if (!file_exists($filepath)) {
            return [
                'success' => false,
                'message' => "File not found: " . basename($filepath),
                'data' => []
            ];
        }
        
        $content = file_get_contents($filepath);
        
        // Parse file content (simple representation)
        return [
            'success' => true,
            'message' => "File loaded successfully",
            'data' => $content,
            'filename' => basename($filepath)
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error loading file: " . $e->getMessage(),
            'data' => []
        ];
    }
}

/**
 * Get list of available project files
 * 
 * @param string $dataDir Directory containing data files
 * @return array Array of filenames
 */
function getAvailableProjectFiles($dataDir) {
    $files = [];
    
    if (!is_dir($dataDir)) {
        return $files;
    }
    
    $items = scandir($dataDir);
    
    foreach ($items as $item) {
        if ($item !== '.' && $item !== '..' && strpos($item, 'projects_') === 0 && strpos($item, '.txt') !== false) {
            $files[] = $item;
        }
    }
    
    // Sort files by date (newest first)
    rsort($files);
    
    return $files;
}

/**
 * Sanitize user input
 * 
 * @param string $input Input to sanitize
 * @return string Sanitized input
 */
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
?>
