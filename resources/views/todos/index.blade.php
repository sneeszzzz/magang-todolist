        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <title>Your Todo Lists</title>

            <!-- CSS -->
            <link rel="stylesheet" href="{{ asset('new-assets/css/bootstrap.min.css') }}">
            <link rel="stylesheet" href="{{ asset('new-assets/css/style.css') }}">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

            <style>
            </style>
        </head>
        <body>
            <!-- Sidebar -->
            <nav class="sidebar">
            <div class="logo">
                <img src="{{ asset('new-assets/images/logo1.png') }}" style="width: 50px; height: 50px;" alt="Logo">
                <span>Dashboard</span>
            </div>
            <ul class="menu">
                <li class="menu-item"><a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="fas fa-th-large"></i><span>Dashboard</span>
                </a></li>
                <li class="menu-item"><a href="{{ route('todos.index') }}" class="nav-link">
                    <i class="far fa-calendar"></i><span>Todo List</span>
                </a></li>
            </ul>
            <ul class="menu logout-menu">
        <li class="logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf <!-- Tambahkan CSRF token untuk keamanan -->
                <button type="submit" class="Btn">
                    <div class="sign">
                        <svg viewBox="0 0 512 512">
                            <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                        </svg>
                    </div>
                    <div class="text">Logout</div>
                </button>
            </form>
        </li>
    </ul>

        </form>

                </li>
            </ul>
        </nav>


            <!-- Main Content -->
            <div class="main-content">
                <div class="container mt-4">
                    <h1>Your Todo Lists 📌</h1>
                    <hr>

                    @if(auth()->user()->role == 'revieweeA')
                    <!-- Add Todo Button and Form -->
                    <div class="mb-4">
                        <button id="show-form-btn" class="btn btn-primary">Add New Todo</button>
                    </div>

                    <div id="todo-form" style="display: none;">
                        <form action="{{ route('todos.store') }}" method="POST" class="mb-4">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <input type="text" name="name" class="form-control" placeholder="New Todo Name" required>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-primary w-50">Submit</button>
                                        <button type="button" id="cancel-btn" class="btn btn-danger w-50 ms-2">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif

                    <!-- Todo Cards -->
                    @foreach ($todos as $todo)
                    <div class="todo-card" data-todo-id="{{ $todo->id }}">
                        <div class="options-menu" onclick="event.stopPropagation();">
                            <button class="dropdown-toggle" onclick="toggleDropdown({{ $todo->id }})">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" id="dropdown-{{ $todo->id }}">
                                @if(auth()->user()->role == 'revieweeA')
                            <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-trash-alt me-2"></i>Delete
                                </button>
                            </form>
                                @endif
                                <button class="dropdown-item" onclick="openTaskPanel({{ $todo->id }})">
                                    <i class="fas fa-tasks me-2"></i>View Tasks
                                </button>
                            </div>
                        </div>

                        <div class="todo-title">{{ $todo->name }}</div>
                        <div class="todo-description">Created by: {{ $todo->user->name }}</div>
                        <div class="progress-info">
                            {{ $todo->tasks->count() }} Tasks / {{ $todo->progress }}%
                        </div>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: {{ $todo->progress }}%"></div>
                        </div>
                    </div>

                    <!-- Task Panel -->
                    <div class="task-panel" id="task-panel-{{ $todo->id }}">
                        <div class="panel-header">
                            <h3>Tasks for {{ $todo->name }}</h3>
                            <div class="close-panel" onclick="closeTaskPanel({{ $todo->id }})">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                        
                        @if(auth()->user()->role == 'revieweeA' || auth()->user()->role == 'revieweeB')
                        <div class="task-form">
                            <form action="{{ route('tasks.store', $todo) }}" method="POST">
                                @csrf
                                <input type="text" name="title" class="form-control" placeholder="New Task Name" required>
                                <input type="number" name="progress" class="form-control" placeholder="Progress (%)" required min="0" max="100">
                                <input type="hidden" name="todo_id" value="{{ $todo->id }}">
                                <button type="submit" class="btn btn-success w-100">Add Task</button>
                            </form>
                        </div>
                        @endif

                        <div class="task-list">
                            <ul class="list-group">
                                @foreach ($todo->tasks->where('parent_id', null) as $task)
                                    @include('partials.subtasks', ['tasks' => [$task]])
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- JavaScript -->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    // Form toggle
                    const showFormBtn = document.getElementById('show-form-btn');
                    const todoForm = document.getElementById('todo-form');
                    const cancelBtn = document.getElementById('cancel-btn');

                    if (showFormBtn && todoForm && cancelBtn) {
                        showFormBtn.addEventListener('click', () => {
                            todoForm.style.display = 'block';
                            showFormBtn.style.display = 'none';
                        });

                        cancelBtn.addEventListener('click', () => {
                            todoForm.style.display = 'none';
                            showFormBtn.style.display = 'block';
                        });
                    }

                    // Close dropdowns when clicking outside
                    document.addEventListener('click', (e) => {
                        const dropdowns = document.querySelectorAll('.dropdown-menu');
                        dropdowns.forEach(dropdown => {
                            if (!e.target.closest('.options-menu')) {
                                dropdown.classList.remove('show');
                            }
                        });
                    });
                });

                // Dropdown toggle
                function toggleDropdown(todoId) {
                    const dropdown = document.getElementById(`dropdown-${todoId}`);
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        if (menu !== dropdown) menu.classList.remove('show');
                    });
                    dropdown.classList.toggle('show');
                }

                // Task panel functions
                function openTaskPanel(todoId) {
                    const panel = document.getElementById(`task-panel-${todoId}`);
                    panel.classList.add('active');
                }

                function closeTaskPanel(todoId) {
                    const panel = document.getElementById(`task-panel-${todoId}`);
                    panel.classList.remove('active');
                }
                function confirmDelete(event) {
            if (!window.confirm("Are you sure you want to delete this todo?")) {
                event.preventDefault(); // Batalkan penghapusan jika pengguna memilih "Cancel"
                return false;
            }
            return true; // Lanjutkan penghapusan jika pengguna memilih "OK"
        }

            </script>

            <script src="{{ asset('new-assets/js/bootstrap.bundle.min.js') }}"></script>
        </body>
        </html>