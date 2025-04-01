/**
 * Page Loading Effects - Hiệu ứng tải trang
 * Áp dụng cho tất cả các trang để tạo trải nghiệm nhất quán
 */
document.addEventListener('DOMContentLoaded', function() {
    // 1. Thêm overlay loading nếu chưa có
    createLoadingOverlay();
    
    // 2. Hiển thị loading khi trang đang tải
    showLoading();
    
    // 3. Ẩn loading khi trang đã tải xong
    window.addEventListener('load', function() {
        hideLoading();
        
        // Thêm hiệu ứng fadeIn cho tất cả các section
        const sections = document.querySelectorAll('section');
        sections.forEach((section, index) => {
            section.style.opacity = '0';
            setTimeout(() => {
                section.style.transition = 'opacity 0.5s ease';
                section.style.opacity = '1';
            }, 100 * index); // Tạo hiệu ứng lần lượt cho các section
        });
    });
    
    // 4. Xử lý hiệu ứng loading khi chuyển trang
    document.addEventListener('click', function(e) {
        const target = e.target.closest('a');
        if (target && !target.hasAttribute('target') && !target.getAttribute('href').startsWith('#')) {
            e.preventDefault();
            const href = target.getAttribute('href');
            
            // Kiểm tra nếu là link nội bộ (không phải link ngoài)
            if (href && !href.includes('://')) {
                showLoading();
                
                setTimeout(() => {
                    window.location.href = href;
                }, 800);
            }
        }
    });
});

// Hàm tạo overlay loading
function createLoadingOverlay() {
    // Kiểm tra nếu đã có overlay thì không tạo nữa
    if (!document.querySelector('.loading-overlay')) {
        const overlay = document.createElement('div');
        overlay.className = 'loading-overlay';
        overlay.innerHTML = '<div class="loading-spinner"></div>';
        document.body.appendChild(overlay);
    }
}

// Hàm hiển thị loading
function showLoading() {
    const overlay = document.querySelector('.loading-overlay');
    if (overlay) {
        overlay.style.display = 'flex';
    }
}

// Hàm ẩn loading
function hideLoading() {
    const overlay = document.querySelector('.loading-overlay');
    if (overlay) {
        overlay.style.opacity = '0';
        overlay.style.transition = 'opacity 0.5s ease';
        
        setTimeout(() => {
            overlay.style.display = 'none';
            overlay.style.opacity = '1';
        }, 500);
    }
}

// Hàm tạo và hiển thị toast notification
function showToast(message, type = 'info') {
    // Kiểm tra xem đã có container chưa
    let container = document.querySelector('.toast-container');
    
    // Nếu chưa có thì tạo mới
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }
    
    // Tạo toast
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    
    // Thêm icon phù hợp với type
    const icon = document.createElement('i');
    switch(type) {
        case 'success':
            icon.className = 'fas fa-check-circle';
            break;
        case 'error':
            icon.className = 'fas fa-times-circle';
            break;
        case 'warning':
            icon.className = 'fas fa-exclamation-circle';
            break;
        case 'info':
        default:
            icon.className = 'fas fa-info-circle';
    }
    
    // Thêm nội dung
    const text = document.createElement('span');
    text.textContent = message;
    
    // Ghép lại
    toast.appendChild(icon);
    toast.appendChild(text);
    container.appendChild(toast);
    
    // Hiển thị toast sau đó
    setTimeout(() => {
        toast.classList.add('show');
        
        // Tự động ẩn sau 3 giây
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }, 100);
} 