// ============================================
// 1. СТИЛИ
// ============================================
const style = document.createElement('style');
style.textContent = `
    #carsGrid {
        display: grid;
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 20px !important;
        width: 100% !important;
        box-sizing: border-box;
    }
    .taxi-card {
        display: flex;
        flex-direction: column;
        background: #fff;
        border: 2px solid #000;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 4px 4px 0px #000;
        width: 100% !important;
        min-width: 0;
    }
    .taxi-card-media {
        height: 140px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 2px solid #000;
        font-size: 3rem;
    }
    .taxi-card-media img { width: 100%; height: 100%; object-fit: cover; }
    .taxi-card-content { padding: 12px; display: flex; flex-direction: column; gap: 8px; flex-grow: 1; }
    .driver-avatar-mini { width: 32px; height: 32px; border-radius: 50%; overflow: hidden; border: 1.5px solid #000; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
    .driver-avatar-mini img { width: 100%; height: 100%; object-fit: cover; }
    
    /* Always keep 4 columns regardless of viewport width */
`;
document.head.appendChild(style);

// ============================================
// 2. ФУНКЦИИ
// ============================================
const roleBtns = document.querySelectorAll('.role-btn');
const clientSection = document.getElementById('clientSection');
const driverSection = document.getElementById('driverSection');
const clientSearchBtn = document.getElementById('clientSearchBtn');
const driverSubmitBtn = document.getElementById('driverSubmitBtn');
const carsGrid = document.getElementById('carsGrid');
const resultsSection = document.querySelector('.results-section');
const driverImageInput = document.getElementById('driverImage');
const driverImagePreview = document.getElementById('driverImagePreview');
const driverFaceImageInput = document.getElementById('driverFaceImage');
const driverFacePreview = document.getElementById('driverFacePreview');

let postedRoutes = [];

roleBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        roleBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        switchRole(btn.dataset.role);
    });
});

function switchRole(role) {
    if (role === 'client') {
        clientSection.style.display = 'block';
        driverSection.style.display = 'none';
        if (resultsSection) resultsSection.style.display = (postedRoutes.length > 0) ? 'block' : 'none';
    } else {
        clientSection.style.setProperty('display', 'none', 'important');
        driverSection.style.display = 'block';
        if (resultsSection) resultsSection.style.setProperty('display', 'none', 'important');
    }
}

function createTaxiCard(taxi) {
    const card = document.createElement('div');
    card.className = 'taxi-card';

    // Исправлены теги без лишних пробелов
    const mediaContent = taxi.image.includes('<img') ? taxi.image : `<span>${taxi.image}</span>`;
    const avatarContent = taxi.faceImage || '👤';

    card.innerHTML = `
        <div class="taxi-card-media">${mediaContent}</div>
        <div class="taxi-card-content">
            <div style="display:flex; justify-content:space-between;">
                <span style="font-weight:bold; font-size:0.8rem; background:#eee; padding:2px 6px; border-radius:4px;">${taxi.type}</span>
                <span>★ ${taxi.rating}</span>
            </div>
            <h3 style="margin:4px 0; font-size:1.1rem;">${taxi.name}</h3>
            <div class="driver-row" style="display:flex; align-items:center; gap:8px;">
                <div class="driver-avatar-mini">${avatarContent}</div>
                <div style="font-size:0.85rem;"><strong>${taxi.driver}</strong></div>
            </div>
            <div style="font-size:0.85rem;">🚗 ${taxi.car}</div>
            <div style="margin-top:auto; padding-top:10px; border-top:1px dashed #ccc;">
                <div style="font-size:1.2rem; font-weight:900;">${taxi.price} ₽</div>
                <button onclick="alert('Забронировано')" style="width:100%; margin-top:5px; cursor:pointer;">Заказать</button>
            </div>
        </div>
    `;
    return card;
}

function renderRoutes(routes) {
    carsGrid.innerHTML = '';
    routes.forEach(taxi => carsGrid.appendChild(createTaxiCard(taxi)));
}

// Загрузка фото
[driverImageInput, driverFaceInput = driverFaceImageInput].forEach(input => {
    input?.addEventListener('change', (e) => {
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

    if (!from || !to || !price) return alert('Заполните поля!');

    const newRoute = {
        name: `${from} → ${to}`,
        type: 'Маршрут',
        driver: 'Водитель',
        car: document.getElementById('driverCarModel').value,
        rating: 5.0,
        price: price,
        image: driverImagePreview.innerHTML || '🚗',
        faceImage: driverFacePreview.innerHTML || '👤'
    };

    postedRoutes.unshift(newRoute);
    alert('Опубликовано!');
    switchRole('client');
    renderRoutes(postedRoutes);
});