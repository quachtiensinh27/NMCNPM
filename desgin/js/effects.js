// Loading Animation
function showLoading() {
   const overlay = document.createElement('div');
   overlay.className = 'loading-overlay';
   overlay.innerHTML = '<div class="loading-spinner"></div>';
   document.body.appendChild(overlay);
   overlay.style.display = 'flex';
}

function hideLoading() {
   const overlay = document.querySelector('.loading-overlay');
   if (overlay) {
      overlay.style.display = 'none';
      setTimeout(() => overlay.remove(), 300);
   }
}

// Toast Notification
function showToast(message, type = 'info') {
   const container = document.querySelector('.toast-container') || createToastContainer();
   const toast = document.createElement('div');
   toast.className = `toast ${type}`;
   
   const icon = document.createElement('i');
   icon.className = getToastIcon(type);
   
   const text = document.createElement('span');
   text.textContent = message;
   
   toast.appendChild(icon);
   toast.appendChild(text);
   container.appendChild(toast);
   
   // Trigger reflow
   toast.offsetHeight;
   toast.classList.add('show');
   
   setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => toast.remove(), 300);
   }, 3000);
}

function createToastContainer() {
   const container = document.createElement('div');
   container.className = 'toast-container';
   document.body.appendChild(container);
   return container;
}

function getToastIcon(type) {
   switch(type) {
      case 'success': return 'fas fa-check-circle';
      case 'error': return 'fas fa-times-circle';
      case 'warning': return 'fas fa-exclamation-circle';
      case 'info': return 'fas fa-info-circle';
      default: return 'fas fa-info-circle';
   }
}

// Skeleton Loading
function showSkeleton(element, type = 'text') {
   const skeleton = document.createElement('div');
   skeleton.className = `skeleton skeleton-${type}`;
   element.innerHTML = '';
   element.appendChild(skeleton);
}

function hideSkeleton(element) {
   const skeleton = element.querySelector('.skeleton');
   if (skeleton) {
      skeleton.remove();
   }
}

// Page Transition
document.addEventListener('DOMContentLoaded', function() {
   // Show loading on page load
   showLoading();
   
   // Hide loading when page is fully loaded
   window.addEventListener('load', hideLoading);
   
   // Show loading on link clicks
   document.addEventListener('click', function(e) {
      if (e.target.tagName === 'A' && !e.target.hasAttribute('target')) {
         showLoading();
      }
   });
});

// Hàm xử lý hiệu ứng cho trang courses
function initCoursesEffects() {
   // Hiển thị loading animation
   showLoading();

   // Ẩn skeleton loading sau khi trang load xong
   setTimeout(() => {
      const skeletons = document.querySelectorAll('.skeleton');
      skeletons.forEach(skeleton => skeleton.remove());
   }, 1000);

   // Thêm toast notification khi xem khóa học
   const courseBtns = document.querySelectorAll('.courses .inline-option-btn');
   courseBtns.forEach(btn => {
      btn.addEventListener('click', function(e) {
         e.preventDefault();
         showToast('Đang chuyển hướng đến khóa học...', 'info');
         setTimeout(() => {
            window.location.href = this.getAttribute('href');
         }, 1000);
      });
   });

   // Thêm toast notification khi xem thêm
   const moreBtn = document.querySelector('.courses .more-btn .btn');
   if (moreBtn) {
      moreBtn.addEventListener('click', function(e) {
         e.preventDefault();
         showToast('Đang tải thêm khóa học...', 'info');
         setTimeout(() => {
            window.location.href = this.getAttribute('href');
         }, 1000);
      });
   }

   // Ẩn loading animation sau khi trang load xong
   setTimeout(() => {
      hideLoading();
   }, 1000);
}

// Thêm event listener cho DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
   // Kiểm tra nếu đang ở trang courses
   if (document.querySelector('.courses')) {
      initCoursesEffects();
   }
});

// Example usage:
// showToast('Operation successful!', 'success');
// showToast('Something went wrong!', 'error');
// showToast('Please wait...', 'warning');
// showToast('New updates available!', 'info');

// showSkeleton(element, 'text');
// showSkeleton(element, 'image');
// hideSkeleton(element); 