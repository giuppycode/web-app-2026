const fileInput = document.getElementById('project_image');
const uploadArea = document.getElementById('uploadArea');
const previewContainer = document.getElementById('previewContainer');
const imagePreview = document.getElementById('imagePreview');
const removeBtn = document.getElementById('removeImageBtn');

uploadArea.addEventListener('click', () => {
    if (!previewContainer.style.display || previewContainer.style.display === 'none') {
        fileInput.click();
    }
});

fileInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB');
            fileInput.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.src = e.target.result;
            previewContainer.style.display = 'block';
            uploadArea.querySelector('.upload-content').style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
});

removeBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    fileInput.value = '';
    previewContainer.style.display = 'none';
    uploadArea.querySelector('.upload-content').style.display = 'flex';
});