/* ═══════════════════════════════════════
   UI — interactions : cursor, loader, nav,
        tabs, carousel, compteurs, parcours
═══════════════════════════════════════ */

/* ─── CURSOR ─── */
const cur  = document.getElementById('cur');
const ring = document.getElementById('cur-ring');
let cx=0,cy=0,rx=0,ry=0;
document.addEventListener('mousemove',e=>{cx=e.clientX;cy=e.clientY});
if(window.innerWidth > 900){
  (function animCur(){
    rx+=(cx-rx)*.1; ry+=(cy-ry)*.1;
    cur.style.left=cx+'px'; cur.style.top=cy+'px';
    ring.style.left=rx+'px'; ring.style.top=ry+'px';
    requestAnimationFrame(animCur);
  })();
}
document.querySelectorAll('a,button,.testi-tab,.real-tab,.exp-card').forEach(el=>{
  el.addEventListener('mouseenter',()=>document.body.classList.add('hovering'));
  el.addEventListener('mouseleave',()=>document.body.classList.remove('hovering'));
});

/* ─── LOADER ─── */
const loaderTl = gsap.timeline({
  onComplete:()=>{ document.getElementById('loader').style.display='none'; startAnimations(); }
});
loaderTl
  /* — Phase 1 : photo apparaît sur fond noir — */
  .fromTo('#loaderPhoto',
    {opacity:0,scale:1.06},
    {opacity:1,scale:1,duration:.8,ease:'power2.out'},
    0.2)

  /* — Phase 2 : arcs circulaires s'élargissent en même temps — */
  .to(['#arcLeft','#arcRight'],{
    clipPath:(i)=>i===0?'circle(150% at 0% 50%)':'circle(150% at 100% 50%)',
    duration:1.4,ease:'power2.inOut'
  }, 1.2)

  /* — Phase 3 : DRH se révèle lettre par lettre — */
  .to(['#llD','#llR','#llH'],
    {y:0,stagger:.1,duration:.75,ease:'expo.out'}, 2.7)

  /* Barre de progression */
  .to('#loaderBar',{width:'100%',duration:1.6,ease:'power2.inOut'}, 1.2)

  /* — Phase 4 : DRH se fond vers l'opacité du filigrane hero — */
  .to('#loaderDRH',{opacity:.04,duration:.7,ease:'power2.in'}, 3.6)

  /* — Phase 5 : loader disparaît, hero prend le relais — */
  .to('#loader',{opacity:0,duration:.5,ease:'power1.in'}, 4.1);

/* ─── NAV + PROGRESS + SCROLL TO TOP + PARCOURS ACTIVE ─── */
const progBar     = document.getElementById('progress');
const scrollTopBtn = document.getElementById('scroll-top');
const navEl       = document.getElementById('nav');
const tl2El     = document.querySelector('.tl2');
const tl2FillEl = document.getElementById('tl2Fill');
let tl2AbsTop = null, tl2H = 0;

function updateParcours(scroll){
  if(tl2FillEl && tl2El){
    if(tl2AbsTop===null){
      tl2AbsTop = tl2El.getBoundingClientRect().top + scroll;
      tl2H = tl2El.offsetHeight;
    }
    const vh = window.innerHeight;
    const p = Math.max(0,Math.min(1,(scroll-(tl2AbsTop-vh*.8))/(tl2H-vh*.4+vh*.8)));
    tl2FillEl.style.height = (p*100)+'%';
  }
}

/* Nav active section */
const navSections = ['apropos','expertises','parcours','temoignages'];
const navLinks = {};
navSections.forEach(id=>{
  const a = document.querySelector(`.nav-links a[href="#${id}"]`);
  if(a) navLinks[id] = a;
});

lenis.on('scroll',({progress,scroll})=>{
  /* Barre de progression globale */
  progBar.style.width = (progress*100)+'%';
  /* Scroll to top */
  scrollTopBtn.classList.toggle('visible', scroll>400);
  /* Nav scrolled */
  navEl.classList.toggle('scrolled', scroll>60);

  /* Nav section active */
  let activeSection = null;
  navSections.forEach(id=>{
    const el = document.getElementById(id);
    if(!el) return;
    const r = el.getBoundingClientRect();
    if(r.top <= 80 && r.bottom > 80) activeSection = id;
  });
  navSections.forEach(id=>{
    if(navLinks[id]) navLinks[id].classList.toggle('active', id===activeSection);
  });

  updateParcours(scroll);
});

/* ─── SCROLL NATIF MOBILE ─── */
if(window.innerWidth <= 900){
  window.addEventListener('scroll',()=>{
    const s = window.scrollY;
    const max = document.documentElement.scrollHeight - window.innerHeight;
    navEl.classList.toggle('scrolled', s > 60);
    scrollTopBtn.classList.toggle('visible', s > 400);
    progBar.style.width = (s / max * 100) + '%';

    updateParcours(s);
  });
}

/* ─── BURGER MENU ─── */
const burger = document.getElementById('navBurger');
const mobileMenu = document.getElementById('mobileMenu');
burger.addEventListener('click',()=>{
  const isOpen = mobileMenu.classList.toggle('open');
  burger.classList.toggle('open', isOpen);
  document.body.style.overflow = isOpen ? 'hidden' : '';
});

