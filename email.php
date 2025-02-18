<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Spoofer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            transition: background 0.3s ease, color 0.3s ease;
        }

        body.light-theme {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: #333;
        }

        body.dark-theme {
            background: #000;
            color: #fff;
        }

        .email-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 600px;
            transform: translateY(0);
            transition: transform 0.3s ease, background 0.3s ease, color 0.3s ease;
        }

        body.dark-theme .email-card {
            background: #111;
            color: #fff;
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.1);
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header i {
            font-size: 2.5rem;
            color: #667eea;
            margin-bottom: 1rem;
            animation: float 3s ease-in-out infinite;
        }

        body.dark-theme .form-header i {
            color: #00ff88;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4a5568;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        body.dark-theme label {
            color: #ccc;
        }

        input, textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        body.dark-theme input, body.dark-theme textarea {
            background: #222;
            color: #fff;
            border-color: #333;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        body.dark-theme input:focus, body.dark-theme textarea:focus {
            border-color: #00ff88;
            box-shadow: 0 0 0 3px rgba(0, 255, 136, 0.2);
        }

        .file-input {
            position: relative;
            overflow: hidden;
            border: 2px dashed #cbd5e0;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        body.dark-theme .file-input {
            border-color: #444;
        }

        .file-input:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        body.dark-theme .file-input:hover {
            border-color: #00ff88;
            background: rgba(0, 255, 136, 0.05);
        }

        .file-input input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .file-label {
            color: #4a5568;
            font-weight: 500;
        }

        body.dark-theme .file-label {
            color: #ccc;
        }

        .file-label i {
            margin-right: 0.5rem;
            color: #667eea;
        }

        body.dark-theme .file-label i {
            color: #00ff88;
        }

        button {
            width: 100%;
            padding: 1rem;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        body.dark-theme button {
            background: #00ff88;
            color: #000;
        }

        button:hover {
            background: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        body.dark-theme button:hover {
            background: #00cc66;
        }

        .status-message {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            animation: fadeIn 0.5s ease;
        }

        .success {
            background: #48bb78;
            color: white;
        }

        .error {
            background: #f56565;
            color: white;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 640px) {
            .email-card {
                padding: 1.5rem;
            }
        }

        .file-list {
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: #4a5568;
        }

        body.dark-theme .file-list {
            color: #ccc;
        }

        .status-message {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            animation: fadeIn 0.5s ease, fadeOut 0.5s ease 5s forwards;
        }

        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        body.dark-theme .theme-toggle {
            background: #00ff88;
            color: #000;
        }

        .theme-toggle:hover {
            background: #764ba2;
        }

        body.dark-theme .theme-toggle:hover {
            background: #00cc66;
        }
    </style>
</head>
<body class="light-theme">
    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon"></i>
    </button>

    <div class="email-card">
        <div class="form-header">
            <i class="fas fa-envelope-open-text"></i>
            <h1>Send Spoofed Email</h1>
        </div>

        <?php
        $output = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Enable error reporting for debugging
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            $to = $_POST['to'] ?? '';
            $subject = $_POST['subject'] ?? '';
            $message = $_POST['message'] ?? '';
            $from = $_POST['from'] ?? '';
            $from_name = $_POST['from_name'] ?? '';

            // Validate required fields
            if (empty($to) || empty($subject) || empty($message) || empty($from) || empty($from_name)) {
                $output = "All fields are required.";
            } else {
                // Prepare headers
                $headers = "From: $from_name <$from>\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: multipart/mixed; boundary=\"PHP-mixed-" . md5(time()) . "\"\r\n";

                // Handle file attachments
                $attachment = '';
                if (!empty($_FILES['attachment']['name'][0])) {
                    $file_count = count($_FILES['attachment']['name']);
                    
                    for ($i = 0; $i < $file_count; $i++) {
                        if ($_FILES['attachment']['error'][$i] === UPLOAD_ERR_OK) {
                            $file_name = $_FILES['attachment']['name'][$i];
                            $file_tmp = $_FILES['attachment']['tmp_name'][$i];
                            $file_data = chunk_split(base64_encode(file_get_contents($file_tmp)));

                            $attachment .= "--PHP-mixed-" . md5(time()) . "\r\n";
                            $attachment .= "Content-Type: application/octet-stream; name=\"$file_name\"\r\n";
                            $attachment .= "Content-Transfer-Encoding: base64\r\n";
                            $attachment .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n\r\n";
                            $attachment .= $file_data . "\r\n";
                        }
                    }
                }

                // Prepare email body
                $body = "--PHP-mixed-" . md5(time()) . "\r\n";
                $body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
                $body .= $message . "\r\n\r\n";
                $body .= $attachment;
                $body .= "--PHP-mixed-" . md5(time()) . "--";

                // Send email
                if (mail($to, $subject, $body, $headers)) {
                    $output = "Email sent successfully!";
                    echo '<script>
                        document.getElementById("emailForm").reset();
                        document.getElementById("file-name").textContent = "Attach Files (Drag & Drop or Click)";
                        document.getElementById("file-list").innerHTML = "";
                    </script>';
                } else {
                    $error = error_get_last();
                    $output = "Failed to send email. Error: " . ($error['message'] ?? 'Unknown error');
                }
            }
        }
        ?>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="status-message <?php echo strpos($output, 'successfully') !== false ? 'success' : 'error'; ?>">
                <?php echo $output; ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" id="emailForm" autocomplete="on">
            <div class="form-group">
                <label>Recipient Email</label>
                <input type="email" name="to" required>
            </div>

            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" required>
            </div>

            <div class="form-group">
                <label>Message</label>
                <textarea name="message" rows="5" required></textarea>
            </div>

            <div class="form-group">
                <label>Your Email</label>
                <input type="email" name="from" required>
            </div>

            <div class="form-group">
                <label>Your Name</label>
                <input type="text" name="from_name" required>
            </div>

            <div class="form-group">
                <div class="file-input">
                    <input type="file" name="attachment[]" id="attachment" multiple>
                    <label class="file-label" for="attachment">
                        <i class="fas fa-paperclip"></i>
                        <span id="file-name">Attach Files (Drag & Drop or Click)</span>
                    </label>
                    <div class="file-list" id="file-list"></div>
                </div>
            </div>

            <button type="submit">
                Send Message
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const body = document.body;

            // Check for saved theme in localStorage
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                body.classList.add(savedTheme);
                updateToggleIcon(savedTheme);
            }

            themeToggle.addEventListener('click', function() {
                if (body.classList.contains('light-theme')) {
                    body.classList.remove('light-theme');
                    body.classList.add('dark-theme');
                    localStorage.setItem('theme', 'dark-theme');
                } else {
                    body.classList.remove('dark-theme');
                    body.classList.add('light-theme');
                    localStorage.setItem('theme', 'light-theme');
                }
                updateToggleIcon(body.classList.contains('dark-theme') ? 'dark-theme' : 'light-theme');
            });

            function updateToggleIcon(theme) {
                const icon = themeToggle.querySelector('i');
                if (theme === 'dark-theme') {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                } else {
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                }
            }

            // File selection handler
            const fileInput = document.getElementById('attachment');
            const fileNameSpan = document.getElementById('file-name');
            const fileListDiv = document.getElementById('file-list');

            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const files = e.target.files;
                    let fileNames = [];

                    for (let i = 0; i < files.length; i++) {
                        fileNames.push(files[i].name);
                    }

                    if (files.length === 0) {
                        fileNameSpan.textContent = 'Attach Files (Drag & Drop or Click)';
                        fileListDiv.innerHTML = '';
                    } else {
                        fileNameSpan.textContent = `${files.length} file(s) selected`;
                        fileListDiv.innerHTML = fileNames.map(name => 
                            `<div>• ${name}</div>`
                        ).join('');
                    }
                });
            }

            // Auto-fade status messages
            const statusMessages = document.querySelectorAll('.status-message');
            statusMessages.forEach(msg => {
                setTimeout(() => {
                    msg.style.display = 'none';
                }, 5000); // 
            });

            // Clear form on page refresh
            window.addEventListener('beforeunload', function() {
                document.getElementById('emailForm').reset();
            });

            // Prevent form persistence after submission
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        });
    </script>
</body>
</html>
