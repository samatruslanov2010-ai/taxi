<?php
session_start();

$isDriver = false;

if(isset($_SESSION["driver"])){
    $isDriver = true;
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Такси Сервис</title>
    <link rel="stylesheet" href="taxi1.css">
</head>

<body>
    <header class="header">
        <div class="container header-container">
            <div class="header-titles">
                <h1 class="logo">🚖 TaxiHub</h1>
                <p class="tagline">Удобный поиск и заказ такси</p>
            </div>
            <div class="header-actions">

<?php if(!isset($_SESSION["driver"])) { ?>

    <a href="register.php" class="header-register-btn">
        Регистрация
    </a>

<?php } ?>

    <button id="profileBtn" class="profile-btn">

<?php
if(isset($_SESSION["first_name"])){
    echo strtoupper(substr($_SESSION["first_name"], 0, 1));
}else{
    echo "👤";
}
?>

</button>

</div>
        </div>
    </header>

    <div class="role-switcher">
        <div class="container">
            <div class="role-tabs">
    <button class="role-btn active" data-role="client">
        Пассажир
    </button>

    <button class="role-btn" data-role="driver">
        Шофер
    </button>

    <?php if ($isDriver) { ?>
    <button class="role-btn" data-role="myads">
        Мои объявления
    </button>
    <?php } ?>
</div>
        </div>
    </div>

    <section class="client-section" id="clientSection">
        <div class="container">
            <h2 class="section-title">🔍 Заказ такси</h2>

            <div class="filters-grid">
                <div class="filter-group">
                    <label for="clientFrom">Откуда</label>
                    <input type="text" id="clientFrom" list="regions" placeholder="Выберите область" class="filter-input">
                </div>

                <div class="filter-group">
                    <label for="clientTo">Куда</label>
                   <input type="text" id="clientTo" list="regions" placeholder="Выберите область" class="filter-input">
                </div>

                <div class="filter-group">
                    <label for="clientDate">Дата выезда</label>
                    <input type="datetime-local" id="clientDate" class="filter-input">
                    <div style="font-size:0.85rem; color:#555; margin-top:6px;">
                        Будут показаны варианты, ближайшие к указанному времени — примерно в пределах 6 часов.
                    </div>
                </div>

                <div class="filter-group">
                    <label for="clientPassengers">Сколько человек</label>
                    <select id="clientPassengers" class="filter-input">
                        <option value="1">1 человек</option>
                        <option value="2" selected>2 человека</option>
                        <option value="3">3 человека</option>
                        <option value="4">4 человека</option>
                        <option value="5+">5 и более</option>
                    </select>
                </div>
            </div>

            <button class="search-btn" id="clientSearchBtn">🔍 Найти такси</button>
        </div>
    </section>

    <section class="driver-section" id="driverSection" style="display: none;">
        <div class="container">
            <h2 class="section-title">📝 Предложение маршрута</h2>

            <div class="filters-grid">
                <div class="filter-group">
                    <label for="driverFrom">Откуда едешь</label>
                    <input type="text" id="driverFrom" list="regions" placeholder="Выберите область" class="filter-input">
                </div>

                <div class="filter-group">
                    <label for="driverTo">Куда едешь</label>
                    <input type="text" id="driverTo" list="regions" placeholder="Выберите область" class="filter-input">
                </div>

                <div class="filter-group">
                    <label for="driverDate">Дата выезда</label>
                    <input type="datetime-local" id="driverDate" class="filter-input">
                </div>

                <div class="filter-group">
                    <label for="driverCarModel">Марка и модель авто</label>
                    <input type="text" id="driverCarModel" placeholder="Например: Toyota Camry" class="filter-input">
                </div>

                <div class="filter-group filter-group--wide">
                    <label for="driverImage">Фото авто</label>
                    <input type="file" id="driverImage" accept="image/*" class="filter-input">
                    <div class="driver-image-preview" id="driverImagePreview"></div>
                </div>

                <div class="filter-group filter-group--wide">
                    <label for="driverFaceImage">Фото водителя</label>
                    <input type="file" id="driverFaceImage" accept="image/*" class="filter-input">
                    <div class="driver-image-preview compact-preview" id="driverFacePreview">
                        </div>
                </div>

                <div class="filter-group">
                    <label for="driverPrice">Стоимость</label>
                    <input type="number" id="driverPrice" placeholder="500" class="filter-input" min="0">
                </div>

                <div class="filter-group">
                    <label for="driverMaxPassengers">Сколько места есть</label>
                    <select id="driverMaxPassengers" class="filter-input">
                        <option value="1">1</option>
                        <option value="2" selected>2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="driverPhone">Телефон</label>
                    <input type="tel" id="driverPhone" placeholder="+7 900 123-45-67" class="filter-input">
                </div>
            </div>

            <button class="search-btn" id="driverSubmitBtn">✅ Опубликовать маршрут</button>
        </div>
    </section>

    <section
    class="results-section"
    id="myAdsSection"
    style="display:none;"
>
    <div class="container">
        <h2 class="section-title">
            📋 Мои объявления
        </h2>

        <div class="cars-grid" id="myAdsGrid"></div>
    </div>
</section>

    <section class="results-section" style="display: none;">
        <div class="container">
            <h2 class="section-title">Доступные варианты</h2>

            <div class="cars-grid" id="carsGrid">
                </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 TaxiHub. Все права защищены.</p>
        </div>
    </footer>

<div id="profileModal" class="profile-modal">
    <div class="profile-box">

        <span id="closeProfile" class="close-profile">×</span>

        <h2>Аккаунт</h2>

        <?php if(isset($_SESSION["driver"])) { ?>

            <p>
                Вы вошли как
            </p>

            <h3>
                <?php
                echo $_SESSION["first_name"] . " " . $_SESSION["last_name"];
                ?>
            </h3>

            <br>

            <a href="account.php" class="header-register-btn">
                Управление аккаунтом
            </a>

            <br><br>

            <a href="logout.php">
                Выйти из аккаунта
            </a>

        <?php } else { ?>

            <p>У вас пока нет аккаунта.</p>

            <br>

            <a href="register.php" class="header-register-btn">
                Регистрация
            </a>

            <br><br>

            <a href="login.php">
                Уже есть аккаунт? Войти
            </a>

        <?php } ?>

    </div>
</div>

   <script>
let isDriver = <?php echo $isDriver ? "true" : "false"; ?>;
</script>

<script>
let currentDriver =
"<?php
echo isset($_SESSION['first_name'])
? $_SESSION['first_name']." ".$_SESSION['last_name']
: "Водитель";
?>";
</script>

<script src="taxi1.js"></script>

<datalist id="regions">
    <option value="Баткенская область">
    <option value="Джалал-Абадская область">
    <option value="Иссык-Кульская область">
    <option value="Нарынская область">
    <option value="Ошская область">
    <option value="Таласская область">
    <option value="Чуйская область">
</datalist>

<div id="cardModal" class="card-modal">
    <div class="card-modal-box">

        <span id="closeCardModal" class="card-modal-close">
            ×
        </span>

        <div id="cardModalContent"></div>

    </div>
</div>

</body>

</html>