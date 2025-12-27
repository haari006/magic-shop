param(
    [string]$StripeSecretKey = $env:STRIPE_SECRET_KEY,
    [string]$StripeWebhookSecret = $env:STRIPE_WEBHOOK_SECRET,
    [string]$XamppRoot = $env:XAMPP_HOME,
    [string]$DbName = "magicshop",
    [string]$DbUser = "root",
    [string]$DbPass = "",
    [int]$Port = 8000,
    [switch]$Foreground,
    [switch]$NoBrowser
)

function Write-Info($Message) {
    Write-Host "[start-dev] $Message"
}

$projectRoot = $PSScriptRoot
if (-not $projectRoot) {
    $projectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
}

if (-not $XamppRoot) {
    if (Test-Path "C:\\xampp") {
        $XamppRoot = "C:\\xampp"
    } elseif (Test-Path "C:\\XAMPP") {
        $XamppRoot = "C:\\XAMPP"
    }
}

if (-not $XamppRoot -or -not (Test-Path $XamppRoot)) {
    Write-Error "XAMPP not found. Install it and pass -XamppRoot C:\\xampp."
    exit 1
}

$startExe = Join-Path $XamppRoot "xampp_start.exe"
$startBat = Join-Path $XamppRoot "xampp_start.bat"
if (Test-Path $startExe) {
    Write-Info "Starting XAMPP (Apache + MySQL)..."
    Start-Process -FilePath $startExe -WorkingDirectory $XamppRoot | Out-Null
} elseif (Test-Path $startBat) {
    Write-Info "Starting XAMPP (Apache + MySQL)..."
    Start-Process -FilePath $startBat -WorkingDirectory $XamppRoot | Out-Null
} else {
    Write-Warning "xampp_start not found. Trying to start services directly."
    $serviceNames = @("Apache2.4", "mysql", "MySQL")
    foreach ($name in $serviceNames) {
        $svc = Get-Service -Name $name -ErrorAction SilentlyContinue
        if ($svc -and $svc.Status -ne "Running") {
            try {
                Start-Service -Name $svc.Name -ErrorAction SilentlyContinue
            } catch {
            }
        }
    }
}

Start-Sleep -Seconds 2

$mysqlExe = Join-Path $XamppRoot "mysql\\bin\\mysql.exe"
if (-not (Test-Path $mysqlExe)) {
    Write-Error "mysql.exe not found at $mysqlExe. Check your XAMPP install."
    exit 1
}

$sql = @"
CREATE DATABASE IF NOT EXISTS $DbName;
USE $DbName;
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stripe_event_id VARCHAR(255) UNIQUE NOT NULL,
    stripe_session_id VARCHAR(255) NOT NULL,
    client_reference_id VARCHAR(255),
    username VARCHAR(50),
    customer_email VARCHAR(255),
    product_id VARCHAR(50),
    product_name VARCHAR(255),
    amount_total INT NOT NULL,
    currency VARCHAR(10) NOT NULL,
    payment_status VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
"@

$mysqlArgs = @("--default-character-set=utf8mb4", "-u", $DbUser)
if ($DbPass -ne "") {
    $mysqlArgs += "-p$DbPass"
}
$mysqlArgs += "-e"
$mysqlArgs += $sql

Write-Info "Creating database and tables..."
& $mysqlExe @mysqlArgs
if ($LASTEXITCODE -ne 0) {
    Write-Error "MySQL setup failed. Verify credentials and MySQL service."
    exit 1
}

if ($StripeSecretKey) {
    $env:STRIPE_SECRET_KEY = $StripeSecretKey
} else {
    Write-Warning "STRIPE_SECRET_KEY not set. Checkout will fail until set."
}
if ($StripeWebhookSecret) {
    $env:STRIPE_WEBHOOK_SECRET = $StripeWebhookSecret
} else {
    Write-Warning "STRIPE_WEBHOOK_SECRET not set. Webhook verification will fail until set."
}

$phpExe = Join-Path $XamppRoot "php\\php.exe"
if (-not (Test-Path $phpExe)) {
    Write-Error "php.exe not found at $phpExe."
    exit 1
}

$address = "localhost:$Port"
$phpArgs = @("-S", $address, "-t", $projectRoot)

Write-Info "Starting PHP server at http://$address/index.php"
if ($Foreground) {
    if (-not $NoBrowser) {
        Start-Process "http://$address/index.php" | Out-Null
    }
    & $phpExe @phpArgs
} else {
    Start-Process -FilePath $phpExe -ArgumentList $phpArgs -WorkingDirectory $projectRoot | Out-Null
    if (-not $NoBrowser) {
        Start-Process "http://$address/index.php" | Out-Null
    }
}
