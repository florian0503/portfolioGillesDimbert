/* ═══════════════════════════════════════
   ANIMATIONS — toutes les animations GSAP/ScrollTrigger
═══════════════════════════════════════ */

/* ─── HERO ENTRANCE ─── */
function startAnimations(){
  gsap.set('.word-inner',{y:'110%'});
  gsap.set('#heroLabel,#heroTagline,#heroRight,#heroScroll',{opacity:0});
  const htl = gsap.timeline({defaults:{ease:'power4.out'}});
  htl
    .to('#heroLabel',{opacity:1,y:0,duration:.7},0)
    .to('.word-inner',{y:0,duration:1,stagger:.1,ease:'power3.out'},0.1)
    .to('#heroTagline',{opacity:1,duration:.8},0.6)
    .to('#heroRight',{opacity:1,duration:.8},0.8)
    .to('#heroScroll',{opacity:1,duration:.8},1.2);
}
/* Forcer l'état initial immédiatement */
gsap.set('.word-inner',{y:'110%'});
gsap.set('#heroLabel,#heroTagline,#heroRight,#heroScroll',{opacity:0});

/* ─── HERO PARALLAX — texte DRH ─── */
gsap.to('.hero-bg-text',{
  yPercent:55, xPercent:-8, scale:1.15, opacity:0, ease:'none',
  scrollTrigger:{trigger:'#hero',start:'top top',end:'bottom top',scrub:1}
});

/* ─── PITCH HEADLINE — mots qui s'allument ─── */
const pitchText = "DRH opérationnel intervenant en management de transition ou en CDI, j'accompagne les dirigeants confrontés à des décisions sociales sensibles et à des contextes organisationnels complexes.";
const pitchEl   = document.getElementById('pitchHeadline');
pitchEl.textContent = pitchText;

/* ─── TEXT REVEAL — section titles ─── */
function initTextReveal(){
  document.querySelectorAll('.section-title').forEach(el=>{
    const words = el.textContent.split(' ');
    el.innerHTML = words.map(w=>`<span class="word-detect" style="display:inline-block;white-space:pre">${w} </span>`).join('');
    el.classList.add('split-title');

    const wordEls = el.querySelectorAll('.word-detect');
    const lines = [];
    let currentLine = [], lastTop = null;
    wordEls.forEach(w=>{
      const top = w.offsetTop;
      if(lastTop !== null && top !== lastTop){ lines.push(currentLine); currentLine = []; }
      currentLine.push(w.textContent);
      lastTop = top;
    });
    if(currentLine.length) lines.push(currentLine);

    el.innerHTML = lines.map(lw =>
      `<span class="line-wrap"><span class="line-inner">${lw.join('')}</span></span>`
    ).join('');

    const inners = el.querySelectorAll('.line-inner');
    gsap.set(inners,{y:'105%'});
    ScrollTrigger.create({
      trigger:el, start:'top 90%', once:true,
      onEnter:()=>gsap.to(inners,{y:0,duration:.9,stagger:.12,ease:'power3.out'})
    });
  });
}
initTextReveal();

/* ─── PIN EXPERTISES ─── */
const expPinCards  = document.querySelectorAll('.exp-pin-card');
const expBigTitle  = document.getElementById('expBigTitle');
const expBigNum    = document.getElementById('expBigNum');
const expIdxEl     = document.getElementById('expIdx');
const expProgBarEl = document.getElementById('expProgBar');
const expLeftImg   = document.getElementById('expLeftImg');
let expCurrentIdx  = -1;

const expImages = ['img/exp-negociation.jpg','img/exp-transformation.jpg','img/exp-pilotage.jpg','img/exp-modernisation.jpg'];

// Lecture dynamique des données depuis le DOM
const expData = Array.from(expPinCards).map((card,i) => ({
  num:   card.querySelector('.epc-num')?.textContent  ?? '',
  title: card.querySelector('.epc-title')?.textContent ?? '',
  img:   expImages[i] ?? '',
}));
const expTotal = String(expData.length).padStart(2,'0');

function updateExpLeft(i){
  if(expCurrentIdx === i) return;
  expCurrentIdx = i;
  const d = expData[i];
  gsap.to([expBigTitle,expBigNum],{
    opacity:0,y:-8,duration:.18,
    onComplete(){
      expBigNum.textContent   = d.num;
      expBigTitle.textContent = d.title;
      expIdxEl.textContent    = `${d.num} / ${expTotal}`;
      if(expLeftImg && d.img) expLeftImg.src = d.img;
      gsap.to([expBigTitle,expBigNum],{opacity:1,y:0,duration:.35,ease:'power2.out'});
    }
  });
}

function buildExpPin(){
  updateExpLeft(0);
  expProgBarEl.style.height = (1/expPinCards.length*100)+'%';

  if(window.innerWidth <= 900) return;

  lenis.on('scroll', () => {
    let activeIdx = 0;
    expPinCards.forEach((card, i) => {
      const rect = card.getBoundingClientRect();
      if(rect.top < window.innerHeight * 0.35) activeIdx = i;
    });
    updateExpLeft(activeIdx);
    expProgBarEl.style.height = ((activeIdx+1)/expPinCards.length*100)+'%';
  });
}
requestAnimationFrame(()=>requestAnimationFrame(buildExpPin));