/* ─── SMOOTH NAV LINKS ─── */
document.querySelectorAll('a[href^="#"]').forEach(a=>{
  a.addEventListener('click',e=>{
    e.preventDefault();
    /* Fermer le menu mobile si ouvert */
    mobileMenu.classList.remove('open');
    burger.classList.remove('open');
    document.body.style.overflow = '';
    const t = document.querySelector(a.getAttribute('href'));
    if(!t) return;
    if(window.innerWidth <= 900){
      t.scrollIntoView({behavior:'smooth'});
    } else {
      lenis.scrollTo(t,{offset:-64,duration:1.4});
    }
  });
});

/* ─── TABS RÉALISATIONS ─── */
function switchReal(i){
  document.querySelectorAll('.real-panel').forEach((p,j)=>p.classList.toggle('active',i===j));
  document.querySelectorAll('.real-tab').forEach((b,j)=>b.classList.toggle('active',i===j));
  const active = document.getElementById('real-'+i);
  gsap.fromTo(active.querySelectorAll('.real-col'),
    {opacity:0,y:20},{opacity:1,y:0,stagger:.1,duration:.5,ease:'power2.out'}
  );
}

/* ─── TABS TÉMOIGNAGES ─── */
function switchTesti(i){
  document.querySelectorAll('.testi-panel').forEach((p,j)=>p.classList.toggle('active',i===j));
  document.querySelectorAll('.testi-tab').forEach((b,j)=>b.classList.toggle('active',i===j));
  const active = document.getElementById('testi-'+i);
  gsap.fromTo(active.querySelectorAll('.testi-card'),
    {opacity:0,y:16},{opacity:1,y:0,stagger:.04,duration:.4,ease:'power2.out'}
  );
}

/* ─── STATS COUNTERS ─── */
function animateStat(el){
  const target = +el.getAttribute('data-target');
  const supHTML = el.querySelector('sup')?.outerHTML||'';
  const obj = {val:0};
  gsap.to(obj,{
    val:target,duration:2,ease:'power2.out',
    onUpdate(){ el.innerHTML = Math.round(obj.val).toLocaleString('fr-FR')+supHTML; }
  });
}

if(window.innerWidth > 900){
  document.querySelectorAll('.stat-num[data-target]').forEach(el=>{
    ScrollTrigger.create({trigger:el,start:'top 85%',once:true,
      onEnter:()=>animateStat(el)
    });
  });
} else {
  const statObs = new IntersectionObserver((entries)=>{
    entries.forEach(entry=>{
      if(entry.isIntersecting){
        animateStat(entry.target);
        statObs.unobserve(entry.target);
      }
    });
  },{threshold:0.5});
  document.querySelectorAll('.stat-num[data-target]').forEach(el=>statObs.observe(el));
}

/* ─── REVEAL ANIMATIONS MOBILE ─── */
if(window.innerWidth <= 900){
  const revealEls = document.querySelectorAll(
    '.section-label,.section-title,.pitch-item,.exp-pin-card,.method-step,.sources-list li'
  );
  revealEls.forEach(el=>el.classList.add('mob-reveal'));

  const revealObs = new IntersectionObserver((entries)=>{
    entries.forEach(entry=>{
      if(!entry.isIntersecting) return;
      const el = entry.target;
      const siblings = [...el.parentElement.querySelectorAll('.mob-reveal')];
      const idx = siblings.indexOf(el);
      el.style.transitionDelay = (idx * 0.09)+'s';
      el.classList.add('mob-revealed');
      revealObs.unobserve(el);
    });
  },{threshold:0.1,rootMargin:'0px 0px -30px 0px'});

  revealEls.forEach(el=>revealObs.observe(el));
}

/* ─── SCROLLBAR CUSTOM ─── */
(function(){
  const bar = document.getElementById('custom-scrollbar');
  if(!bar) return;
  // Calculer le nb de tirets pour remplir la hauteur dispo (tick 1.5px + gap 2px = 3.5px)
  const availH = window.innerHeight - 64;
  const TICKS = Math.floor(availH / 3.5);
  const ACTIVE = 8;
  for(let i=0;i<TICKS;i++){
    const t = document.createElement('div');
    t.className = 'csb-tick';
    bar.appendChild(t);
  }
  const ticks = bar.querySelectorAll('.csb-tick');
  function update(){
    const el = document.getElementById('scroll-container');
    if(!el) return;
    const progress = el.scrollTop / (el.scrollHeight - el.clientHeight);
    const activeStart = Math.round(progress * (TICKS - ACTIVE));
    // Largeurs des 6 tirets actifs : effet tapered (petit→grand→grand→petit)
    const activeWidths = [13, 15, 20, 20, 20, 20, 15, 13];
    ticks.forEach((t,i)=>{
      const isActive = i >= activeStart && i < activeStart + ACTIVE;
      t.classList.toggle('active', isActive);
      t.style.width = isActive ? activeWidths[i - activeStart] + 'px' : '12px';
    });
  }
  const container = document.getElementById('scroll-container');
  container?.addEventListener('scroll', update);
  lenis?.on('scroll', update);

  // Click pour naviguer
  bar.addEventListener('click', e => {
    const rect = bar.getBoundingClientRect();
    const ratio = (e.clientY - rect.top) / rect.height;
    const target = ratio * (container.scrollHeight - container.clientHeight);
    lenis ? lenis.scrollTo(target, {duration:0.8}) : container.scrollTo({top:target,behavior:'smooth'});
  });

  update();
})();
