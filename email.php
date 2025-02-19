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
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            transition: all 0.3s ease;
            background: #000000; /* Set default background */
        }

        body.light-theme {
            background: #f0f0f0; /* Less bright background */
            color: #111111;
        }

        body.dark-theme {
            background: #000000;
            color: #ffffff;
        }

        .email-card {
            padding: 2.5rem;
            border-radius: 12px;
            width: 100%;
            max-width: 580px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1;
            background: rgba(17, 17, 17, 0.98); /* Set default to dark theme */
        }

        body.light-theme .email-card {
            background: rgba(255, 255, 255, 0.85); /* More transparent white */
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                0 16px 48px -8px rgba(0, 0, 0, 0.15); /* Added shadow for better depth */
        }

        body.dark-theme .email-card {
            background: rgba(17, 17, 17, 0.98);
        }

        .form-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .form-header i {
            font-size: 2rem;
            margin-bottom: 1.25rem;
        }

        body.light-theme .form-header i {
            color: #111111;
        }

        body.dark-theme .form-header i {
            color: #ffffff;
        }

        .form-header h1 {
            font-size: 1.75rem;
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            margin-bottom: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            letter-spacing: 0.02em;
        }

        body.light-theme label {
            color: #374151;
        }

        body.dark-theme label {
            color: #e5e7eb;
        }

        input {
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 8px;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
            letter-spacing: -0.01em;
            min-height: auto;
            height: 45px;
        }

        body.light-theme input {
            background: rgba(255, 255, 255, 0.7); /* More transparent inputs */
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #111111;
        }

        body.dark-theme input {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        input:focus {
            outline: none;
        }

        body.light-theme input:focus {
            border-color: #111111;
            box-shadow: 0 0 0 3px rgba(17, 17, 17, 0.1);
        }

        body.dark-theme input:focus {
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        textarea {
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 8px;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
            letter-spacing: -0.01em;
            resize: vertical;
            min-height: 100px;
            max-height: 300px;
        }

        body.light-theme textarea {
            background: rgba(255, 255, 255, 0.7); /* More transparent inputs */
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #111111;
        }

        body.dark-theme textarea {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        textarea:focus {
            outline: none;
        }

        body.light-theme textarea:focus {
            border-color: #111111;
            box-shadow: 0 0 0 3px rgba(17, 17, 17, 0.1);
        }

        body.dark-theme textarea:focus {
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        .file-input {
            position: relative;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            transition: all 0.2s ease;
            overflow: hidden;
            cursor: pointer;
        }

        body.light-theme .file-input {
            background: rgba(0, 0, 0, 0.02);
            border: 2px dashed rgba(0, 0, 0, 0.1);
        }

        body.dark-theme .file-input {
            background: rgba(255, 255, 255, 0.02);
            border: 2px dashed rgba(255, 255, 255, 0.1);
        }

        .file-input:hover {
            transform: translateY(-1px);
        }

        body.light-theme .file-input:hover {
            border-color: rgba(0, 0, 0, 0.2);
            background: rgba(0, 0, 0, 0.03);
        }

        body.dark-theme .file-input:hover {
            border-color: rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.03);
        }

        .file-input input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }

        .file-label i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        body.light-theme .file-label i {
            color: #111111;
        }

        body.dark-theme .file-label i {
            color: #ffffff;
        }

        .file-label span {
            font-size: 0.875rem;
            font-weight: 500;
        }

        body.light-theme .file-label span {
            color: #374151;
        }

        body.dark-theme .file-label span {
            color: #e5e7eb;
        }

        .file-list {
            margin-top: 0.75rem;
            font-size: 0.8125rem;
            text-align: left;
        }

        .file-list div {
            padding: 0.25rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            word-break: break-all;
        }

        .file-list div::before {
            content: "•";
            color: currentColor;
        }

        body.light-theme .file-list {
            color: #6b7280;
        }

        body.dark-theme .file-list {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Update the Browse button styling */
        .file-input input[type="file"]::-webkit-file-upload-button {
            visibility: hidden;
        }

        .file-input input[type="file"]::file-selector-button {
            visibility: hidden;
        }

        button {
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 8px;
            font-size: 0.9375rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            letter-spacing: 0.02em;
            border: none;
        }

        body.light-theme button {
            background: #111111;
            color: #ffffff;
        }

        body.dark-theme button {
            background: #ffffff;
            color: #000000;
        }

        button:hover {
            transform: translateY(-1px);
        }

        body.light-theme button:hover {
            background: #000000;
            box-shadow: 
                0 4px 12px rgba(0, 0, 0, 0.1),
                0 8px 24px rgba(0, 0, 0, 0.1);
        }

        body.dark-theme button:hover {
            background: #f9fafb;
            box-shadow: 
                0 4px 12px rgba(0, 0, 0, 0.2),
                0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .theme-toggle {
            position: fixed;
            top: 24px;
            right: 24px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        body.light-theme .theme-toggle {
            background: #111111;
            color: #ffffff;
            box-shadow: 
                0 4px 12px rgba(0, 0, 0, 0.1),
                0 8px 24px rgba(0, 0, 0, 0.1);
        }

        body.dark-theme .theme-toggle {
            background: #ffffff;
            color: #000000;
            box-shadow: 
                0 4px 12px rgba(0, 0, 0, 0.2),
                0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .theme-toggle:hover {
            transform: scale(1.05) rotate(8deg);
        }

        @media (max-width: 640px) {
            .email-card {
                padding: 1.75rem;
            }
            
            .form-header {
                margin-bottom: 2rem;
            }
            
            .form-header h1 {
                font-size: 1.5rem;
            }
        }

        .squares-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            pointer-events: auto;
            background: #000000; /* Set default background */
        }

        /* Add these styles for the message form group specifically */
        .form-group.message-group {
            position: relative;
            margin-bottom: 2rem;
        }

        .form-group.message-group textarea {
            min-height: 100px;
            height: 120px;
            padding-bottom: 1rem;
        }

        /* Add a subtle resize handle indicator */
        .form-group.message-group::after {
            content: '';
            position: absolute;
            bottom: 4px;
            right: 4px;
            width: 12px;
            height: 12px;
            cursor: ns-resize;
            background: 
                linear-gradient(45deg, 
                    transparent 50%,
                    rgba(128, 128, 128, 0.4) 50%);
            border-radius: 0 0 4px 0;
            pointer-events: none;
        }

        /* Add these styles */
        .preview-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        .preview-content {
            position: relative;
            background: var(--bg-color);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            margin: 2rem auto;
            animation: modalSlide 0.3s ease-out;
        }

        @keyframes modalSlide {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .preview-header h2 {
            margin: 0;
            color: var(--text-color);
            width: 100%;
            text-align: center;
        }

        .close-preview {
            position: absolute;
            right: 1rem;
            top: 1rem;
            background: none;
            border: none;
            font-size: 1rem;
            color: var(--text-color);
            cursor: pointer;
            padding: 0.25rem;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }

        .close-preview:hover {
            opacity: 1;
        }

        .preview-body {
            padding: 1.5rem;
            max-height: 70vh;
            overflow-y: auto;
        }

        .preview-field {
            margin-bottom: 1rem;
        }

        .preview-field label {
            display: block;
            color: var(--text-color);
            opacity: 0.7;
            margin-bottom: 0.25rem;
        }

        .preview-field span {
            color: var(--text-color);
        }

        .preview-message {
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            border-radius: 6px;
            white-space: pre-wrap;
            color: var(--text-color);
        }

        .preview-attachments {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .attachment-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 0.5rem 1rem;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-color);
        }

        .preview-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: center;
        }

        .send-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            text-align: center;
            transition: all 0.3s ease;
            border: none;
            background: white;
            color: black;
        }

        .send-btn:hover {
            background: #f0f0f0;
        }

        /* Dark theme override */
        body.dark-theme .send-btn {
            background: #333;
            color: white;
        }

        body.dark-theme .send-btn:hover {
            background: #444;
        }

        /* Light theme overrides */
        body.light-theme .preview-content {
            --bg-color: #fff;
            --text-color: #000;
            border-color: rgba(0, 0, 0, 0.1);
        }

        body.light-theme .preview-header,
        body.light-theme .preview-footer {
            border-color: rgba(0, 0, 0, 0.1);
        }

        body.light-theme .preview-message,
        body.light-theme .attachment-item {
            background: rgba(0, 0, 0, 0.05);
        }

        .status-message {
            margin: 20px auto;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #1a1a1a;
            max-width: 400px;
            animation: fadeInDown 0.5s ease forwards;
            opacity: 1;
            transition: all 2.5s ease; /* Increased transition duration and smoothed timing */
        }

        .status-message.success {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #10B981;
        }

        .status-message.error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #EF4444;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .status-message.fade-out {
            opacity: 0;
            transform: translateY(-10px); /* Slight upward movement while fading */
        }

        /* Send Options Styling */
        .send-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .send-type-select {
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 8px;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }

        body.light-theme .send-type-select {
            background-color: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #111111;
        }

        body.dark-theme .send-type-select {
            background-color: rgba(17, 17, 17, 0.98); /* Match email-card background */
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        body.dark-theme .send-type-select:hover {
            background-color: rgba(30, 30, 30, 0.98);
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Style the dropdown options */
        body.dark-theme .send-type-select option {
            background-color: rgba(17, 17, 17, 0.98);
            color: #ffffff;
            padding: 8px;
        }

        body.dark-theme .send-type-select option:hover {
            background-color: rgba(30, 30, 30, 0.98);
        }

        body.dark-theme .send-type-select:focus {
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
            outline: none;
        }

        /* Preset Options Styling */
        .preset-options {
            display: flex;
            gap: 8px;
        }

        .preset-options button {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        body.dark-theme .preset-options button {
            background: rgba(17, 17, 17, 0.98);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        /* Add styles for selected state */
        body.dark-theme .preset-options button.selected {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.2);
        }

        body.dark-theme .preset-options button:hover {
            background: rgba(30, 30, 30, 0.98);
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Light theme styles */
        body.light-theme .preset-options button {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #111111;
        }

        body.light-theme .preset-options button.selected {
            background: rgba(0, 0, 0, 0.1);
            border-color: rgba(0, 0, 0, 0.2);
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);
        }

        body.light-theme .preset-options button:hover {
            background: rgba(255, 255, 255, 0.9);
            border-color: rgba(0, 0, 0, 0.2);
        }

        /* Custom Amount Input Styling */
        #customAmount input {
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 8px;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
        }

        body.light-theme #customAmount input {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #111111;
        }

        body.dark-theme #customAmount input {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        /* Progress Bar and Animation Styling */
        .send-progress {
            margin: 1rem 0 1.5rem 0;
            background: rgba(17, 17, 17, 0.98);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 1rem;
            opacity: 1;
            transition: opacity 0.8s ease-out;
        }

        .send-progress.fade-out {
            opacity: 0;
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
        }

        .progress-bar {
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #10B981;
            width: 0%;
            transition: width 1.2s ease-in-out; /* Slower progress animation */
        }

        .sending-animation {
            animation: sendingPulse 3s infinite; /* Slower pulse animation */
        }

        @keyframes sendingPulse {
            0% { opacity: 1; }
            50% { opacity: 0.6; }
            100% { opacity: 1; }
        }

        /* Updated Stop Button Styling */
        .stop-button {
            width: 28px;
            height: 28px;
            background: rgba(17, 17, 17, 0.98);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            padding: 0;
            backdrop-filter: blur(10px);
        }

        .stop-button i {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.2s ease;
        }

        .stop-button:hover {
            background: rgba(30, 30, 30, 0.98);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1), 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .stop-button:hover i {
            color: rgba(255, 255, 255, 1);
        }

        .stop-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Button Group for Sending and Preview */
        .button-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Updated Preview Button Styling */
        .preview-button {
            height: 45px;  /* Match the height of send button */
            width: 45px;   /* Make it square */
            border: none;
            border-radius: 8px;  /* Match send button's border radius */
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;  /* Match the theme */
            color: #000000;
            transition: all 0.2s ease;
        }

        body.light-theme .preview-button {
            background: #111111;
            color: #ffffff;
        }

        body.dark-theme .preview-button {
            background: #ffffff;
            color: #000000;
        }

        .preview-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1), 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .preview-button i {
            font-size: 18px;  /* Slightly larger icon */
        }
    </style>
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
                <label>Spoofed Email</label>
                <input type="email" name="from" required>
            </div>

            <div class="form-group">
                <label>Spoofed Name</label>
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

            // Update the file input handler script
            const fileInput = document.getElementById('attachment');
            const fileNameSpan = document.getElementById('file-name');
            const fileListDiv = document.getElementById('file-list');

            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const files = e.target.files;

                    if (files.length === 0) {
                        fileNameSpan.textContent = 'Attach Files (Drag & Drop or Click)';
                        fileListDiv.innerHTML = '';
                    } else {
                        fileNameSpan.textContent = `${files.length} file(s) selected`;
                        
                        // Clear previous list
                        fileListDiv.innerHTML = '';
                        
                        // Add each file with its size
                        Array.from(files).forEach(file => {
                            const size = formatFileSize(file.size);
                            const div = document.createElement('div');
                            // Use textContent instead of innerHTML for safe text handling
                            const fileEntry = document.createElement('div');
                            fileEntry.textContent = `${file.name} (${size})`;
                            fileEntry.style.display = 'flex';
                            fileEntry.style.alignItems = 'center';
                            
                            // Add bullet point as a separate element
                            const bullet = document.createElement('span');
                            bullet.textContent = '•';
                            bullet.style.marginRight = '8px';
                            
                            div.appendChild(bullet);
                            div.appendChild(fileEntry);
                            fileListDiv.appendChild(div);
                        });
                    }
                });
            }

            // Format file size function
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
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

            // Handle status message animation
            const statusMessage = document.querySelector('.status-message');
            if (statusMessage) {
                // Remove the message from DOM after animation completes
                statusMessage.addEventListener('animationend', function() {
                    setTimeout(() => {
                        statusMessage.remove();
                    }, 3000);
                });
            }

            const form = document.getElementById('emailForm');
            const modal = document.getElementById('previewModal');
            const closeBtn = document.querySelector('.close-preview');
            const confirmBtn = document.getElementById('confirmSend');
            
            function showPreview() {
                // Update preview content
                document.getElementById('previewFrom').textContent = form.from.value;
                document.getElementById('previewFromName').textContent = form.from_name.value;
                document.getElementById('previewTo').textContent = form.to.value;
                document.getElementById('previewSubject').textContent = form.subject.value;
                document.getElementById('previewMessage').textContent = form.message.value;
                
                // Handle attachments
                const attachmentsDiv = document.getElementById('previewAttachments');
                attachmentsDiv.innerHTML = '';
                const files = form.attachment.files;
                
                if (files.length > 0) {
                    Array.from(files).forEach(file => {
                        const attachmentEl = document.createElement('div');
                        attachmentEl.className = 'attachment-item';
                        attachmentEl.innerHTML = `
                            <i class="fas fa-paperclip"></i>
                            <span>${file.name} (${formatFileSize(file.size)})</span>
                        `;
                        attachmentsDiv.appendChild(attachmentEl);
                    });
                } else {
                    attachmentsDiv.innerHTML = '<span>No attachments</span>';
                }
                
                // Show modal
                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
            
            // Close modal handlers
            function closeModal() {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
            
            closeBtn.addEventListener('click', closeModal);
            
            // Handle actual form submission
            confirmBtn.addEventListener('click', function() {
                closeModal();
                form.submit();
            });
            
            // Close modal if clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            const sendType = document.getElementById('sendType');
            const presetOptions = document.getElementById('presetOptions');
            const customAmount = document.getElementById('customAmount');
            let selectedAmount = 1;
            let isUnlimited = false;

            // Handle send type changes
            sendType.addEventListener('change', function() {
                presetOptions.style.display = 'none';
                customAmount.style.display = 'none';
                isUnlimited = false;

                switch(this.value) {
                    case 'preset':
                        presetOptions.style.display = 'flex';
                        break;
                    case 'custom':
                        customAmount.style.display = 'block';
                        break;
                    case 'unlimited':
                        isUnlimited = true;
                        break;
                    default:
                        selectedAmount = 1;
                }
            });

            // Handle preset button clicks
            presetOptions.querySelectorAll('button').forEach(button => {
                button.addEventListener('click', function() {
                    // Remove selected class from all buttons
                    presetOptions.querySelectorAll('button').forEach(btn => {
                        btn.classList.remove('selected');
                    });
                    // Add selected class to clicked button
                    this.classList.add('selected');
                    selectedAmount = parseInt(this.dataset.amount);
                });
            });

            const sendProgress = document.getElementById('sendProgress');
            const progressText = document.getElementById('progressText');
            const progressFill = document.getElementById('progressFill');
            const stopButton = document.getElementById('stopSending');
            let shouldStop = false;

            // Handle stop button
            stopButton.addEventListener('click', function() {
                shouldStop = true;
                stopButton.disabled = true;
            });

            // Update progress UI
            function updateProgress(current, total) {
                if (total === -1) {
                    // Unlimited mode
                    progressText.textContent = `Sending emails: ${current} sent`;
                    progressText.classList.add('sending-animation');
                    progressFill.style.width = '100%';
                } else {
                    // Fixed amount mode
                    const percentage = (current / total) * 100;
                    progressText.textContent = `Sending emails: ${current}/${total}`;
                    progressFill.style.width = `${percentage}%`;
                }
            }

            // Reset progress UI with smooth fade
            function resetProgress() {
                sendProgress.classList.add('fade-out');
                progressText.classList.remove('sending-animation');
                
                // Wait for fade animation to complete
                setTimeout(() => {
                    sendProgress.style.display = 'none';
                    sendProgress.classList.remove('fade-out');
                    progressFill.style.width = '0%';
                    stopButton.style.display = 'none';
                    stopButton.disabled = false;
                    shouldStop = false;
                }, 800); // Match the CSS transition duration
            }

            // Update the email sending delay
            async function sendEmail() {
                const formData = new FormData(form);
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData
                    });
                    // Add artificial delay to make progress more visible
                    await new Promise(resolve => setTimeout(resolve, 800));
                    return response.ok;
                } catch (error) {
                    console.error('Error sending email:', error);
                    return false;
                }
            }

            // Handle form submission
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const sendCount = isUnlimited ? -1 : 
                                 sendType.value === 'custom' ? parseInt(customAmount.querySelector('input').value) : 
                                 selectedAmount;

                if (sendCount === 0 || isNaN(sendCount)) {
                    alert('Please select a valid number of times to send');
                    return;
                }

                // Show progress UI
                sendProgress.style.display = 'block';
                if (isUnlimited) {
                    stopButton.style.display = 'block';
                }

                let sentCount = 0;
                
                // Send emails based on count
                if (isUnlimited) {
                    while (!shouldStop) {
                        if (await sendEmail()) {
                            sentCount++;
                            updateProgress(sentCount, -1);
                        }
                        await new Promise(resolve => setTimeout(resolve, 100));
                    }
                } else {
                    for (let i = 0; i < sendCount; i++) {
                        if (await sendEmail()) {
                            sentCount++;
                            updateProgress(sentCount, sendCount);
                        }
                        await new Promise(resolve => setTimeout(resolve, 100));
                    }
                }

                // Reset UI after completion
                resetProgress();
            });

            const previewButton = document.querySelector('.preview-button');
            if (previewButton) {
                previewButton.addEventListener('click', showPreview);
            }
        });

        // Move the squares animation code to the top of your scripts
        const canvas = document.getElementById('squaresBackground');
        const ctx = canvas.getContext('2d');

        let squareSize = 40;
        let speed = 0.5;
        let gridOffset = { x: 0, y: 0 };
        let hoveredSquare = null;
        let animationFrame;
        let mousePos = { x: 0, y: 0 };
        let ripples = [];

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }

        function isLightTheme() {
            return document.body.classList.contains('light-theme');
        }

        function getColors() {
            return {
                border: isLightTheme() ? 'rgba(0, 0, 0, 0.15)' : 'rgba(255, 255, 255, 0.1)',
                hover: isLightTheme() ? 'rgba(0, 0, 0, 0.1)' : 'rgba(255, 255, 255, 0.08)',
                ripple: isLightTheme() ? 'rgba(0, 0, 0, 0.05)' : 'rgba(255, 255, 255, 0.03)',
                background: isLightTheme() ? '#f0f0f0' : '#060606' /* Updated light background */
            };
        }

        function createRipple(x, y) {
            ripples.push({
                x,
                y,
                radius: 0,
                maxRadius: squareSize * 6,
                alpha: 0.5,
                speed: 2
            });
        }

        function drawGrid() {
            if (!ctx) return;

            const colors = getColors();
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Set canvas background
            ctx.fillStyle = colors.background;
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Update diagonal movement
            gridOffset.x = (gridOffset.x - speed + squareSize) % squareSize;
            gridOffset.y = (gridOffset.y - speed + squareSize) % squareSize;

            const startX = Math.floor(gridOffset.x / squareSize) * squareSize;
            const startY = Math.floor(gridOffset.y / squareSize) * squareSize;

            ctx.lineWidth = 0.5;

            // Draw ripples
            ripples.forEach((ripple, index) => {
                ripple.radius += ripple.speed;
                ripple.alpha *= 0.98;

                if (ripple.radius > ripple.maxRadius || ripple.alpha < 0.01) {
                    ripples.splice(index, 1);
                    return;
                }

                ctx.beginPath();
                ctx.arc(ripple.x, ripple.y, ripple.radius, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(${isLightTheme() ? '0,0,0' : '255,255,255'},${ripple.alpha * 0.1})`;
                ctx.fill();
            });

            // Draw squares with interactive effects
            for (let x = startX; x < canvas.width + squareSize; x += squareSize) {
                for (let y = startY; y < canvas.height + squareSize; y += squareSize) {
                    const squareX = x - (gridOffset.x % squareSize);
                    const squareY = y - (gridOffset.y % squareSize);

                    // Calculate distance from mouse to square center
                    const centerX = squareX + squareSize / 2;
                    const centerY = squareY + squareSize / 2;
                    const dx = mousePos.x - centerX;
                    const dy = mousePos.y - centerY;
                    const distance = Math.sqrt(dx * dx + dy * dy);
                    const maxDistance = squareSize * 4;

                    if (distance < maxDistance) {
                        // Interactive hover effect
                        const intensity = 1 - (distance / maxDistance);
                        ctx.fillStyle = `rgba(${isLightTheme() ? '0,0,0' : '255,255,255'},${intensity * 0.1})`;
                        ctx.fillRect(squareX, squareY, squareSize, squareSize);

                        // Subtle scale effect
                        const scale = 1 + (intensity * 0.1);
                        ctx.save();
                        ctx.translate(centerX, centerY);
                        ctx.scale(scale, scale);
                        ctx.translate(-centerX, -centerY);
                    }

                    ctx.strokeStyle = colors.border;
                    ctx.strokeRect(squareX, squareY, squareSize, squareSize);

                    if (distance < maxDistance) {
                        ctx.restore();
                    }
                }
            }

            animationFrame = requestAnimationFrame(drawGrid);
        }

        // Initialize canvas and start animation
        function initCanvas() {
            resizeCanvas();
            
            // Set initial background color
            if (ctx) {
                ctx.fillStyle = getColors().background;
                ctx.fillRect(0, 0, canvas.width, canvas.height);
            }
            
            drawGrid();

            window.addEventListener('resize', resizeCanvas);
            canvas.addEventListener('mousemove', (event) => {
                const rect = canvas.getBoundingClientRect();
                mousePos.x = event.clientX - rect.left;
                mousePos.y = event.clientY - rect.top;

                if (Math.random() < 0.1) {
                    createRipple(mousePos.x, mousePos.y);
                }
            });

            canvas.addEventListener('click', (event) => {
                const rect = canvas.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const y = event.clientY - rect.top;
                
                for (let i = 0; i < 3; i++) {
                    setTimeout(() => {
                        createRipple(
                            x + (Math.random() - 0.5) * 20,
                            y + (Math.random() - 0.5) * 20
                        );
                    }, i * 100);
                }
            });

            canvas.addEventListener('mouseleave', () => {
                hoveredSquare = null;
            });
        }

        // Initialize immediately after canvas is available
        if (canvas && canvas.getContext) {
            const ctx = canvas.getContext('2d');
            if (ctx) {
                ctx.fillStyle = getColors().background;
                ctx.fillRect(0, 0, canvas.width, canvas.height);
            }
        }

        // Start the animation when the page loads
        document.addEventListener('DOMContentLoaded', initCanvas);

        // Update animation on theme change
        document.getElementById('themeToggle').addEventListener('click', () => {
            // The colors will update automatically in the next animation frame
        });

        // Cleanup
        window.addEventListener('unload', () => {
            if (animationFrame) {
                cancelAnimationFrame(animationFrame);
            }
        });
    </script>
</body>
</html> 
