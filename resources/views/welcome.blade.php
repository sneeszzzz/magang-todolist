    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link rel="stylesheet" href="{{ asset('new-assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('new-assets/css/style.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    </head>

    <body>
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



    <script>
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.querySelector('.toggle-btn');

        toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('closed');
        });
    </script>
                    
                

    </body>


    </html>
