// ============================================
// 1. СТИЛИ
// ============================================
const style = document.createElement('style');
style.textContent = `
#carsGrid, #myAdsGrid {
    display: grid;
    grid-template-columns: repeat(3, minmax(280px, 320px));
    gap: 20px;
    justify-content: center;
    width: min(100%, 1200px);
    margin: 0 auto;
    box-sizing: border-box;
}

@media (max-width:1200px){
    #carsGrid, #myAdsGrid {
        grid-template-columns: repeat(2, minmax(260px, 1fr));
    }
}

@media (max-width:900px){
    #carsGrid, #myAdsGrid {
        grid-template-columns: 1fr;
        gap: 16px;
        width: 100%;
    }
}

@media (max-width:550px){
    #carsGrid, #myAdsGrid {
        grid-template-columns: 1fr;
        gap: 14px;
    }
}
.taxi-card{
    display:flex;
    flex-direction:column;
    background:#fff;
    border:2px solid #000;
    border-radius:12px;
    overflow:hidden;
    box-shadow:4px 4px 0px #000;

    width:100%;
    min-width:0;
    max-width:320px;

    cursor:pointer;
    margin:auto;
}
    .taxi-card-media {
        height: 120px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 2px solid #000;
        font-size: 3rem;
    }
    .taxi-card-media img { width: 100%; height: 100%; object-fit: cover; }
    .taxi-card-content { padding: 14px; display: flex; flex-direction: column; gap: 10px; flex-grow: 1; }
    .driver-avatar-mini { width: 28px; height: 28px; border-radius: 50%; overflow: hidden; border: 1.5px solid #000; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
    .driver-avatar-mini img { width: 100%; height: 100%; object-fit: cover; }
    .route-path { display: grid; gap: 10px; }
    .route-field { display: flex; flex-direction: column; padding: 10px; background: #f5f5f5; border-radius: 10px; gap: 4px; }
    .route-label { font-size: 0.72rem; color: #666; text-transform: uppercase; letter-spacing: 0.08em; font-weight: 600; }
    .route-value { font-size: 1rem; font-weight: 700; color: #111; }
    .route-meta { display: flex; flex-wrap: wrap; gap: 8px; justify-content: space-between; font-size: 0.85rem; color: #555; }
    .route-meta span { flex: 1 1 120px; min-width: 120px; }
    .modal-route-info { display: grid; gap: 10px; margin: 16px 0; }
    .modal-route-item { display: flex; flex-direction: column; padding: 12px; background: #f8f8f8; border: 1px solid #e0e0e0; border-radius: 12px; }
    .modal-route-item b { margin-bottom: 6px; color: #333; }
    .modal-route-item span { color: #111; }
    .modal-car-image { width: 100%; height: auto; max-height: 240px; object-fit: cover; border-radius: 12px; }
    .card-modal-box { width: min(600px, calc(100% - 24px)); max-width: 100%; }
    @media (max-width: 650px) {
        .taxi-card-content { padding: 12px; gap: 8px; }
        .taxi-card-media { height: 100px; font-size: 2.6rem; }
        .route-field { padding: 8px; }
        .route-label { font-size: 0.68rem; }
        .route-value { font-size: 0.95rem; }
        .route-meta { gap: 6px; }
        .modal-route-info { gap: 8px; }
    }
    @media (max-width: 450px) {
        .taxi-card { border-width: 1.5px; }
        .taxi-card-content { padding: 10px; }
        .modal-route-item { padding: 10px; }
    }
    
    /* Always keep 4 columns regardless of viewport width */
`;
document.head.appendChild(style);

