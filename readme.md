# Shelly - Simple PHP Web Shell

Shelly is a minimalist, single-file PHP web shell with a built-in terminal interface, session-based history, and password protection.

## 🔐 Configuration & Password Change

By default, the password is set to `kitty`. To change it, you need to generate a **SHA-512** hash of your new password and replace the `$PASSWORD` variable in the code.

### How to change the password:

1. Choose your new password.
2. Generate a SHA-512 hash. You can do this via terminal:
```bash
echo -n "your_password" | sha512sum

```


3. Open `shelly.php` and locate the following line at the top:
```php
$PASSWORD = "dcc0054dc1ccade29e1d743a7108996275c4709f6e8ff3169b787d726cd5701694718271856c956e774de4e0dcd05ce2975e5c65bbcfc3fb9c5ea6c0a58e7062";

```


4. Replace the long string inside the quotes with your new hash.

---

## 🚀 Features & Custom Commands

Beyond executing standard system commands (like `ls`, `whoami`, or `cat`), this shell includes specific built-in functions:

### 1. Built-in Commands

* **`clear`**: Clears the command history from your current session screen.
* **`exit`**: Destroys the PHP session and logs you out immediately, returning you to the login screen.

### 2. Session Persistence

The shell saves your command history in the `$_SESSION`. This means if you refresh the page, your previous commands and their outputs will still be visible until you use `clear` or `exit`.

### 3. Responsive UI

The interface is designed with a dark "Terminal" aesthetic using Google Material Icons and is fully responsive (works on mobile and desktop).

---

## ⚠️ Security Warning

**Use this tool for educational purposes or authorized testing only.** * Always delete this file from the server after use.

* Do not leave it accessible on a public web server without additional `.htaccess` protection.
* Be aware that `system()` execution may be disabled by some hosting providers for security reasons.

---
