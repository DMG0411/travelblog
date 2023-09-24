function showEditForm(button) {
    const card = button.closest('.card');

    if (card) {
        const editForm = card.querySelector('.edit-form');
        const descriptionInput = card.querySelector('.edit-description');
        const originalDescription = card.querySelector('p');

        if (editForm && descriptionInput && originalDescription) {
            button.style.display = 'none';

            editForm.style.display = 'block';
            descriptionInput.value = originalDescription.textContent;
        }
    }
}

function saveEdit(button) {
    console.log("Am intrat");
    const card = button.parentElement.parentElement;
    const editForm = card.querySelector('.edit-form');
    const description = card.querySelector('.edit-description').value;

    const postId = button.getAttribute('data-post-id');
    const data = new FormData();
    data.append('description', description);
    data.append('postId', postId);

    console.log(postId);

    fetch('update_description.php', {
        method: 'POST',
        body: data,
    })
        .then(response => response.text())
        .then(result => {
            if (result === 'error') {
                alert('Error while trying to edit.');
            } else {
                alert("Succefully edited");
                window.location.reload();
            }
        });
}

function deletePost(button) {
    const postId = button.getAttribute('data-post-id');

    const confirmDelete = confirm('Are you sure you want to delete this post?');

    if (confirmDelete) {
        const formData = new FormData();
        formData.append('postId', postId);
    
        fetch('delete_post.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text())
            .then(result => {
                if (result.trim() === 'error') {
                    alert('Error while trying to delete.');
                } else {
                    location.reload();
                }
            });
    }
}


function searchKeyword() {
    const keyword = document.getElementById('searchInput').value.trim();
    const postsContainer = document.getElementById('postsContainer');

    // Faceți o cerere de tip GET către get.php pentru a obține datele din PHP
    fetch('get.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Invalid HTTP response');
            }
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('The response is not a JSON');
            }
            return response.json();
        })
        .then(data => {
            // Curăță containerul
            postsContainer.innerHTML = "";

            // Filtrarea datelor în funcție de cuvântul cheie
            const filteredData = data.filter(item => item.description.toLowerCase().includes(keyword));

            // Afișarea datelor filtrate
            filteredData.forEach(item => {
                const card = document.createElement('div');
                card.classList.add('card');
                card.innerHTML = `
                    <img src="${item.photo}" >
                    <p>${item.description}</p>
                    <div class="btn-container">
                        <button class="btn-edit" onclick="showEditForm(this)">Edit</button>
                        <div class="edit-form" style="display: none;">
                            <input type="text" class="edit-description" name="edit_description" value="${item.description}">
                            <button class="btn-done" onclick="saveEdit(this)" data-post-id="${item.id}">Done</button>
                        </div>
                        <button class="btn-delete" onclick="deletePost(this)" data-post-id="${item.id}">Delete</button>
                    </div>
                    <br>
                `;
                postsContainer.appendChild(card);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