/* ─── MÉTHODE — reveal steps on scroll (sans pin) ─── */
const methodSteps = gsap.utils.toArray('.method-step');
const methodStepsHidden = methodSteps.slice(1);
gsap.set(methodStepsHidden,{clipPath:'inset(100% 0 0 0)'});
methodStepsHidden.forEach((step,i)=>{
  ScrollTrigger.create({
    trigger:step, start:'top 85%', once:true,
    onEnter:()=>gsap.to(step,{clipPath:'inset(0% 0 0 0)',duration:.9,delay:i*.2,ease:'power3.out'})
  });
});

/* ─── CLIP REVEALS — pitch, stats, testi ─── */
gsap.utils.toArray('.pitch-item').forEach((el,i)=>{
  gsap.set(el,{clipPath:'inset(100% 0 0 0)'});
  ScrollTrigger.create({trigger:el,start:'top 88%',once:true,
    onEnter:()=>gsap.to(el,{clipPath:'inset(0% 0 0 0)',duration:.9,delay:i*.12,ease:'power3.out'})
  });
});
gsap.utils.toArray('.stat-block').forEach((el,i)=>{
  gsap.set(el,{clipPath:'inset(100% 0 0 0)'});
  ScrollTrigger.create({trigger:el,start:'top 88%',once:true,
    onEnter:()=>gsap.to(el,{clipPath:'inset(0% 0 0 0)',duration:.8,delay:i*.1,ease:'power3.out'})
  });
});
gsap.utils.toArray('.testi-card').forEach((el,i)=>{
  gsap.set(el,{opacity:0,y:20});
  ScrollTrigger.create({trigger:el,start:'top 90%',once:true,
    onEnter:()=>gsap.to(el,{opacity:1,y:0,duration:.55,delay:(i%3)*.08,ease:'power2.out'})
  });
});

/* ─── SECTION LABELS ─── */
gsap.utils.toArray('.section-label').forEach(el=>{
  gsap.set(el,{opacity:0,y:20});
  ScrollTrigger.create({trigger:el,start:'top 92%',once:true,
    onEnter:()=>gsap.to(el,{opacity:1,y:0,duration:.6,ease:'power2.out'})
  });
});

/* ─── À PROPOS ─── */
gsap.utils.toArray('.apropos-content p').forEach((el,i)=>{
  gsap.set(el,{opacity:0,y:24});
  ScrollTrigger.create({trigger:el,start:'top 92%',once:true,
    onEnter:()=>gsap.to(el,{opacity:1,y:0,duration:.7,delay:i*.08,ease:'power2.out'})
  });
});
gsap.set('.apropos-photo img',{clipPath:'inset(100% 0 0 0)'});
ScrollTrigger.create({trigger:'.apropos-photo',start:'top 85%',once:true,
  onEnter:()=>gsap.to('.apropos-photo img',{clipPath:'inset(0% 0 0 0)',duration:1,ease:'power3.out'})
});
gsap.set('.apropos-photo-meta',{opacity:0,y:16});
ScrollTrigger.create({trigger:'.apropos-photo-meta',start:'top 90%',once:true,
  onEnter:()=>gsap.to('.apropos-photo-meta',{opacity:1,y:0,duration:.6,ease:'power2.out'})
});
gsap.utils.toArray('.apropos-when li').forEach((el,i)=>{
  gsap.set(el,{clipPath:'inset(100% 0 0 0)'});
  ScrollTrigger.create({trigger:el,start:'top 92%',once:true,
    onEnter:()=>gsap.to(el,{clipPath:'inset(0% 0 0 0)',duration:.6,delay:i*.05,ease:'power2.out'})
  });
});

/* ─── PARCOURS — cascade ligne par ligne ─── */
gsap.utils.toArray('.tl2-item').forEach((item)=>{
  /* Parallax grand numéro de fond */
  const bignum = item.querySelector('.tl2-bignum');
  if(bignum){
    gsap.to(bignum,{y:'-20%',ease:'none',
      scrollTrigger:{trigger:item,start:'top bottom',end:'bottom top',scrub:1.5}
    });
  }

  /* Toutes les lignes : .tl2-line = méta, logo, company, role, context, labels, li, footer */
  const lines = item.querySelectorAll('.tl2-line');
  if(!lines.length) return;

  gsap.set(lines,{opacity:0,y:22});

  ScrollTrigger.create({
    trigger:item, start:'top 82%', once:true,
    onEnter:()=>gsap.to(lines,{
      opacity:1, y:0,
      duration:.55, stagger:.065,
      ease:'power2.out'
    })
  });
});

/* ─── CONTACT ─── */
gsap.set('.contact-big',{opacity:0,y:50});
ScrollTrigger.create({trigger:'.contact-big',start:'top 92%',once:true,
  onEnter:()=>gsap.to('.contact-big',{opacity:1,y:0,duration:1,ease:'power3.out'})
});
gsap.set('.contact-grid',{opacity:0,y:30});
ScrollTrigger.create({trigger:'.contact-grid',start:'top 92%',once:true,
  onEnter:()=>gsap.to('.contact-grid',{opacity:1,y:0,duration:.8,delay:.2,ease:'power2.out'})
});

/* ─── REFRESH après chargement complet ─── */
window.addEventListener('load', () => {
  ScrollTrigger.refresh();
});
