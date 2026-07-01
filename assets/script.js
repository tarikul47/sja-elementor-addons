// Mobile menu toggle
/*
        const menuToggle = document.getElementById('menuToggle');
        const primaryNav = document.getElementById('primaryNav');
        menuToggle.addEventListener('click', () => {
            const isOpen = primaryNav.classList.toggle('open');
            menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
        primaryNav.querySelectorAll('a').forEach(a => {
            a.addEventListener('click', () => {
                primaryNav.classList.remove('open');
                menuToggle.setAttribute('aria-expanded', 'false');
            });
        });
*/
// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach((a) => {
  a.addEventListener("click", (e) => {
    const id = a.getAttribute("href");
    if (id.length > 1) {
      const t = document.querySelector(id);
      if (t) {
        e.preventDefault();
        t.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    }
  });
});
// Reveal on scroll — only enable the hidden/animate-in state once
// the observer is ready, and force-reveal everything after a short
// safety timeout so nothing can be permanently stuck invisible
// (e.g. if an element never intersects, or JS throws elsewhere).
const revealEls = document.querySelectorAll(".reveal");
document.documentElement.classList.add("js-ready");
const io = new IntersectionObserver(
  (es) => es.forEach((e) => e.isIntersecting && e.target.classList.add("in")),
  { threshold: 0.1 },
);
revealEls.forEach((el) => {
  io.observe(el);
  setTimeout(() => el.classList.add("in"), 2500);
});
