const root = document.documentElement;
root.classList.add('js');

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

/* ---------- Navegación ---------- */
const nav = document.querySelector('[data-nav]');
const menuToggle = document.querySelector('[data-menu-toggle]');
const menu = document.querySelector('[data-menu]');

function setMenu(open) {
    if (!menu || !menuToggle) return;
    menu.dataset.open = String(open);
    menuToggle.setAttribute('aria-expanded', String(open));
    menuToggle.setAttribute('aria-label', open ? 'Cerrar menú' : 'Abrir menú');
}

menuToggle?.addEventListener('click', () => setMenu(menu.dataset.open !== 'true'));
menu?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setMenu(false)));
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && menu?.dataset.open === 'true') {
        setMenu(false);
        menuToggle.focus();
    }
});
window.matchMedia('(min-width: 1024px)').addEventListener('change', (event) => event.matches && setMenu(false));

/* ---------- Apariciones al hacer scroll ---------- */
const revealables = document.querySelectorAll('[data-reveal]');

if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.12 },
    );
    revealables.forEach((el) => observer.observe(el));
} else {
    revealables.forEach((el) => el.classList.add('is-visible'));
}

/* ---------- El queso que viaja con el scroll ----------
 * El bloque 3D vive en una capa fija. Cada sección reserva un hueco
 * ([data-cheese-anchor]) donde el queso se posa; entre un hueco y el siguiente
 * se desliza y gira sincronizado con el desplazamiento de la página.
 */
const stage = document.querySelector('[data-cheese-stage]');
const block = stage?.querySelector('.cheese-block');
const anchors = [...document.querySelectorAll('[data-cheese-anchor]')];
const sellos = document.querySelectorAll('[data-sello]');

// Ancho visual aproximado del bloque a escala 1 (px); en pantallas pequeñas se reduce un poco más.
const cheeseFootprint = () => (window.innerWidth < 640 ? 500 : 400);
let points = [];
let ticking = false;

const lerp = (a, b, t) => a + (b - a) * t;
const clamp01 = (t) => Math.min(1, Math.max(0, t));
// Reposa cerca de cada ancla y viaja en la parte central del tramo.
const travelEase = (t) => {
    const x = clamp01((t - 0.15) / 0.7);
    return x * x * x * (x * (x * 6 - 15) + 10);
};

function measure() {
    const scrollY = window.scrollY;
    const footprint = cheeseFootprint();
    points = anchors
        .filter((anchor) => anchor.offsetParent !== null)
        .map((anchor) => {
            const rect = anchor.getBoundingClientRect();
            return {
                x: rect.left + rect.width / 2,
                y: rect.top + scrollY + rect.height / 2,
                s: (rect.width / footprint) * parseFloat(anchor.dataset.scale || 1),
                rx: parseFloat(anchor.dataset.rx || -22),
                ry: parseFloat(anchor.dataset.ry || -30),
                rz: parseFloat(anchor.dataset.rz || 0),
            };
        });
    if (reducedMotion.matches) points = points.slice(0, 1);
}

function render() {
    ticking = false;
    const scrollY = window.scrollY;

    nav?.classList.toggle('is-scrolled', scrollY > 24);

    if (!reducedMotion.matches) {
        sellos.forEach((sello) => sello.style.setProperty('--giro', `${scrollY * 0.08}deg`));
    }

    if (!stage || !block || !points.length) return;

    const focus = scrollY + window.innerHeight * 0.5;
    const last = points.length - 1;
    let from = points[0];
    let to = points[0];
    let t = 0;

    if (focus >= points[last].y) {
        from = to = points[last];
    } else if (focus > points[0].y) {
        for (let i = 0; i < last; i++) {
            if (focus >= points[i].y && focus < points[i + 1].y) {
                from = points[i];
                to = points[i + 1];
                t = travelEase((focus - from.y) / (to.y - from.y));
                break;
            }
        }
    }

    const arc = Math.sin(t * Math.PI); // 0 en las anclas, 1 a mitad del viaje
    const x = lerp(from.x, to.x, t);
    const y = lerp(from.y, to.y, t) - scrollY;
    const s = lerp(from.s, to.s, t) * (1 - arc * 0.12);
    // El PNG es plano: giros moderados para simular volumen sin delatar el canto.
    const rx = lerp(from.rx, to.rx, t) + arc * 10;
    const ry = lerp(from.ry, to.ry, t) + arc * 16;
    const rz = lerp(from.rz, to.rz, t) + arc * 9;

    stage.style.transform = `translate3d(${x.toFixed(1)}px, ${y.toFixed(1)}px, 0) scale(${s.toFixed(3)})`;
    block.style.transform = `rotateX(${rx.toFixed(2)}deg) rotateY(${ry.toFixed(2)}deg) rotateZ(${rz.toFixed(2)}deg)`;
}

function requestRender() {
    if (!ticking) {
        ticking = true;
        window.requestAnimationFrame(render);
    }
}

function refresh() {
    measure();
    render();
}

window.addEventListener('scroll', requestRender, { passive: true });
window.addEventListener('resize', refresh);
window.addEventListener('load', refresh);
reducedMotion.addEventListener('change', refresh);
document.fonts?.ready.then(refresh);
if ('ResizeObserver' in window) new ResizeObserver(refresh).observe(document.body);

refresh();
requestAnimationFrame(() => stage?.classList.add('is-ready'));
