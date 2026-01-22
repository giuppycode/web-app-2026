// Project Admin JavaScript

// Current state
let currentMemberId = null;
let currentMemberName = '';
let currentRoleId = null;
let currentRoleName = '';

// =======================
// DROPDOWN TOGGLES
// =======================

function toggleEdit(editId) {
    const editContainer = document.getElementById(editId);
    const dropdown = editContainer.previousElementSibling;
    
    if (editContainer.style.display === 'none') {
        editContainer.style.display = 'block';
        dropdown.classList.add('open');
    } else {
        editContainer.style.display = 'none';
        dropdown.classList.remove('open');
    }
}

// =======================
// IMAGE UPLOAD
// =======================

const fileInput = document.getElementById('project_image');
const uploadArea = document.getElementById('uploadArea');
const currentImageContainer = document.getElementById('currentImageContainer');
const previewContainer = document.getElementById('previewContainer');
const imagePreview = document.getElementById('imagePreview');
const removeBtn = document.getElementById('removeImageBtn');

if (uploadArea && currentImageContainer) {
    uploadArea.addEventListener('click', (e) => {
        if (!previewContainer || previewContainer.style.display === 'none') {
            fileInput.click();
        }
    });
}

if (fileInput) {
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
                currentImageContainer.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });
}

if (removeBtn) {
    removeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        fileInput.value = '';
        previewContainer.style.display = 'none';
        currentImageContainer.style.display = 'block';
    });
}

// =======================
// NEWS MODAL
// =======================

function openNewsModal() {
    document.getElementById('newsModal').style.display = 'flex';
    document.getElementById('news_text').focus();
}

function closeNewsModal() {
    document.getElementById('newsModal').style.display = 'none';
    document.getElementById('news_text').value = '';
}

// =======================
// ADD ROLE MODAL
// =======================

function openAddRoleModal() {
    document.getElementById('addRoleModal').style.display = 'flex';
    document.getElementById('role_name').value = '';
}

function closeAddRoleModal() {
    document.getElementById('addRoleModal').style.display = 'none';
}

// =======================
// MEMBER ACTIONS
// =======================

function openMemberMenu(memberId, memberName) {
    currentMemberId = memberId;
    currentMemberName = memberName;
    document.getElementById('memberModalTitle').textContent = `Manage ${memberName}`;
    document.getElementById('memberModal').style.display = 'flex';
}

function closeMemberModal() {
    document.getElementById('memberModal').style.display = 'none';
    currentMemberId = null;
    currentMemberName = '';
}

function editMemberRole() {
    // TODO: Implement role editing
    alert(`Edit role for member ID: ${currentMemberId}`);
    closeMemberModal();
}

function removeMember() {
    if (!confirm(`Are you sure you want to remove ${currentMemberName} from the project?`)) {
        return;
    }
    
    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '../actions/remove_member.php';
    
    const projectIdInput = document.createElement('input');
    projectIdInput.type = 'hidden';
    projectIdInput.name = 'project_id';
    projectIdInput.value = new URLSearchParams(window.location.search).get('id');
    
    const userIdInput = document.createElement('input');
    userIdInput.type = 'hidden';
    userIdInput.name = 'user_id';
    userIdInput.value = currentMemberId;
    
    form.appendChild(projectIdInput);
    form.appendChild(userIdInput);
    document.body.appendChild(form);
    form.submit();
}

// =======================
// ROLE ACTIONS
// =======================

function openRoleMenu(roleId, roleName) {
    currentRoleId = roleId;
    currentRoleName = roleName;
    document.getElementById('roleModalTitle').textContent = `Manage ${roleName}`;
    document.getElementById('roleModal').style.display = 'flex';
}

function closeRoleModal() {
    document.getElementById('roleModal').style.display = 'none';
    currentRoleId = null;
    currentRoleName = '';
}

function deleteRole() {
    if (!confirm(`Are you sure you want to delete the "${currentRoleName}" role?`)) {
        return;
    }
    
    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '../actions/delete_role.php';
    
    const projectIdInput = document.createElement('input');
    projectIdInput.type = 'hidden';
    projectIdInput.name = 'project_id';
    projectIdInput.value = new URLSearchParams(window.location.search).get('id');
    
    const roleIdInput = document.createElement('input');
    roleIdInput.type = 'hidden';
    roleIdInput.name = 'role_id';
    roleIdInput.value = currentRoleId;
    
    form.appendChild(projectIdInput);
    form.appendChild(roleIdInput);
    document.body.appendChild(form);
    form.submit();
}

// =======================
// APPLICATIONS MODAL
// =======================

function openApplicationsModal() {
    document.getElementById('applicationsModal').style.display = 'flex';
}

function closeApplicationsModal() {
    document.getElementById('applicationsModal').style.display = 'none';
}

// =======================
// MODAL CLOSE HANDLERS
// =======================

window.addEventListener('click', (e) => {
    const newsModal = document.getElementById('newsModal');
    const roleModal = document.getElementById('addRoleModal');
    const memberModal = document.getElementById('memberModal');
    const roleActionsModal = document.getElementById('roleModal');
    const applicationsModal = document.getElementById('applicationsModal');
    
    if (e.target === newsModal) closeNewsModal();
    if (e.target === roleModal) closeAddRoleModal();
    if (e.target === memberModal) closeMemberModal();
    if (e.target === roleActionsModal) closeRoleModal();
    if (e.target === applicationsModal) closeApplicationsModal();
});

window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeNewsModal();
        closeAddRoleModal();
        closeMemberModal();
        closeRoleModal();
        closeApplicationsModal();
    }
});

// =======================
// UTILITY FUNCTIONS
// =======================

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}