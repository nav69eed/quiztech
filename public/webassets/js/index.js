daynight = document.querySelector('#switch');
logo = document.querySelector('#logo');

// Function to apply dark mode styles
function applyDarkMode() {
    document.documentElement.style.setProperty('--primary', '#111827');
    document.documentElement.style.setProperty('--navbg', 'rgba(31, 41, 55,0.75)');
    document.documentElement.style.setProperty('--fontcolor', '#a6a4a4');
    document.documentElement.style.setProperty('--secondary', '#f77f00');
    document.documentElement.style.setProperty('--action', '#b12166');
    document.documentElement.style.setProperty('--tertiary', '#391560');
    document.documentElement.style.setProperty('--tcolor', 'rgba(156, 163, 175, 1)');
    document.documentElement.style.setProperty('--headingcolor', 'rgba(243, 244, 246, 1)');
    logo.classList.add('inverted-color');
}

// Function to apply light mode styles
function applyLightMode() {
    document.documentElement.style.setProperty('--primary', 'white');
    document.documentElement.style.setProperty('--fontcolor', 'black');
    document.documentElement.style.setProperty('--secondary', '#391560');
    document.documentElement.style.setProperty('--action', '#f77f00');
    document.documentElement.style.setProperty('--tertiary', '#b12166');
    document.documentElement.style.setProperty('--navbg', 'rgba(255,255,255,0.75)');
    document.documentElement.style.setProperty('--tcolor', 'rgba(17, 24, 39, 1)');
    document.documentElement.style.setProperty('--headingcolor', 'rgb(7, 10, 17)');
    logo.classList.remove('inverted-color');
}

// Check localStorage for dark mode setting on page load
if (localStorage.getItem('darkmode') === 'on') {
    daynight.checked = true;
    applyDarkMode();
} else {
    daynight.checked = false;
    applyLightMode();
}

daynight.addEventListener('change', () => {
    if (daynight.checked) {
        applyDarkMode();
        localStorage.setItem('darkmode', 'on');
    } else {
        applyLightMode();
        localStorage.setItem('darkmode', 'off');
    }
});