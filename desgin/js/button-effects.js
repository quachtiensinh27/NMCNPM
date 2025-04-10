/**
 * Button Effects - Xử lý hiệu ứng nổi lên và ripple cho tất cả các nút
 */
document.addEventListener('DOMContentLoaded', function() {
    // Danh sách các selector cần áp dụng hiệu ứng
    const buttonSelectors = [
        '.inline-btn', 
        '.btn', 
        '.inline-option-btn', 
        '.discover-btn',
        '.more-btn a',
        '.register-btn',
        '.courses .box .inline-option-btn'
    ];
    
    // 1. Thêm class hover-lift-effect và ripple-effect cho tất cả các nút
    buttonSelectors.forEach(selector => {
        const buttons = document.querySelectorAll(selector);
        buttons.forEach(button => {
            // Thêm class cho hiệu ứng nổi lên và ripple
            button.classList.add('hover-lift-effect', 'ripple-effect');
            
            // Thêm class hover-lift-parent cho phần tử cha
            if (button.parentElement) {
                button.parentElement.classList.add('hover-lift-parent');
            }
        });
    });
    
    // 2. Xử lý hiệu ứng ripple khi click
    const rippleButtons = document.querySelectorAll('.ripple-effect');
    rippleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Tạo hiệu ứng ripple từ vị trí click
            const x = e.clientX - this.getBoundingClientRect().left;
            const y = e.clientY - this.getBoundingClientRect().top;
            
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            
            this.appendChild(ripple);
            
            // Xóa phần tử ripple sau khi animation hoàn thành
            setTimeout(() => {
                ripple.remove();
            }, 800);
        });
    });
    
    // 3. Xử lý hiệu ứng hover intent (phát hiện ý định hover)
    document.addEventListener('mousemove', function(e) {
        rippleButtons.forEach(button => {
            // Tính toán khoảng cách từ chuột đến nút
            const rect = button.getBoundingClientRect();
            const btnCenterX = rect.left + rect.width / 2;
            const btnCenterY = rect.top + rect.height / 2;
            
            const distX = e.clientX - btnCenterX;
            const distY = e.clientY - btnCenterY;
            const distance = Math.sqrt(distX * distX + distY * distY);
            
            // Nếu chuột đến gần nút trong phạm vi 150px
            if (distance < 150) {
                // Tính độ mở rộng dựa trên khoảng cách (càng gần càng to)
                const scale = 1 - distance / 150;
                
                // Áp dụng hiệu ứng dựa trên khoảng cách
                button.style.transform = `translateY(${-5 * scale}px) scale(${1 + 0.03 * scale})`;
                button.style.boxShadow = `0 ${8 * scale}px ${16 * scale}px rgba(0, 0, 0, ${0.2 * scale})`;
                button.classList.add('hover-intent');
            } else {
                // Nếu chuột ở xa, reset trạng thái
                if (button.classList.contains('hover-intent')) {
                    button.style.transform = '';
                    button.style.boxShadow = '';
                    button.classList.remove('hover-intent');
                }
            }
        });
    });
}); 