///resolvi fazer sem o backend pra ficar mais organizado <3

const DEAM_CONTACTS = [
    { name: 'DEAM Rio Branco', city: 'Rio Branco', state: 'AC', phone: '(68) 3221-4799', email: 'deam.sepc@gmail.com', whatsapp: '(68) 99220-1402', instagram: '@deam.ac' },
    { name: 'DEAM - Casa da Mulher Brasileira', city: 'Salvador', state: 'BA', phone: '(71) 3116-7969', email: 'deam.brotas@pcivil.ba.gov.br', whatsapp: '(71) 99691-6586', instagram: '@pcbaoficial' },
    { name: 'DDM Fortaleza (24H - Casa da Mulher Brasileira)', city: 'Fortaleza', state: 'CE', phone: '(85) 3108-2950', email: 'ddmfortaleza@policiacivil.ce.gov.br', whatsapp: '(85) 3108-2978', instagram: '@policiacivil_ce' },
    { name: 'DEAM Goiânia (Setor Central)', city: 'Goiânia', state: 'GO', phone: '(62) 3201-2802', email: 'deam-goiania@policiacivil.go.gov.br', whatsapp: '(62) 3201-2802', instagram: '@pcgooficial' },
    { name: 'DEAM Centro (Rio de Janeiro)', city: 'Rio de Janeiro', state: 'RJ', phone: '(21) 2334-9859', email: 'ciambaixada@yahoo.com.br', whatsapp: '(21) 98322-0597', instagram: '@policiacivilrj' },
    { name: '1ª DDM - Centro (Casa da Mulher Brasileira)', city: 'São Paulo', state: 'SP', phone: '(11) 3275-8000', email: 'spaulo.ddm01@policiacivil.sp.gov.br', whatsapp: '(11) 3275-8000', instagram: '@policiacivilsp' },
    { name: 'DEAM Porto Alegre (Referência CRAM 24H)', city: 'Porto Alegre', state: 'RS', phone: '(51) 3289-5101', email: 'cdm.smds@portoalegre.rs.gov.br', whatsapp: '(51) 99271-4512', instagram: '@policiacivilrs' },
    { name: 'DPCAMI Capital (Florianópolis)', city: 'Florianópolis', state: 'SC', phone: '(48) 3665-6528', email: '6dpcapital@pc.sc.gov.br', whatsapp: '(48) 3665-6528', instagram: '@policiacivilsc' }
];

const sliderWrapper = document.getElementById('slider-wrapper');
const loadingIndicator = document.getElementById('loading-indicator');
const errorMessage = document.getElementById('error-message');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');

let currentSlide = 0;
let totalItems = 0;
let itemsPerView = 1;

function createStationCard(station, index) {
    const isDark = index % 3 === 1;
    const cardClass = isDark ? 'card-dark shadow-2xl' : 'card-light border border-gray-200 shadow-md';
    const iconColor = isDark ? 'text-white' : 'text-pink-600';
    const title = station.name;
    const location = `${station.city} / ${station.state}`;
    const detailColor = isDark ? 'text-pink-200' : 'text-gray-600';

    return `
        <div class="slider-item">
            <div class="p-6 rounded-xl ${cardClass} h-full text-left transform transition duration-300 hover:scale-[1.03]">
                <h3 class="text-xl font-bold mb-1">${title}</h3>
                <p class="${detailColor} text-sm mb-4">${location}</p>
                <ul class="space-y-3">
                    <li class="flex items-center"><i class="fas fa-phone w-5 ${iconColor} mr-3"></i><span>${station.phone}</span></li>
                    <li class="flex items-center"><i class="fas fa-envelope w-5 ${iconColor} mr-3"></i><span>${station.email}</span></li>
                    <li class="flex items-center"><i class="fab fa-whatsapp w-5 ${iconColor} mr-3"></i><span>${station.whatsapp}</span></li>
                    <li class="flex items-center"><i class="fab fa-instagram w-5 ${iconColor} mr-3"></i><span>${station.instagram}</span></li>
                </ul>
            </div>
        </div>
    `;
}

function setupCarousel(data) {
    totalItems = data.length;
    sliderWrapper.innerHTML = data.map((s, i) => createStationCard(s, i)).join('');
    sliderWrapper.classList.remove('hidden');
    updateSliderControls();
    window.addEventListener('resize', updateSliderControls);
    prevBtn.onclick = () => navigate(-1);
    nextBtn.onclick = () => navigate(1);
}

function navigate(direction) {
    const maxIndex = totalItems - itemsPerView;
    currentSlide += direction;
    if (currentSlide < 0) currentSlide = maxIndex;
    if (currentSlide > maxIndex) currentSlide = 0;
    const w = sliderWrapper.querySelector('.slider-item').offsetWidth;
    sliderWrapper.scrollTo({ left: currentSlide * w, behavior: 'smooth' });
    updateButtonVisibility();
}

function updateSliderControls() {
    itemsPerView = window.innerWidth >= 768 ? 3 : 1;
    const w = sliderWrapper.querySelector('.slider-item')?.offsetWidth || 0;
    sliderWrapper.scrollLeft = currentSlide * w;
    updateButtonVisibility();
}

function updateButtonVisibility() {
    if (totalItems <= itemsPerView) {
        prevBtn.classList.add('hidden');
        nextBtn.classList.add('hidden');
    } else {
        prevBtn.classList.remove('hidden');
        nextBtn.classList.remove('hidden');
    }
}

function initializePage() {
    setTimeout(() => {
        loadingIndicator.classList.add('hidden');
        setupCarousel(DEAM_CONTACTS);
    }, 500);
}

document.addEventListener('DOMContentLoaded', initializePage);
