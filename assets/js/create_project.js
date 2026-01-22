// Team Management for Create Project
let coFounders = []; // Array of user objects {id, username, firstname, lastname}
let roles = []; // Array of role names
let searchTimeout = null;

// Image Upload Preview
const fileInput = document.getElementById('project_image');
const uploadArea = document.getElementById('uploadArea');
const previewContainer = document.getElementById('previewContainer');
const imagePreview = document.getElementById('imagePreview');
const removeBtn = document.getElementById('removeImageBtn');

if (uploadArea) {
    uploadArea.addEventListener('click', () => {
        if (!previewContainer.style.display || previewContainer.style.display === 'none') {
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
                uploadArea.querySelector('.upload-content').style.display = 'none';
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
        uploadArea.querySelector('.upload-content').style.display = 'flex';
    });
}

// =======================
// CO-FOUNDERS MANAGEMENT
// =======================

document.getElementById('addMembersBtn').addEventListener('click', () => {
    openAddMembersModal();
});

function openAddMembersModal() {
    document.getElementById('addMembersModal').style.display = 'flex';
    document.getElementById('memberSearch').value = '';
    document.getElementById('searchResults').innerHTML = '<p class="search-hint">Start typing to search for users</p>';
}

function closeAddMembersModal() {
    document.getElementById('addMembersModal').style.display = 'none';
}

// Search users with debounce
document.getElementById('memberSearch').addEventListener('input', (e) => {
    clearTimeout(searchTimeout);
    const query = e.target.value.trim();
    
    if (query.length < 2) {
        document.getElementById('searchResults').innerHTML = '<p class="search-hint">Type at least 2 characters to search</p>';
        return;
    }
    
    searchTimeout = setTimeout(() => searchUsers(query), 300);
});

async function searchUsers(query) {
    const resultsContainer = document.getElementById('searchResults');
    resultsContainer.innerHTML = '<p class="search-hint">Searching...</p>';
    
    try {
        const response = await fetch(`../actions/api_search_users.php?q=${encodeURIComponent(query)}`);
        const users = await response.json();
        
        if (users.length === 0) {
            resultsContainer.innerHTML = '<p class="search-hint">No users found</p>';
            return;
        }
        
        resultsContainer.innerHTML = '';
        users.forEach(user => {
            // Check if already added as co-founder
            const isAdded = coFounders.some(cf => cf.id === user.id);
            
            const userDiv = document.createElement('div');
            userDiv.className = 'user-result' + (isAdded ? ' added' : '');
            userDiv.innerHTML = `
                <div class="user-result-avatar">
                    <span class="material-icons-round">person</span>
                </div>
                <div class="user-result-info">
                    <span class="user-result-name">${escapeHtml(user.firstname)} ${escapeHtml(user.lastname)}</span>
                    <span class="user-result-username">@${escapeHtml(user.username)}</span>
                </div>
                <button class="user-result-add" onclick="addCoFounder(${user.id}, '${escapeHtml(user.username)}', '${escapeHtml(user.firstname)}', '${escapeHtml(user.lastname)}')">
                    <span class="material-icons-round">${isAdded ? 'check' : 'add'}</span>
                </button>
            `;
            resultsContainer.appendChild(userDiv);
        });
    } catch (error) {
        console.error('Search error:', error);
        resultsContainer.innerHTML = '<p class="search-hint">Error searching users</p>';
    }
}

function addCoFounder(userId, username, firstname, lastname) {
    // Check if already added
    if (coFounders.some(cf => cf.id === userId)) {
        return;
    }
    
    const coFounder = { id: userId, username, firstname, lastname };
    coFounders.push(coFounder);
    
    // Update UI
    renderCoFounders();
    updateCoFoundersInput();
    
    // Mark as added in search results
    const searchResults = document.querySelectorAll('.user-result');
    searchResults.forEach(result => {
        const addBtn = result.querySelector('.user-result-add');
        const onclickAttr = addBtn.getAttribute('onclick');
        if (onclickAttr && onclickAttr.includes(`addCoFounder(${userId},`)) {
            result.classList.add('added');
            addBtn.querySelector('.material-icons-round').textContent = 'check';
        }
    });
}

function removeCoFounder(userId) {
    coFounders = coFounders.filter(cf => cf.id !== userId);
    renderCoFounders();
    updateCoFoundersInput();
}

function renderCoFounders() {
    const container = document.getElementById('foundersContainer');
    
    // Keep the current user chip (first child)
    const currentUserChip = container.firstElementChild;
    container.innerHTML = '';
    container.appendChild(currentUserChip);
    
    // Add co-founders
    coFounders.forEach(cf => {
        const chip = document.createElement('div');
        chip.className = 'team-chip founder-chip';
        chip.innerHTML = `
            <div class="chip-avatar">
                <span class="material-icons-round">person</span>
            </div>
            <div class="chip-info">
                <span class="chip-name">${escapeHtml(cf.firstname)} ${escapeHtml(cf.lastname)}</span>
                <span class="chip-role">Founder</span>
            </div>
            <button type="button" class="chip-remove" onclick="removeCoFounder(${cf.id})">
                <span class="material-icons-round">close</span>
            </button>
        `;
        container.appendChild(chip);
    });
}

function updateCoFoundersInput() {
    const input = document.getElementById('coFoundersInput');
    input.value = JSON.stringify(coFounders.map(cf => cf.id));
}

// =======================
// ROLES MANAGEMENT
// =======================

document.getElementById('addRoleBtn').addEventListener('click', () => {
    openAddRoleModal();
});

function openAddRoleModal() {
    document.getElementById('addRoleModal').style.display = 'flex';
    document.getElementById('roleName').value = '';
}

function closeAddRoleModal() {
    document.getElementById('addRoleModal').style.display = 'none';
}

function addRole() {
    const roleInput = document.getElementById('roleName');
    const roleName = roleInput.value.trim();
    
    if (!roleName) {
        alert('Please enter a role name');
        return;
    }
    
    if (roles.includes(roleName)) {
        alert('This role already exists');
        return;
    }
    
    roles.push(roleName);
    renderRoles();
    updateRolesInput();
    closeAddRoleModal();
}

function removeRole(roleName) {
    roles = roles.filter(r => r !== roleName);
    renderRoles();
    updateRolesInput();
}

function renderRoles() {
    const container = document.getElementById('rolesContainer');
    
    if (roles.length === 0) {
        container.innerHTML = '';
        return;
    }
    
    container.innerHTML = '';
    roles.forEach(role => {
        const chip = document.createElement('div');
        chip.className = 'role-chip';
        chip.innerHTML = `
            <span class="material-icons-round">work</span>
            <span>${escapeHtml(role)}</span>
            <button type="button" class="role-remove" onclick="removeRole('${escapeHtml(role)}')">
                <span class="material-icons-round">close</span>
            </button>
        `;
        container.appendChild(chip);
    });
}

function updateRolesInput() {
    const input = document.getElementById('rolesInput');
    input.value = JSON.stringify(roles);
}

// =======================
// FORM SUBMISSION
// =======================

document.getElementById('projectForm').addEventListener('submit', (e) => {
    // Update hidden inputs before submission
    updateCoFoundersInput();
    updateRolesInput();
});

// =======================
// UTILITY FUNCTIONS
// =======================

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Close modals on outside click
window.addEventListener('click', (e) => {
    const membersModal = document.getElementById('addMembersModal');
    const roleModal = document.getElementById('addRoleModal');
    
    if (e.target === membersModal) {
        closeAddMembersModal();
    }
    if (e.target === roleModal) {
        closeAddRoleModal();
    }
});

// Close modals on ESC key
window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeAddMembersModal();
        closeAddRoleModal();
    }
});