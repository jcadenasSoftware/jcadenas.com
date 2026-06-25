// Smooth scrolling for internal links with .smooth-link

document.addEventListener('DOMContentLoaded',()=>{
  document.querySelectorAll('a.smooth-link').forEach(link=>{
    link.addEventListener('click',e=>{
      const targetId = link.getAttribute('href');
      if(targetId.startsWith('#')){
        e.preventDefault();
        const el = document.querySelector(targetId);
        if(el){
          el.scrollIntoView({behavior:'smooth'});
        }
      }
    });
  });
});
