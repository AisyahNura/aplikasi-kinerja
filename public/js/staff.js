// Staff Comment Features
class StaffCommentManager {
    constructor() {
        this.init();
    }

    init() {
        this.initMarkAllRead();
        this.initCommentCards();
    }

    initMarkAllRead() {
        const markAllReadBtn = document.getElementById('markAllReadBtn');
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', () => this.markAllCommentsAsRead());
        }
    }

    initCommentCards() {
        // Add hover effects to comment cards
        document.querySelectorAll('.comment-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-2px)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });
    }

    async markAllCommentsAsRead() {
        try {
            const response = await fetch('/staff/komentar/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Content-Type': 'application/json',
                },
            });

            const data = await response.json();
            
            if (data.success) {
                this.updateUIAfterMarkAllRead();
                this.showNotification('Semua komentar telah ditandai sebagai dibaca', 'success');
            } else {
                this.showNotification('Terjadi kesalahan saat menandai komentar', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Terjadi kesalahan saat menandai komentar', 'error');
        }
    }

    updateUIAfterMarkAllRead() {
        // Remove "Baru" badges and blue border
        document.querySelectorAll('.border-l-blue-500').forEach(element => {
            element.classList.remove('border-l-blue-500', 'bg-blue-50');
            element.classList.add('border-l-gray-200');
        });
        
        // Remove "Baru" badges
        document.querySelectorAll('.bg-red-100').forEach(element => {
            element.remove();
        });
        
        // Hide the button
        const markAllReadBtn = document.getElementById('markAllReadBtn');
        if (markAllReadBtn) {
            markAllReadBtn.style.display = 'none';
        }
    }

    showNotification(message, type = 'info') {
        // Remove existing notifications
        document.querySelectorAll('.staff-notification').forEach(notification => {
            notification.remove();
        });

        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg staff-notification notification ${
            type === 'success' ? 'bg-green-500 text-white' : 
            type === 'error' ? 'bg-red-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        
        notification.innerHTML = `
            <div class="flex items-center">
                <span class="mr-2">
                    ${type === 'success' ? '✓' : type === 'error' ? '✕' : 'ℹ'}
                </span>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 3000);
    }

    // Utility function to format date
    formatDate(dateString) {
        const date = new Date(dateString);
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        return date.toLocaleDateString('id-ID', options);
    }

    // Utility function to format time
    formatTime(dateString) {
        const date = new Date(dateString);
        return date.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize comment manager if we're on the comment page
    if (document.querySelector('.comment-card')) {
        window.staffCommentManager = new StaffCommentManager();
    }
    
    // Add CSRF token to all forms
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (csrfToken) {
        document.querySelectorAll('form').forEach(form => {
            if (!form.querySelector('input[name="_token"]')) {
                const tokenInput = document.createElement('input');
                tokenInput.type = 'hidden';
                tokenInput.name = '_token';
                tokenInput.value = csrfToken;
                form.appendChild(tokenInput);
            }
        });
    }
});

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = StaffCommentManager;
} 