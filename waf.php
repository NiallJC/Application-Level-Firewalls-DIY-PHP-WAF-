<?php
// waf.php — Simple Application-Level WAF

// List of suspicious patterns
$bad_patterns = [
    "<script",           // XSS
    "onerror=",          // XSS
    "onload=",           // XSS
    "SELECT ",           // SQLi
    "INSERT ",           // SQLi
    "UPDATE ",           // SQLi
    "DELETE ",           // SQLi
    "UNION ",            // SQLi
    "DROP ",             // SQLi
    "sleep(",            // Delay attacks
    "benchmark(",        // SQL timing attacks
    "base64_",           // Encoding-based evasion
    "../",               // Directory traversal
    "cmd=",              // Command injection
    "exec(",             // Command injection
    ";",                 // Command chaining
    "--",                // SQLi comment trick
    "' OR '1'='1",       // Classic SQLi
    "wget ",             // Remote file inclusion
    "curl ",             // Remote file inclusion
];

// Check GET, POST, COOKIE, and REQUEST values
$input_sources = [$_GET, $_POST, $_COOKIE, $_REQUEST];

foreach ($input_sources as $source) {
    foreach ($source as $key => $value) {
        foreach ($bad_patterns as $pattern) {
            if (stripos($value, $pattern) !== false) {
                logIntrusion($pattern, $value);
                http_response_code(403);
                die("Access Denied 🔒 — Suspicious input detected.");
            }
        }
    }
}

// Check User-Agent for known bad bots or scanners
$bad_agents = ['sqlmap', 'curl', 'wget', 'python-requests', 'nmap', 'nikto'];
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

foreach ($bad_agents as $agent) {
    if (stripos($user_agent, $agent) !== false) {
        logIntrusion("Bad User-Agent", $user_agent);
        http_response_code(403);
        die("Access Denied 🔒 — Suspicious client.");
    }
}

// Optional logging function
function logIntrusion($pattern, $value) {
    $log = "[" . date("Y-m-d H:i:s") . "] Blocked pattern: '$pattern' in value: '$value' from IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
    file_put_contents("waf_log.txt", $log, FILE_APPEND);
}
?>
