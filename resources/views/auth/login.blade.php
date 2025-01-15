            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Login/Sign Up</title>
                <style>
                    body {
                        margin: 0;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                        background: url('{{ asset("new-assets/images/bg.png") }}') no-repeat center center/cover;
                    }

                    /* Preloader Styles */
                    #preloader {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: url('{{ asset("new-assets/images/bg.png") }}') no-repeat center center/cover; /* Background sama */
                        z-index: 1000;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }

                    #preloader img {
                        width: 150px; /* Ukuran logo diperbesar */
                    }

                    /* Main Content */
                    .form-container {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        width: 100%;
                        max-width: 500px;
                        position: relative;
                        z-index: 10;
                        opacity: 0;
                        transition: opacity 0.3s ease;
                    }

                    .form {
                        display: flex;
                        flex-direction: column;
                        gap: 15px;
                        background-color: rgba(255, 255, 255, 0.9);
                        padding: 40px;
                        width: 100%;
                        border-radius: 20px;
                        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2);
                    }

                    ::placeholder {
                        font-family: inherit;
                    }

                    .form button {
                        align-self: flex-end;
                    }

                    .flex-column > label {
                        color: #151717;
                        font-weight: 600;
                    }

                    .inputForm {
                        border: 1.5px solid #ecedec;
                        border-radius: 10px;
                        height: 50px;
                        display: flex;
                        align-items: center;
                        padding-left: 10px;
                        transition: 0.2s ease-in-out;
                    }

                    .input {
                        margin-left: 10px;
                        border-radius: 10px;
                        border: none;
                        width: 85%;
                        height: 100%;
                    }

                    .input:focus {
                        outline: none;
                    }

                    .inputForm:focus-within {
                        border: 1.5px solid #2d79f3;
                    }

                    .button-submit {
                        margin: 20px 0 10px 0;
                        background-color: #151717;
                        border: none;
                        color: white;
                        font-size: 15px;
                        font-weight: 500;
                        border-radius: 10px;
                        height: 50px;
                        width: 100%;
                        cursor: pointer;
                    }

                    .button-submit:hover {
                        background-color: #252727;
                    }
                    /* From Uiverse.io by AbanoubMagdy1 */ 
        .loader {
        --dim: 3rem;
        width: var(--dim);
        height: var(--dim);
        position: relative;
        animation: spin988 2s linear infinite;
        }

        .loader .circle {
            --color: white; 
        --dim: 1.2rem;
        width: var(--dim);
        height: var(--dim);
        background-color: var(--color);
        border-radius: 50%;
        position: absolute;
        }

        .loader .circle:nth-child(1) {
        top: 0;
        left: 0;
        }

        .loader .circle:nth-child(2) {
        top: 0;
        right: 0;
        }

        .loader .circle:nth-child(3) {
        bottom: 0;
        left: 0;
        }

        .loader .circle:nth-child(4) {
        bottom: 0;
        right: 0;
        }

        @keyframes spin988 {
        0% {
            transform: scale(1) rotate(0);
        }

        20%, 25% {
            transform: scale(1.3) rotate(90deg);
        }

        45%, 50% {
            transform: scale(1) rotate(180deg);
        }

        70%, 75% {
            transform: scale(1.3) rotate(270deg);
        }

        95%, 100% {
            transform: scale(1) rotate(360deg);
        }
        }
                </style>
            </head>
            <body>
                <!-- Preloader -->
                <div id="preloader">
                    <img src="{{ asset('new-assets/images/logo1.png') }}" alt="Logo">
                    <div class="loader">
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
            </div>

                </div>

                <!-- Main Content -->
                <div class="form-container">
                    <form class="form" action="{{ route('login') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="flex-column">
                            <label for="email">Email</label>
                        </div>
                        <div class="inputForm">
                            <input type="email" id="email" name="email" class="input" placeholder="Enter your Email" required>
                        </div>
                        <div class="flex-column">
                            <label for="password">Password</label>
                        </div>
                        <div class="inputForm">
                            <input type="password" id="password" name="password" class="input" placeholder="Enter your Password" required>
                        </div>
                        <button type="submit" class="button-submit">Log In</button>
                    </form>
                </div>

                <script>
                // Hide preloader and show form-container after a delay
                window.addEventListener('load', () => {
                    const preloader = document.getElementById('preloader');
                    const formContainer = document.querySelector('.form-container');
                    
                    // Tambahkan delay sebelum menyembunyikan preloader (contoh: 2 detik)
                    setTimeout(() => {
                        preloader.style.display = 'none';
                        formContainer.style.opacity = '1';
                    }, 2000); // 2000 ms = 2 detik
                });
                </script>
            </body>
            </html>
