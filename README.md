# 🔒 DIY PHP Web Application Firewall (WAF)

This is a lightweight, application-level Web Application Firewall (WAF) written in PHP. It helps protect your PHP-based website from common web threats such as SQL Injection, XSS, and suspicious input patterns.

## 🚀 Features

- Blocks common SQL Injection and XSS attempts
- Logs suspicious requests
- Easy to integrate into any PHP project
- No server access required — works with shared hosting

## 📂 Files Included

- `waf.php`: Core WAF logic that scans incoming requests for malicious patterns
- `intrusion_log.txt`: Log file that stores blocked attempts with IP, timestamp, and details

## 📦 Installation

1. **Upload the WAF Files**
   - Place `waf.php` in your website's root directory (e.g., `/htdocs/` on InfinityFree).

2. **Include the WAF in Your PHP Pages**
   Add the following line **at the top of every PHP page** you want to protect:

   ```php
   <?php include_once "waf.php"; ?>
