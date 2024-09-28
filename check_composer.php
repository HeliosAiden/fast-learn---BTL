<?php
// Function to check if Composer is installed
function isComposerInstalled() {
    // Check if 'composer' is available via shell
    $output = shell_exec('composer --version');
    return (strpos($output, 'Composer') !== false);
}

// Function to check if dependencies are installed (vendor directory exists)
function areDependenciesInstalled() {
    return file_exists(__DIR__ . '/vendor/autoload.php'); // Check for Composer's autoload file
}

// Function to check if composer.json exists
function isComposerJsonPresent() {
    return file_exists(__DIR__ . '/composer.json');
}

// Function to install missing dependencies using Composer
function installDependencies() {
    echo "Dependencies not found. Installing...\n";
    // Run 'composer install' to install dependencies
    $output = shell_exec('composer install 2>&1'); // Redirect errors to output
    echo $output;
}

// Main logic
if (!isComposerJsonPresent()) {
    echo "Error: composer.json not found. Cannot proceed.\n";
    exit(1); // Exit with error code
}

if (!areDependenciesInstalled()) {
    if (!isComposerInstalled()) {
        echo "Error: Composer is not installed. Please install Composer first.\n";
        exit(1); // Exit with error code
    }

    // Run the installation if dependencies are not found
    installDependencies();
} else {
    echo "All dependencies are installed.\n";
}
?>
