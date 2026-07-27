
// Main JS - Animations & Interactions
document.addEventListener('DOMContentLoaded',function(){
if (typeof fixFileProtocolLinks === 'function') fixFileProtocolLinks();
// Scroll animations
const observer = new IntersectionObserver((entries)=>{
entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('visible');observer.unobserve(e.target);}});
},{threshold:0.1});
document.querySelectorAll('.animate').forEach(el=>observer.observe(el));

// Header scroll effect
const header = document.getElementById('siteHeader');
if(header){
window.addEventListener('scroll',()=>{
header.classList.toggle('scrolled',window.scrollY>50);
});
}

// Hero slider
const slides = document.querySelectorAll('.hero-slide');
const dots = document.querySelectorAll('.hero-dots .dot');
if(slides.length>1){
let current=0;
function goSlide(i){
slides.forEach(s=>s.classList.remove('active'));
dots.forEach(d=>d.classList.remove('active'));
slides[i].classList.add('active');
if(dots[i])dots[i].classList.add('active');
current=i;
}
window.goSlide=goSlide;
setInterval(()=>{goSlide((current+1)%slides.length);},5000);
}

// Counter animation
const counters = document.querySelectorAll('.stat-val');
const counterObs = new IntersectionObserver((entries)=>{
entries.forEach(entry=>{
if(entry.isIntersecting){
const el = entry.target;
const text = el.textContent;
const match = text.match(/(\d+)/);
if(match){
const target = parseInt(match[1]);
const suffix = text.replace(match[1],'');
let count=0;
const step = Math.ceil(target/40);
const timer = setInterval(()=>{
count+=step;
if(count>=target){count=target;clearInterval(timer);}
el.textContent=count+suffix;
},30);
}
counterObs.unobserve(el);
}
});
},{threshold:0.5});
counters.forEach(c=>counterObs.observe(c));
});
