let currentFilter = 'today';

const titles = {
    today: 'Today',
    week: 'This Week',
    month: 'This Month',
    year: 'This Year'
};

document.addEventListener('DOMContentLoaded', () => {
    loadTasks(currentFilter);

    // Tab click handling
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelector('.tab.active').classList.remove('active');
            tab.classList.add('active');
            currentFilter = tab.dataset.filter;
            document.getElementById('pageTitle').textContent = titles[currentFilter];
            loadTasks(currentFilter);
        });
    });

    // Add new task
    document.getElementById('taskForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const taskInput = document.getElementById('taskInput');
        const taskText = taskInput.value.trim();
        if (taskText === '') return;

        const formData = new FormData();
        formData.append('task', taskText);

        fetch('add_task.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    taskInput.value = '';
                    loadTasks(currentFilter);
                } else {
                    alert(data.message);
                }
            })
            .catch(err => console.error('Error:', err));
    });
});

// Fetch and render tasks for the selected period
function loadTasks(filter) {
    fetch('get_tasks.php?filter=' + filter)
        .then(res => res.json())
        .then(data => {
            renderList(data.tasks);
            renderGrid(data.tasks);
            document.getElementById('summaryText').textContent =
                `${data.completed} / ${data.total} done`;
        })
        .catch(err => console.error('Error:', err));
}

// Render the diary-line task list on the right
function renderList(tasks) {
    const list = document.getElementById('taskList');
    list.innerHTML = '';

    if (tasks.length === 0) {
        list.innerHTML = '<li class="empty-msg">No tasks yet. Write one above! ✎</li>';
        return;
    }

    tasks.forEach(t => list.appendChild(buildTaskItem(t)));
}

function buildTaskItem(t) {
    const li = document.createElement('li');
    li.className = 'task-item' + (t.status === 'completed' ? ' completed' : '');
    li.dataset.id = t.id;
    li.innerHTML = `
        <span class="checkbox" onclick="toggleStatus(${t.id})">
            <svg class="check-icon" viewBox="0 0 24 24">
                <polyline points="4 12 9 17 20 6"></polyline>
            </svg>
        </span>
        <span class="task-text" data-id="${t.id}">${escapeHtml(t.task)}</span>
        <button class="edit-btn" onclick="editTask(${t.id})">✎</button>
        <button class="delete-btn" onclick="deleteTask(${t.id})">✕</button>
    `;
    return li;
}

// Render the progress checkbox-grid on the sidebar
function renderGrid(tasks) {
    const grid = document.getElementById('checkGrid');
    grid.innerHTML = '';

    tasks.forEach(t => {
        const box = document.createElement('div');
        box.className = 'grid-box' + (t.status === 'completed' ? ' done' : '');
        grid.appendChild(box);
    });
}

// Toggle complete/pending
function toggleStatus(id) {
    const formData = new FormData();
    formData.append('id', id);

    fetch('update_status.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) loadTasks(currentFilter);
        })
        .catch(err => console.error('Error:', err));
}

// Delete a task
function deleteTask(id) {
    if (!confirm('Delete this task?')) return;

    const formData = new FormData();
    formData.append('id', id);

    fetch('delete_task.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) loadTasks(currentFilter);
        })
        .catch(err => console.error('Error:', err));
}

// Edit / maintain an existing task's text
function editTask(id) {
    const span = document.querySelector(`.task-text[data-id="${id}"]`);
    if (!span) return;

    const currentText = span.textContent.trim();
    const input = document.createElement('input');
    input.type = 'text';
    input.className = 'edit-input';
    input.value = currentText;
    span.replaceWith(input);
    input.focus();
    input.select();

    const save = () => {
        const newText = input.value.trim();
        if (newText && newText !== currentText) {
            const formData = new FormData();
            formData.append('id', id);
            formData.append('task', newText);

            fetch('edit_task.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(() => loadTasks(currentFilter))
                .catch(err => console.error('Error:', err));
        } else {
            loadTasks(currentFilter);
        }
    };

    input.addEventListener('blur', save);
    input.addEventListener('keydown', e => {
        if (e.key === 'Enter') input.blur();
    });
}

// Prevent HTML injection when rendering task text from JSON
function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}
