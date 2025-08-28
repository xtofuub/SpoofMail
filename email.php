<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Sender</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="dark-theme">
    <canvas id="squaresBackground" class="squares-background"></canvas>

    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon"></i>
    </button>

    <div class="email-card">
        <div class="glass-effect"></div>
        <div class="form-header">
            <i class="fas fa-envelope-open-text"></i>
            <h1>Send Test Emails</h1>
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
                // Sanitize input using modern methods
                $from_name = strip_tags($from_name);
                $from_name = htmlspecialchars($from_name, ENT_QUOTES, 'UTF-8');
                $subject = strip_tags($subject);
                $subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
                $message = strip_tags($message);
                $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
                
                $from = filter_var($from, FILTER_SANITIZE_EMAIL);
                if (!filter_var($from, FILTER_VALIDATE_EMAIL)) {
                    $output = "Invalid sender email address.";
                    return;
                }

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

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($output)): ?>
            <div class="status-message <?php echo strpos($output, 'successfully') !== false ? 'success' : 'error'; ?>">
                <?php if (strpos($output, 'successfully') !== false): ?>
                    <i class="fas fa-check-circle"></i>
                <?php else: ?>
                    <i class="fas fa-exclamation-circle"></i>
                <?php endif; ?>
                <?php echo $output; ?>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const statusMessage = document.querySelector('.status-message');
                    if (statusMessage) {
                        // Wait 8 seconds before starting fade
                        setTimeout(() => {
                            // Add fade-out class for smooth transition
                            statusMessage.classList.add('fade-out');
                            
                            // Remove element after fade completes
                            setTimeout(() => {
                                statusMessage.remove();
                            }, 2500); // Match the transition duration
                        }, 5000); // Show for 8 seconds before starting fade
                    }
                });
            </script>
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

            <div class="form-group message-group">
                <label>Message</label>
                <textarea name="message" rows="5" required></textarea>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="from" required>
            </div>

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="from_name" required>
            </div>

            <div class="form-group">
                <div class="file-input">
                    <input type="file" name="attachment[]" id="attachment" multiple>
                    <label class="file-label" for="attachment">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span id="file-name">Attach Files (Drag & Drop or Click)</span>
                    </label>
                    <div class="file-list" id="file-list"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="sendType">Send Options</label>
                <div class="send-options">
                    <select name="send_type" id="sendType" class="send-type-select">
                        <option value="once">Send Once</option>
                        <option value="preset">Preset Amount</option>
                        <option value="custom">Custom Amount</option>
                        <option value="unlimited">Unlimited</option>
                    </select>
                    
                    <div id="presetOptions" class="preset-options" style="display: none;">
                        <button type="button" data-amount="5">5x</button>
                        <button type="button" data-amount="10">10x</button>
                        <button type="button" data-amount="25">25x</button>
                        <button type="button" data-amount="50">50x</button>
                    </div>

                    <div id="customAmount" style="display: none;">
                        <input type="number" name="send_amount" min="1" max="1000" placeholder="Enter number of times to send">
                    </div>
                </div>
            </div>

            <div id="sendProgress" class="send-progress" style="display: none;">
                <div class="progress-info">
                    <span id="progressText">Sending emails: 0/0</span>
                    <button id="stopSending" class="stop-button" style="display: none;">
                        <i class="fas fa-stop"></i>
                    </button>
                </div>
                <div class="progress-bar">
                    <div id="progressFill" class="progress-fill"></div>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="send-button">
                    Send Message
                    <i class="fas fa-paper-plane"></i>
                </button>
                <button type="button" class="preview-button">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </form>
    </div>

    <div id="previewModal" class="preview-modal">
        <div class="preview-content">
            <div class="preview-header">
                <h2>Email Preview</h2>
                <button class="close-preview">&times;</button>
            </div>
            <div class="preview-body">
                <div class="preview-field">
                    <label>From:</label>
                    <span id="previewFrom"></span>
                </div>
                <div class="preview-field">
                    <label>From Name:</label>
                    <span id="previewFromName"></span>
                </div>
                <div class="preview-field">
                    <label>To:</label>
                    <span id="previewTo"></span>
                </div>
                <div class="preview-field">
                    <label>Subject:</label>
                    <span id="previewSubject"></span>
                </div>
                <div class="preview-field">
                    <label>Message:</label>
                    <div id="previewMessage" class="preview-message"></div>
                </div>
                <div class="preview-field">
                    <label>Attachments:</label>
                    <div id="previewAttachments" class="preview-attachments"></div>
                </div>
            </div>
            <div class="preview-footer">
                <button id="confirmSend" class="send-btn">Send Email</button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html> 
