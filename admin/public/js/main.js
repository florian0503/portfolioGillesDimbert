/* ═══════════════════════════════════════
   MAIN — initialisation Lenis + GSAP
   (chargé en premier, avant animations.js et ui.js)
═══════════════════════════════════════ */

gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

/* ─── LENIS SMOOTH SCROLL ─── */
const lenis = new Lenis({
  wrapper: document.getElementById('scroll-container'),
  content: document.getElementById('scroll-content'),
  lerp: 0.08,
  smooth: true,
  direction: 'vertical',
});

/* Connecter ScrollTrigger à Lenis */
const scrollEl = document.getElementById('scroll-container');
ScrollTrigger.defaults({ scroller: scrollEl });

/* scrollerProxy — nécessaire pour que GSAP pin calcule
   les positions correctement avec un scroller custom Lenis */
ScrollTrigger.scrollerProxy(scrollEl, {
  scrollTop(value) {
    if (arguments.length) { lenis.scrollTo(value); return; }
    return lenis.scroll;
  },
  getBoundingClientRect() {
    return { top: 0, left: 0, width: window.innerWidth, height: window.innerHeight };
  },
  pinType: 'transform'
});

lenis.on('scroll', ScrollTrigger.update);
gsap.ticker.add((time) => lenis.raf(time * 1000));
gsap.ticker.lagSmoothing(0);
