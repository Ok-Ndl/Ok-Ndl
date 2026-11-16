<?php
/**
 * Music Producer Project Tracker - Data Processing
 * Handles form submissions, calculations, and data persistence
 */

session_start();
require_once 'functions.php';

// Directory for data storage
$dataDir = __DIR__ . '/Data';

// Initialize projects array in session
if (!isset($_SESSION['projects'])) {
    $_SESSION['projects'] = [];
}

// Check request method and action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'create';
    
    switch ($action) {
        case 'create':
            handleCreateProject();
            break;
        case 'delete':
            handleDeleteProject();
            break;
        case 'viewdetails':
            handleViewDetails();
            break;
        case 'savesession':
            handleSaveSession();
            break;
        case 'clearsession':
            handleClearSession();
            break;
        case 'loadfile':
            handleLoadFile();
            break;
        case 'downloadfile':
            handleDownloadFile();
            break;
        case 'deletefile':
            handleDeleteFile();
            break;
        default:
            redirect('index.php', 'Invalid action');
    }
} else {
    redirect('index.php', 'Invalid request method');
}

/**
 * Handle creating a new project
 */
function handleCreateProject() {
    global $dataDir;
    
    // Validate input
    $validation = validateProjectInput($_POST);
    
    if (!$validation['valid']) {
        $errorMessage = implode('\n', $validation['errors']);
        redirect('index.php', $errorMessage, 'error');
        return;
    }
    
    // Create project record
    $project = createProjectRecord($_POST);
    
    // Add calculations to project
    $project = addCalculationsToProject($project);
    
    // Add to session
    $_SESSION['projects'][] = $project;
    
    // Redirect to details page with success message
    $lastIndex = count($_SESSION['projects']) - 1;
    $_SESSION['lastProjectIndex'] = $lastIndex;
    $_SESSION['projectCreated'] = true;
    
    redirect('display.php', 'Project created successfully! Viewing project...', 'success');
}

/**
 * Handle deleting a project from session
 */
function handleDeleteProject() {
    $projectIndex = $_POST['projectIndex'] ?? null;
    
    if ($projectIndex === null || !isset($_SESSION['projects'][$projectIndex])) {
        redirect('index.php', 'Project not found', 'error');
        return;
    }
    
    $projectName = $_SESSION['projects'][$projectIndex]['projectName'];
    
    // Remove project
    unset($_SESSION['projects'][$projectIndex]);
    
    // Reindex array
    $_SESSION['projects'] = array_values($_SESSION['projects']);
    
    redirect('index.php?tab=session-projects', "Project '{$projectName}' deleted successfully!", 'success');
}

/**
 * Handle viewing project details
 */
function handleViewDetails() {
    $projectIndex = $_POST['projectIndex'] ?? null;
    
    if ($projectIndex === null || !isset($_SESSION['projects'][$projectIndex])) {
        redirect('index.php', 'Project not found', 'error');
        return;
    }
    
    $_SESSION['lastProjectIndex'] = $projectIndex;
    redirect('display.php', '', 'info');
}

/**
 * Handle saving session projects to file
 */
function handleSaveSession() {
    global $dataDir;
    
    if (empty($_SESSION['projects'])) {
        redirect('index.php', 'No projects to save', 'error');
        return;
    }
    
    $saveResult = saveProjectsToFile($_SESSION['projects'], $dataDir);
    
    if ($saveResult['success']) {
        redirect('index.php?tab=upload-files', $saveResult['message'], 'success');
    } else {
        redirect('index.php?tab=session-projects', $saveResult['message'], 'error');
    }
}

/**
 * Handle clearing session
 */
function handleClearSession() {
    $_SESSION['projects'] = [];
    redirect('index.php', 'Session cleared successfully', 'success');
}

/**
 * Handle loading file
 */
function handleLoadFile() {
    global $dataDir;
    
    $filename = $_POST['filename'] ?? null;
    
    if (!$filename) {
        redirect('index.php', 'Filename not specified', 'error');
        return;
    }
    
    $filepath = $dataDir . '/' . basename($filename);
    
    if (!file_exists($filepath)) {
        redirect('index.php', 'File not found', 'error');
        return;
    }
    
    $loadResult = loadProjectsFromFile($filepath);
    
    if ($loadResult['success']) {
        $_SESSION['loadedFileContent'] = $loadResult['data'];
        $_SESSION['loadedFileName'] = $loadResult['filename'];
        redirect('display.php?mode=view-file', 'File loaded successfully!', 'success');
    } else {
        redirect('index.php', $loadResult['message'], 'error');
    }
}

/**
 * Handle downloading file
 */
function handleDownloadFile() {
    global $dataDir;
    
    $filename = $_POST['filename'] ?? null;
    
    if (!$filename) {
        redirect('index.php', 'Filename not specified', 'error');
        return;
    }
    
    $filepath = $dataDir . '/' . basename($filename);
    
    if (!file_exists($filepath)) {
        redirect('index.php', 'File not found', 'error');
        return;
    }
    
    // Send file for download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
    header('Content-Length: ' . filesize($filepath));
    
    readfile($filepath);
    exit;
}

/**
 * Handle deleting file
 */
function handleDeleteFile() {
    global $dataDir;
    
    $filename = $_POST['filename'] ?? null;
    
    if (!$filename) {
        redirect('index.php', 'Filename not specified', 'error');
        return;
    }
    
    $filepath = $dataDir . '/' . basename($filename);
    
    if (!file_exists($filepath)) {
        redirect('index.php', 'File not found', 'error');
        return;
    }
    
    if (unlink($filepath)) {
        redirect('index.php?tab=upload-files', 'File deleted successfully', 'success');
    } else {
        redirect('index.php', 'Failed to delete file', 'error');
    }
}

/**
 * Redirect function with optional message
 * 
 * @param string $page Target page
 * @param string $message Optional message
 * @param string $type Message type (success, error, info)
 */
function redirect($page, $message = '', $type = 'info') {
    if ($message) {
        $_SESSION['message'] = $message;
        $_SESSION['messageType'] = $type;
    }
    
    header('Location: ' . $page);
    exit;
}
?>
