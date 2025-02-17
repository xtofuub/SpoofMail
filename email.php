<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Email Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            background: linear-gradient(45deg, #667eea, #764ba2);
            padding: 20px;
        }

        .email-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 600px;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .email-card:hover {
            transform: translateY(-5px);
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

        input, textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        input:hover, textarea:hover {
            border-color: #a3bffa;
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

        .file-input:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
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

        .file-label i {
            margin-right: 0.5rem;
            color: #667eea;
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

        button:hover {
            background: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        button:active {
            transform: translateY(0);
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
    </style>
</head>
<body>
    <div class="email-card">
        <div class="form-header">
            <i class="fas fa-envelope-open-text"></i>
            <h1>Send Email</h1>
        </div>
        
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="status-message <?php echo strpos($output, 'successfully') !== false ? 'success' : 'error'; ?>">
                <?php echo $output; ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
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
                    <input type="file" name="attachment" id="attachment">
                    <label class="file-label" for="attachment">
                        <i class="fas fa-paperclip"></i>
                        <span>Attach File (Drag & Drop or Click)</span>
                    </label>
                </div>
            </div>

            <button type="submit">
                Send Message
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</body>
</html>
