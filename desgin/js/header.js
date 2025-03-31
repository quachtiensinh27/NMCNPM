document.addEventListener('DOMContentLoaded', function() {
    fetch('header.html')
        .then(response => response.text())
        .then(data => {
            document.querySelector('header').outerHTML = data;
            
            // Thêm các sự kiện xử lý sau khi load header
            const menuBtn = document.querySelector('#menu-btn');
            const searchBtn = document.querySelector('#search-btn');
            const userBtn = document.querySelector('#user-btn');
            const toggleBtn = document.querySelector('#toggle-btn');
            const searchForm = document.querySelector('.search-form');
            const profile = document.querySelector('.profile');
            const sideBar = document.querySelector('.side-bar');
            const closeBtn = document.querySelector('#close-btn');

            // Xử lý nút menu
            menuBtn.addEventListener('click', () => {
                sideBar.classList.toggle('active');
                document.body.classList.toggle('active');
            });

            // Xử lý nút đóng sidebar
            closeBtn.addEventListener('click', () => {
                sideBar.classList.remove('active');
                document.body.classList.remove('active');
            });

            // Xử lý nút tìm kiếm
            searchBtn.addEventListener('click', () => {
                searchForm.classList.toggle('active');
            });

            // Xử lý nút user
            userBtn.addEventListener('click', () => {
                profile.classList.toggle('active');
            });

            // Xử lý nút chuyển đổi theme
            toggleBtn.addEventListener('click', () => {
                document.body.classList.toggle('dark');
            });

            // Xử lý click bên ngoài để đóng các menu
            window.addEventListener('click', (e) => {
                if (!e.target.closest('.search-form') && !e.target.closest('#search-btn')) {
                    searchForm.classList.remove('active');
                }
                if (!e.target.closest('.profile') && !e.target.closest('#user-btn')) {
                    profile.classList.remove('active');
                }
            });
        });
}); 