document.addEventListener('DOMContentLoaded', function () {
    // Dropdown menu code

    const dropdownButton = document.querySelector('.relative');
    if (dropdownButton) {
        const dropdownMenu = dropdownButton.querySelector('.dropdown-menu');
        let timeout;
        dropdownButton.addEventListener('mouseenter', function() {
            clearTimeout(timeout);
            dropdownMenu.classList.add('show');
        });
        dropdownButton.addEventListener('mouseleave', function() {
            timeout = setTimeout(function() {
                dropdownMenu.classList.remove('show');
            }, 300);
        });
        dropdownMenu.addEventListener('mouseenter', function() {
            clearTimeout(timeout);
        });
        dropdownMenu.addEventListener('mouseleave', function() {
            timeout = setTimeout(function() {
                dropdownMenu.classList.remove('show');
            }, 300);
        });
    }

    // Product image preview code
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const removeImageBtn = document.getElementById('removeImageBtn');
    const imagePopup = document.getElementById('imagePopup');
    const popupImage = document.getElementById('popupImage');
    const closePopup = document.getElementById('closePopup');
    if (imageInput && imagePreview && removeImageBtn && imagePopup && popupImage && closePopup) {
        imageInput.addEventListener('change', function (event) {
            const [file] = event.target.files;
            if (file) {
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.classList.remove('hidden');
                removeImageBtn.classList.remove('hidden');
            }
        });
        removeImageBtn.addEventListener('click', function () {
            imageInput.value = '';
            imagePreview.src = '#';
            imagePreview.classList.add('hidden');
            removeImageBtn.classList.add('hidden');
        });
        imagePreview.addEventListener('click', function () {
            popupImage.src = imagePreview.src;
            imagePopup.classList.remove('hidden');
        });
        closePopup.addEventListener('click', function () {
            imagePopup.classList.add('hidden');
        });
        imagePopup.addEventListener('click', function (e) {
            if (e.target === imagePopup) {
                imagePopup.classList.add('hidden');
            }
        });
    }

    // Avatar Preview For Vendor Profile Edit
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatarPreview');
    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', function (event) {
            const [file] = event.target.files;
            if (file) {
                avatarPreview.src = URL.createObjectURL(file);
            }
        });
    }
});
