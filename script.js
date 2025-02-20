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