// ============================================
// 2. ФУНКЦИИ
// ============================================
const roleBtns = document.querySelectorAll('.role-btn');
const clientSection = document.getElementById('clientSection');
const driverSection = document.getElementById('driverSection');
const myAdsSection = document.getElementById("myAdsSection");
const myAdsGrid = document.getElementById("myAdsGrid");
const clientSearchBtn = document.getElementById('clientSearchBtn');
const driverSubmitBtn = document.getElementById('driverSubmitBtn');
const carsGrid = document.getElementById('carsGrid');
const resultsSection = document.querySelector('.results-section');
const driverImageInput = document.getElementById('driverImage');
const driverImagePreview = document.getElementById('driverImagePreview');
const driverFaceImageInput = document.getElementById('driverFaceImage');
const driverFacePreview = document.getElementById('driverFacePreview');
driverImagePreview.innerHTML = "Выберите файл";
driverFacePreview.innerHTML = "Выберите файл";

driverImagePreview.onclick = function () {
    driverImageInput.click();
};

driverFacePreview.onclick = function () {
    driverFaceImageInput.click();
};

let postedRoutes = [];

roleBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        roleBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        switchRole(btn.dataset.role);
    });
});

// Если водитель не зарегистрирован
function switchRole(role) {

    clientSection.style.display = "none";
    driverSection.style.display = "none";
    resultsSection.style.display = "none";
    myAdsSection.style.display = "none";

    if (role === "client") {

        clientSection.style.display = "block";

        if (postedRoutes.length > 0) {
            resultsSection.style.display = "block";
        }

    }
    else if (role === "driver") {

        if (!isDriver) {

            driverSection.innerHTML = `
            <div style="text-align:center;padding:50px;">
                <h2>Для доступа к разделу водителя нужно зарегистрироваться</h2>
                <br>
                <a href="register.php">
                    <button class="search-btn">
                        Регистрация
                    </button>
                </a>
            </div>
            `;
        }

        driverSection.style.display = "block";
    }
    else if (role === "myads") {

        myAdsSection.style.display = "block";
        renderMyAds();

    }
}

function setActiveRole(role) {
    roleBtns.forEach(btn => btn.classList.toggle('active', btn.dataset.role === role));
}

