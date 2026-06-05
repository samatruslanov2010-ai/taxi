<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация — TaxiHub</title>
    <link rel="stylesheet" href="taxi1.css">
    <style>
        /* Дополнительные стили специально для формы аутентификации */
        body {
            background-color: var(--bg-light);
        }
        
        .header-simple {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            padding: 20px 0;
            box-shadow: var(--card-shadow);
            text-align: center;
        }

        .header-simple a {
            color: white;
            text-decoration: none;
        }

        .auth-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 180px);
            padding: 40px 20px;
        }

        .auth-card {
            background: white;
            width: 100%;
            max-width: 420px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
        }

        .auth-title {
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            color: var(--text-primary);
        }

        .auth-form .filter-group {
            margin-bottom: 20px;
        }

        .error-text {
            color: #d93025; /* Красный цвет для ошибки */
            font-size: 13px;
            margin-top: 6px;
            display: none; /* Скрыто по умолчанию */
        }

        .input-error {
            border-color: #d93025 !important;
        }

        .input-error:focus {
            box-shadow: 0 0 0 3px rgba(217, 48, 37, 0.1) !important;
        }

        .auth-footer {
            margin-top: 24px;
            text-align: center;
            font-size: 14px;
            color: var(--text-secondary);
        }

        .auth-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

                .back-btn {
            position: absolute;
            left: 25px;
            top: 22px;
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: opacity 0.2s;
        }

        .back-btn:hover {
            opacity: 0.8;
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Простая шапка с ссылкой на главную -->
<header class="header-simple">
    <div class="container" style="position: relative;">

        <a href="index.php" class="back-btn">
            ← Назад
        </a>

        <a href="index.php">
            <h1 class="logo" style="font-size: 28px; margin: 0;">
                🚖 TaxiHub
            </h1>
        </a>

    </div>
</header>

    <!-- Секция регистрации -->
    <div class="auth-container">
        <div class="auth-card">
            <h2 class="auth-title">Создать аккаунт</h2>

            <form id="registerForm" class="auth-form" action="save_user.php" method="POST">
                
                <div class="filter-group">
                    <label for="regName">Имя</label>
                  <input type="text" id="regName" name="first_name" placeholder="Иван" class="filter-input" required>
                </div>

                <div class="filter-group">
                    <label for="regSurname">Фамилия</label>
                    <input type="text" id="regSurname" name="last_name" placeholder="Иванов" class="filter-input" required>
                </div>

                <div class="filter-group">
                    <label for="regPhone">Номер телефона</label>
                    <input type="tel" id="regPhone" name="phone" placeholder="+996 (___) ___-__-__" class="filter-input" required>
                </div>

                <!-- Первое написание пароля -->
                <div class="filter-group">
                    <label for="regPassword">Пароль</label>
                    <input type="password" id="regPassword" name="password" placeholder="Минимум 6 символов" class="filter-input" required minlength="6">

                <!-- Второе написание пароля (Подтверждение) -->
                <div class="filter-group">
                    <label for="regConfirmPassword">Повторите пароль</label>
                    <input type="password" id="regConfirmPassword" name="confirm_password" placeholder="Введите пароль еще раз" class="filter-input" required>
                    <!-- Блок для вывода ошибки несовпадения паролей -->
                    <div id="passwordError" class="error-text">Пароли не совпадают!</div>
                </div>

                <button type="submit" class="search-btn">Зарегистрироваться</button>
                
            </form>

<div class="auth-footer">
    Уже есть аккаунт? <a href="login.php">Войти</a>
</div>

<script>
    const registerForm = document.getElementById('registerForm');
    const passwordInput = document.getElementById('regPassword');
    const confirmPasswordInput = document.getElementById('regConfirmPassword');
    const passwordError = document.getElementById('passwordError');

    // --- Проверка совпадения паролей при отправке формы ---
    registerForm.addEventListener('submit', function(event) {
        if (passwordInput.value !== confirmPasswordInput.value) {
            event.preventDefault(); // Останавливаем отправку
            passwordError.style.display = 'block';
            confirmPasswordInput.classList.add('input-error');
            passwordInput.classList.add('input-error');
        } else {
            passwordError.style.display = 'none';
            confirmPasswordInput.classList.remove('input-error');
            passwordInput.classList.remove('input-error');
            
            } else {
    passwordError.style.display = 'none';
    confirmPasswordInput.classList.remove('input-error');
    passwordInput.classList.remove('input-error');
}
        });

    // Скрываем ошибку, когда пользователь начинает исправлять пароль
    confirmPasswordInput.addEventListener('input', function() {
        passwordError.style.display = 'none';
        confirmPasswordInput.classList.remove('input-error');
        passwordInput.classList.remove('input-error');
    });
    
    passwordInput.addEventListener('input', function() {
        passwordError.style.display = 'none';
        confirmPasswordInput.classList.remove('input-error');
        passwordInput.classList.remove('input-error');
    });

// --- 1. Блокировка ввода всего, кроме цифр и плюса в начале ---
const phoneInput = document.getElementById('regPhone');
if (phoneInput) {
    phoneInput.addEventListener('input', function() {
        // Заменяем все, что не является цифрой или плюсом
        let value = this.value.replace(/[^\d+]/g, '');
        
        // Если плюс стоит не в начале, удаляем его
        if (value.indexOf('+') > 0) {
            value = value.replace(/\+/g, '');
        }
        
        this.value = value;
    });
}
    // --- 2. Логика работы глазка (показать/скрыть пароль) ---
    const toggleButtons = document.querySelectorAll('.toggle-password');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Предотвращаем случайную отправку формы
            
            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);
            
            // Меняем тип поля, символ глаза оставляем, меняем только прозрачность
            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                this.style.opacity = '0.4'; // Полупрозрачный, когда пароль виден
            } else {
                targetInput.type = 'password';
                this.style.opacity = '1';   // Обычный вид, когда скрыт
            }
        });
    });
</script>
</body>

</html>