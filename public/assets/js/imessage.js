class Message {
    constructor(toastId) {
        this.insertStyles();
        this.toastContainer = document.querySelector('.toast-container') || this.createContainer();
        this.toastElement = this.createToast(toastId);
        this.toastContainer.appendChild(this.toastElement);
        this.toastInstance = new bootstrap.Toast(this.toastElement);

        this.toastElement.addEventListener('mouseenter', () => {
            this.isHovering = true;  // Mark that the mouse is hovering over the toast
        });

        this.toastElement.addEventListener('mouseleave', () => {
            this.isHovering = false;  // Mark that the mouse is not hovering over the toast
            if (this.autoHideTimeout) {
                this.autoHideTimeout = setTimeout(() => this.hide(), this.timeout);
            }
        });
    }

    insertStyles() {
        if (!document.getElementById('toast-styles')) {
            document.head.insertAdjacentHTML('beforeend', `
                <style id="toast-styles">
                    @keyframes slideFromTop { 
                        0% { transform: translateY(-20px); opacity: 0; } 
                        100% { transform: translateY(0); opacity: 1; } 
                    }
                    .toast-container {
                        z-index: 1001;
                    }
                </style>
            `);
        }
    }

    createContainer(position = "top-right") {
        const container = document.createElement('div');
        container.className = `toast-container position-fixed p-3 ${this.getPositionClass(position)}`;
        document.body.appendChild(container);
        return container;
    }

    createToast(id) {
        const toast = document.createElement('div');
        toast.id = id;
        toast.className = 'toast align-items-center border-0';
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'polite');
        toast.setAttribute('aria-atomic', 'true');

        toast.innerHTML = `
            <div class="d-flex toast-content rounded-3">
                <div class="toast-body"></div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;

        this.toastBody = toast.querySelector('.toast-body');
        this.toastContent = toast.querySelector('.toast-content');
        return toast;
    }

    show(message = "Message sent successfully!", type = "success", position = "top-right", timeout = 3000) {
        // Set the position of the toast container
        this.toastContainer.className = `toast-container position-fixed p-3 ${this.getPositionClass(position)}`;
        this.timeout = timeout;  // Store timeout for later use
    
        // Types object with styling for different toast types
        const types = {
            success: {
                bg: 'bg-opacity-25 border-success border-opacity-75 rounded-2',
                text: 'text-success',
                weight: 'font-weight-bold'
            },
            warning: {
                bg: 'bg-opacity-25 border-warning border-opacity-75 rounded-2',
                text: 'text-warning',
                weight: 'font-weight-bold'
            },
            fail: {
                bg: 'bg-opacity-25 border-danger border-opacity-75 rounded-2',
                text: 'text-danger',
                weight: 'font-weight-bold'
            },
            info: {
                bg: 'bg-opacity-25 border-info border-opacity-75 rounded-2',
                text: 'text-info',
                weight: 'font-weight-bold'
            }
        };
    
        const typeClass = types[type] || types.success; // Default to success if type is invalid
    
        // Set the content of the toast
        this.toastBody.innerHTML = message;
        this.toastContent.className = `d-flex ${typeClass.bg}`;
        this.toastBody.className = `toast-body ${typeClass.text} ${typeClass.weight}`; // Apply bold text
    
        // Add an icon depending on the toast type
        this.addIcon(type);
    
        // Show the toast
        this.toastInstance.show();
    
        // Set a timeout to hide the toast unless the mouse is hovering over it
        if (!this.isHovering && timeout) {
            // Hide the toast after the specified timeout
            this.autoHideTimeout = setTimeout(() => this.hide(), timeout);
        }
    
        // If the toast is hovered, cancel the timeout or reset the autoHideTimeout
        this.toastElement.addEventListener('mouseenter', () => {
            clearTimeout(this.autoHideTimeout); // Cancel auto-hide when hovered
            this.isHovering = true;
        });
    
        this.toastElement.addEventListener('mouseleave', () => {
            this.isHovering = false;
            if (timeout) {
                // Set a new timeout to hide the toast after mouse leaves
                this.autoHideTimeout = setTimeout(() => this.hide(), timeout);
            }
        });
    }
    

    hide() {
        this.toastInstance.hide();
    }

    addIcon(type) {
        const icons = {
            success: ['fa-check', 'text-success'],
            warning: ['fa-exclamation-circle', 'text-warning'],
            fail: ['fa-times', 'text-danger'],
            info: ['fa-info-circle', 'text-info']
        };
        const [iconClass, color] = icons[type] || icons.success;
        const icon = `<i class="fa ${iconClass} me-2 ${color}" style="
            border: 2px solid ${this.getBorderColor(color)}; border-radius: 50%; padding: 8px;
            font-size: 12px; height: 16px; width: 16px; display: inline-flex; align-items: center;
            justify-content: center; animation: slideFromTop 0.5s ease-out; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);"></i>`;
        this.toastBody.innerHTML = icon + this.toastBody.innerHTML;
    }

    getBorderColor(colorClass) {
        const colorMap = {
            'text-success': '#198754',
            'text-warning': '#FFC107',
            'text-danger': '#DC3545',
            'text-info': '#0DCAF0'
        };
        return colorMap[colorClass] || '#000';
    }

    getPositionClass(position) {
        const positions = {
            "top-right": "top-0 end-0",
            "top-center": "top-0 start-50 translate-middle-x",
            "top-left": "top-0 start-0",
            "bottom-right": "bottom-0 end-0",
            "bottom-center": "bottom-0 start-50 translate-middle-x",
            "bottom-left": "bottom-0 start-0",
            "center": "top-50 start-50 translate-middle"
        };
        return positions[position] || positions["top-right"];
    }
}

// Example usage
const imessage = new Message('imessage');