function formatRouteDate(dateString) {
    if (!dateString) return 'Дата не указана';
    const date = new Date(dateString);
    return date.toLocaleString('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function createTaxiCard(taxi) {
    const card = document.createElement('div');
    card.className = 'taxi-card';

    const mediaContent = taxi.image.includes('<img')
        ? taxi.image
        : `<span>${taxi.image}</span>`;

    const avatarContent = taxi.faceImage || '👤';

    card.innerHTML = `
        <div class="taxi-card-media">${mediaContent}</div>
        <div class="taxi-card-content">
            <div class="route-path">
                <div class="route-field">
                    <span class="route-label">От</span>
                    <span class="route-value">${taxi.from || 'Не указано'}</span>
                </div>
                <div class="route-field">
                    <span class="route-label">В</span>
                    <span class="route-value">${taxi.to || 'Не указано'}</span>
                </div>
            </div>

            <div class="route-meta">
                <span>🕐 ${taxi.date ? taxi.date.replace('T', ' ') : 'Дата не указана'}</span>
            </div>
            <div class="route-meta">
                <span>👥 ${taxi.maxPassengers || 1} м.</span>
                <span>� ${taxi.phone || 'Не указан'}</span>
            </div>

            <div style="display:flex; align-items:center; gap:8px; margin-top:auto; padding-bottom:8px; border-bottom:1px solid #ddd;">
                <div class="driver-avatar-mini">
                    ${avatarContent}
                </div>
                <div style="font-size:0.8rem; flex: 1;">
                    <strong style="font-size:0.85rem;">${taxi.driver}</strong>
                </div>
            </div>

            <div style="padding-top:10px;">
                <div style="font-size:1.45rem; font-weight:900; color:#000;">
                    ${taxi.price} ₽
                </div>
                <button
    onclick="alert('Забронировано')"
    style="width:100%; margin-top:8px; padding:8px; cursor:pointer; background:#000; color:#fff; border:none; border-radius:8px; font-weight:600; font-size:0.9rem;"
>
    Заказать
</button>

${taxi.driver === currentDriver ? `
<button
class="delete-ad-btn"
style="
width:100%;
margin-top:8px;
padding:8px;
background:#d32f2f;
color:white;
border:none;
border-radius:8px;
cursor:pointer;
"
>
Удалить
</button>
` : ""}
            </div>
        </div>
    `;

    const deleteBtn = card.querySelector(".delete-ad-btn");

    if (deleteBtn) {

        deleteBtn.onclick = function (e) {

            e.stopPropagation();

            postedRoutes = postedRoutes.filter(
                item => item !== taxi
            );

            renderRoutes(postedRoutes);
            renderMyAds();

        };

    }

    card.onclick = function () {

        const modal = document.getElementById("cardModal");
        const content = document.getElementById("cardModalContent");

        content.innerHTML = `

        ${taxi.image.includes("<img")
                ? taxi.image.replace("<img", "<img class='modal-car-image'")
                : ""
            }

        <div style="display:flex; align-items:center; gap:16px; margin:16px 0;">
            <div style="width:72px; height:72px; border-radius:50%; overflow:hidden; background:#f3f4f6; display:flex; align-items:center; justify-content:center;">
                ${taxi.faceImage && taxi.faceImage.includes('<img')
                ? taxi.faceImage.replace('<img', '<img style="width:100%; height:100%; object-fit:cover;"')
                : '<span style="font-size:2rem;">👤</span>'
            }
            </div>
            <div style="font-size:0.95rem;">
                <b>Водитель</b><br>
                ${taxi.driver}
            </div>
        </div>

        <div class="modal-price">
            ${taxi.price} ₽
        </div>

        <div style="padding: 12px 0; border-bottom: 1px solid #ddd;">
            <b>Контакт водителя</b>
            <div style="color: #111; margin-top: 6px; font-size: 0.95rem;">📞 ${taxi.phone || 'Не указан'}</div>
        </div>

        <div class="modal-route-info">
            <div class="modal-route-item">
                <b>От</b>
                <span>${taxi.from || 'Не указано'}</span>
            </div>
            <div class="modal-route-item">
                <b>В</b>
                <span>${taxi.to || 'Не указано'}</span>
            </div>
            <div style="padding: 12px 0; border: none; background: none;">
                <b>Автомобиль</b>
                <div style="color: #111; margin-top: 6px;">${taxi.car}</div>
            </div>
            <div style="padding: 12px 0; border: none; background: none;">
                <b>Дата выезда</b>
                <div style="color: #111; margin-top: 6px;">${taxi.date ? taxi.date.replace("T", " ") : "Не указана"}</div>
            </div>
            <div style="padding: 12px 0; border: none; background: none;">
                <b>Рейтинг</b>
                <div style="color: #111; margin-top: 6px;">★ ${taxi.rating}</div>
            </div>
        </div>

        <button class="modal-order-btn">
            Заказать поездку
        </button>

    `;

        modal.style.display = "flex";
    };

    return card;

}
function renderRoutes(routes) {
    carsGrid.innerHTML = '';

    if (!routes.length) {
        const emptyMessage = document.createElement('div');
        emptyMessage.style.padding = '24px';
        emptyMessage.style.fontSize = '1rem';
        emptyMessage.style.color = '#333';
        emptyMessage.textContent = 'По вашему запросу подходящих маршрутов не найдено.';
        carsGrid.appendChild(emptyMessage);
        return;
    }

    routes.forEach(taxi => carsGrid.appendChild(createTaxiCard(taxi)));
}

function renderMyAds() {

    myAdsGrid.innerHTML = "";

    const myRoutes = postedRoutes.filter(
        route => route.driver === currentDriver
    );

    if (myRoutes.length === 0) {

        myAdsGrid.innerHTML = `
        <div style="
            padding:30px;
            text-align:center;
            font-size:18px;
        ">
            У вас пока нет объявлений.
        </div>
        `;

        return;
    }

    myRoutes.forEach(route => {
        myAdsGrid.appendChild(createTaxiCard(route));
    });

}

function parsePassengerCount(value) {
    return value === '5+' ? 5 : Number(value) || 1;
}

clientSearchBtn?.addEventListener('click', () => {
    const fromValue = document.getElementById('clientFrom').value.trim().toLowerCase();
    const toValue = document.getElementById('clientTo').value.trim().toLowerCase();
    const dateValue = document.getElementById('clientDate').value;
    const passengersValue = document.getElementById('clientPassengers').value;

    const searchDate = dateValue ? new Date(dateValue) : null;
    const requestedPassengers = parsePassengerCount(passengersValue);

    const filtered = postedRoutes.filter(route => {
        if (fromValue && !route.from.toLowerCase().includes(fromValue)) {
            return false;
        }
        if (toValue && !route.to.toLowerCase().includes(toValue)) {
            return false;
        }
        if (requestedPassengers && route.maxPassengers < requestedPassengers) {
            return false;
        }
        if (searchDate) {
            if (!route.date) {
                return false;
            }
            const routeDate = new Date(route.date);
            const diff = Math.abs(routeDate.getTime() - searchDate.getTime());
            const sixHours = 6 * 60 * 60 * 1000;
            if (diff > sixHours) {
                return false;
            }
        }
        return true;
    });

    if (searchDate) {
        filtered.sort((a, b) => {
            const aDiff = Math.abs(new Date(a.date).getTime() - searchDate.getTime());
            const bDiff = Math.abs(new Date(b.date).getTime() - searchDate.getTime());
            return aDiff - bDiff;
        });
    }

    resultsSection.style.display = filtered.length ? 'block' : 'block';
    renderRoutes(filtered);
});

// Загрузка фото
[driverImageInput, driverFaceImageInput].filter(Boolean).forEach(input => {
    input.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (event) => {
            const container = (e.target.id === 'driverImage') ? driverImagePreview : driverFacePreview;
            container.innerHTML = `<img src="${event.target.result}">`;
        };
        reader.readAsDataURL(file);
    });
});

