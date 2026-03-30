<?php
declare(strict_types=1);
// Single-file IESCO bill lookup — form submits directly to official PITC (no backend storage/API).
$pitcBase = 'https://bill.pitc.com.pk/iescobill/general';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="IESCO electricity bill lookup — opens your bill on the official PITC portal.">
  <title>IESCO Bill Checker</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #0c1410;
      --bg-elevated: #121f18;
      --surface: #16261c;
      --border: rgba(124, 214, 168, 0.14);
      --text: #e8f4ec;
      --muted: #8fb39a;
      --accent: #3dd68c;
      --accent-dim: #2a9d62;
      --accent-glow: rgba(61, 214, 140, 0.22);
      --danger: #ff6b6b;
      --radius: 16px;
      --radius-sm: 10px;
      --font: 'DM Sans', system-ui, sans-serif;
      --shadow: 0 24px 80px rgba(0, 0, 0, 0.45);
    }

    *, *::before, *::after { box-sizing: border-box; }

    html {
      scroll-behavior: smooth;
    }

    body {
      margin: 0;
      min-height: 100vh;
      font-family: var(--font);
      color: var(--text);
      background:
        radial-gradient(ellipse 120% 80% at 50% -20%, var(--accent-glow), transparent 55%),
        radial-gradient(ellipse 80% 50% at 100% 50%, rgba(42, 157, 98, 0.08), transparent 50%),
        var(--bg);
      line-height: 1.5;
      -webkit-font-smoothing: antialiased;
    }

    .wrap {
      max-width: 520px;
      margin: 0 auto;
      padding: clamp(1.5rem, 5vw, 3rem) 1.25rem 4rem;
    }

    header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .logo-mark {
      width: 56px;
      height: 56px;
      margin: 0 auto 1rem;
      border-radius: 14px;
      background: linear-gradient(145deg, var(--accent), var(--accent-dim));
      display: grid;
      place-items: center;
      box-shadow: 0 12px 40px var(--accent-glow);
    }

    .logo-mark svg {
      width: 28px;
      height: 28px;
      color: #0c1410;
    }

    h1 {
      font-size: clamp(1.5rem, 4vw, 1.85rem);
      font-weight: 700;
      letter-spacing: -0.02em;
      margin: 0 0 0.5rem;
    }

    .tagline {
      color: var(--muted);
      font-size: 0.95rem;
      margin: 0;
    }

    .card {
      background: linear-gradient(165deg, var(--bg-elevated) 0%, var(--surface) 100%);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: clamp(1.5rem, 4vw, 2rem);
      box-shadow: var(--shadow);
    }

    label {
      display: block;
      font-size: 0.8rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--muted);
      margin-bottom: 0.5rem;
    }

    .field-wrap {
      position: relative;
    }

    input[type="text"] {
      width: 100%;
      padding: 1rem 1rem 1rem 3rem;
      font-family: var(--font);
      font-size: 1.125rem;
      font-weight: 500;
      letter-spacing: 0.04em;
      color: var(--text);
      background: rgba(0, 0, 0, 0.25);
      border: 1px solid var(--border);
      border-radius: var(--radius-sm);
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    input[type="text"]::placeholder {
      color: rgba(143, 179, 154, 0.45);
      letter-spacing: 0.02em;
    }

    input[type="text"]:focus {
      border-color: rgba(61, 214, 140, 0.45);
      box-shadow: 0 0 0 3px var(--accent-glow);
    }

    .field-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      width: 20px;
      height: 20px;
      color: var(--muted);
      pointer-events: none;
    }

    .hint {
      margin-top: 0.65rem;
      font-size: 0.8rem;
      color: var(--muted);
    }

    .hint strong {
      color: var(--accent);
      font-weight: 600;
    }

    .actions {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
      margin-top: 1.5rem;
    }

    button[type="submit"] {
      width: 100%;
      padding: 1rem 1.25rem;
      font-family: var(--font);
      font-size: 1rem;
      font-weight: 600;
      color: #0a120e;
      background: linear-gradient(180deg, #4ae89a 0%, var(--accent) 45%, var(--accent-dim) 100%);
      border: none;
      border-radius: var(--radius-sm);
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      transition: transform 0.15s, box-shadow 0.2s, filter 0.2s;
      box-shadow: 0 8px 28px var(--accent-glow);
    }

    button[type="submit"]:hover {
      filter: brightness(1.05);
      transform: translateY(-1px);
    }

    button[type="submit"]:active {
      transform: translateY(0);
    }

    button[type="submit"]:focus-visible {
      outline: 2px solid var(--accent);
      outline-offset: 3px;
    }

    button[type="submit"] svg {
      width: 20px;
      height: 20px;
    }

    .secondary {
      text-align: center;
      font-size: 0.85rem;
      color: var(--muted);
    }

    .secondary a {
      color: var(--accent);
      text-decoration: none;
      font-weight: 500;
    }

    .secondary a:hover {
      text-decoration: underline;
    }

    .preview {
      margin-top: 1.5rem;
      padding: 1rem 1rem;
      background: rgba(0, 0, 0, 0.2);
      border-radius: var(--radius-sm);
      border: 1px dashed rgba(124, 214, 168, 0.2);
      word-break: break-all;
    }

    .preview-label {
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--muted);
      margin-bottom: 0.35rem;
    }

    .preview-url {
      font-size: 0.8rem;
      color: var(--accent);
      font-family: ui-monospace, 'Cascadia Code', monospace;
      line-height: 1.45;
    }

    .error-msg {
      display: none;
      margin-top: 0.65rem;
      font-size: 0.85rem;
      color: var(--danger);
    }

    .error-msg.visible {
      display: block;
    }

    footer {
      margin-top: 2.5rem;
      text-align: center;
      font-size: 0.78rem;
      color: rgba(143, 179, 154, 0.65);
      max-width: 36rem;
      margin-left: auto;
      margin-right: auto;
      line-height: 1.6;
    }

    @media (prefers-reduced-motion: reduce) {
      button[type="submit"] {
        transition: none;
      }
    }
  </style>
