<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laragon PHP test</title>
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      min-height: 100vh;
      background: #87ceeb;
      font-family: system-ui, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }
    .card {
      background: rgba(255, 255, 255, 0.92);
      border-radius: 12px;
      padding: 1.75rem 2rem;
      max-width: 420px;
      box-shadow: 0 8px 32px rgba(0, 80, 120, 0.15);
    }
    h1 {
      margin: 0 0 0.5rem;
      font-size: 1.35rem;
      color: #0a4a6e;
    }
    p {
      margin: 0.5rem 0;
      color: #1a3d52;
      line-height: 1.5;
    }
    code {
      background: #e8f4fc;
      padding: 0.15rem 0.4rem;
      border-radius: 4px;
      font-size: 0.9em;
    }
    .ok {
      color: #0d6e3a;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>PHP is running</h1>
    <p class="ok">If this box appears on a light blue page, Laragon served this file correctly.</p>
    <p>PHP version: <code><?php echo htmlspecialchars(PHP_VERSION, ENT_QUOTES, 'UTF-8'); ?></code></p>
    <p>Server time: <code><?php echo htmlspecialchars(date('Y-m-d H:i:s'), ENT_QUOTES, 'UTF-8'); ?></code></p>
  </div>
</body>
</html>