// Публикация
driverSubmitBtn?.addEventListener('click', () => {
    const from = document.getElementById('driverFrom').value;
    const to = document.getElementById('driverTo').value;
    const price = document.getElementById('driverPrice').value;
    const date = document.getElementById('driverDate').value;

    if (!from || !to || !price) return alert('Заполните поля!');

    const newRoute = {
        name: `${from} → ${to}`,
        type: 'Маршрут',
        from: from,
        to: to,
        driver: currentDriver,
        phone: document.getElementById('driverPhone').value || 'Не указан',
        car: document.getElementById('driverCarModel').value,
        rating: 5.0,
        price: price,
        date: date,
        maxPassengers: Number(document.getElementById('driverMaxPassengers').value) || 1,
        image: driverImagePreview.querySelector('img') ? driverImagePreview.innerHTML : '🚗',
        faceImage: driverFacePreview.querySelector('img') ? driverFacePreview.innerHTML : '👤'
    };

    postedRoutes.unshift(newRoute);
    renderMyAds();
    alert('Опубликовано!');
    setActiveRole('client');
    switchRole('client');
    renderRoutes(postedRoutes);
});

const profileBtn = document.getElementById("profileBtn");
const profileModal = document.getElementById("profileModal");
const closeProfile = document.getElementById("closeProfile");

if (profileBtn) {
    profileBtn.onclick = function () {
        profileModal.style.display = "flex";
    }
}

if (closeProfile) {
    closeProfile.onclick = function () {
        profileModal.style.display = "none";
    }
}

window.addEventListener("DOMContentLoaded", function () {

    const cardModal = document.getElementById("cardModal");
    const closeCardModal = document.getElementById("closeCardModal");

    if (closeCardModal) {
        closeCardModal.addEventListener("click", function () {
            cardModal.style.display = "none";
        });
    }

    window.addEventListener("click", function (e) {
        if (e.target === cardModal) {
            cardModal.style.display = "none";
        }
    });

});