</head>
<body>
  <div class="wrap">
    <header>
      <div class="logo-mark" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
      </div>
      <h1>IESCO Bill Checker</h1>
      <p class="tagline">Enter your reference number to open your bill on the official PITC portal.</p>
    </header>

    <div class="card">
      <form
        id="bill-form"
        method="get"
        action="<?php echo htmlspecialchars($pitcBase, ENT_QUOTES, 'UTF-8'); ?>"
        target="_blank"
        novalidate
      >
        <label for="refno">Reference number</label>
        <div class="field-wrap">
          <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
          </svg>
          <input
            type="text"
            id="refno"
            name="refno"
            inputmode="numeric"
            autocomplete="off"
            maxlength="20"
            placeholder="e.g. 02146210225104"
            aria-describedby="hint-ref url-preview"
            required
          >
        </div>
        <p id="hint-ref" class="hint">Find the <strong>14-digit reference number</strong> on your printed bill (no spaces).</p>
        <p id="ref-error" class="error-msg" role="alert"></p>

        <div class="actions">
          <button type="submit">
            View bill on PITC
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
          </button>
          <p class="secondary">Opens <a href="https://bill.pitc.com.pk/" target="_blank" rel="noopener noreferrer">bill.pitc.com.pk</a> in a new tab.</p>
        </div>

        <div class="preview" id="url-preview" aria-live="polite">
          <div class="preview-label">Generated link</div>
          <div class="preview-url" id="url-text"><?php echo htmlspecialchars($pitcBase, ENT_QUOTES, 'UTF-8'); ?>?refno=</div>
        </div>
      </form>
    </div>

    <footer>
      This page only builds the same URL as the official IESCO bill portal. It does not store your reference number.
      Not affiliated with IESCO or PITC — you are redirected to the government billing site.
    </footer>
  </div>

  <script>
    (function () {
      var form = document.getElementById('bill-form');
      var input = document.getElementById('refno');
      var urlText = document.getElementById('url-text');
      var err = document.getElementById('ref-error');
      var base = <?php echo json_encode($pitcBase, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

      function digitsOnly(s) {
        return String(s).replace(/\D/g, '');
      }

      function updatePreview() {
        var v = digitsOnly(input.value);
        urlText.textContent = base + '?refno=' + (v || '');
      }

      input.addEventListener('input', function () {
        var cleaned = digitsOnly(input.value);
        if (input.value !== cleaned) {
          input.value = cleaned;
        }
        err.classList.remove('visible');
        err.textContent = '';
        updatePreview();
      });

      form.addEventListener('submit', function (e) {
        var v = digitsOnly(input.value);
        if (v.length < 10) {
          e.preventDefault();
          err.textContent = 'Please enter a valid reference number (at least 10 digits).';
          err.classList.add('visible');
          input.focus();
          return;
        }
        input.value = v;
      });

      updatePreview();
    })();
  </script>
</body>
</html>
