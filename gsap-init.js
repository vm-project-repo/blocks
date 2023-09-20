gsap.registerPlugin( ScrollTrigger );


/* Main navigation */

const showAnim = gsap.from('.site-header', { 
	yPercent: -107,
	paused: true,
	duration: 0.2
  }).progress(1);
  
ScrollTrigger.create({
	start: "top -80px",
	end: 99999,
	onUpdate: (self) => {
	  self.direction === -1 ? showAnim.play() : showAnim.reverse()
	},
	toggleClass: {className: 'site-header--scrolled', targets: '.site-header'}
});




/**
* Magnetic Buttons
*/
  
var magnets = document.querySelectorAll('.magnetic');
var strength = 100;
  
// START : If screen is bigger as 540 px do magnetic


// Mouse Reset
magnets.forEach( (magnet) => {

  magnet.addEventListener('mousemove', moveMagnet );
  $(this.parentNode).removeClass('not-active');
  magnet.addEventListener('mouseleave', function(event) {

    gsap.to( event.currentTarget, 1.5, {
      x: 0, 
      y: 0, 
      ease: Elastic.easeOut
    });

    gsap.to( $(this).find(".btn-text"), 1.5, {
        x: 0, 
        y: 0, 
        ease: Elastic.easeOut
    });

  });

});

// Mouse move
function moveMagnet(event) {
  var magnetButton = event.currentTarget;
  var bounding = magnetButton.getBoundingClientRect();
  var magnetsStrength = magnetButton.getAttribute("data-strength");
  var magnetsStrengthText = magnetButton.getAttribute("data-strength-text");

    gsap.to( magnetButton, 1.5, {
        x: ((( event.clientX - bounding.left)/magnetButton.offsetWidth) - 0.5) * magnetsStrength,
        y: ((( event.clientY - bounding.top)/magnetButton.offsetHeight) - 0.5) * magnetsStrength,
        rotate: "0.001deg",
        ease: Power4.easeOut
    });

    gsap.to( $(this).find(".btn-text"), 1.5, {
        x: ((( event.clientX - bounding.left)/magnetButton.offsetWidth) - 0.5) * magnetsStrengthText,
        y: ((( event.clientY - bounding.top)/magnetButton.offsetHeight) - 0.5) * magnetsStrengthText,
        rotate: "0.001deg",
        ease: Power4.easeOut
    });

}




















/* Home Hero - GSAP  */






    

// Find all text with .tricks class and break each letter into a span
var spanWord = document.getElementsByClassName("split-words");
for (var i = 0; i < spanWord.length; i++) {

var wordWrap = spanWord.item(i);
wordWrap.innerHTML = wordWrap.innerHTML.replace(/(^|<\/?[^>]+>|\s+)([^\s<]+)/g, '$1<span class="word">$2</span>');

}










/* Stack - GSAP  */


let direction = 1; // 1 = forward, -1 = backward scroll

const roll1 = roll(".line__1", {duration: 34}),
      roll2 = roll(".line__2", {duration: 34}, true),
      scroll = ScrollTrigger.create({
        onUpdate(self) {
          if (self.direction !== direction) {
            direction *= -1;
            gsap.to([roll1, roll2], {timeScale: direction, overwrite: true});
          }
        }
      });

// helper function that clones the targets, places them next to the original, then animates the xPercent in a loop to make it appear to roll across the screen in a seamless loop.
function roll(targets, vars, reverse) {
  vars = vars || {};
  vars.ease || (vars.ease = "none");
  const tl = gsap.timeline({
          repeat: -1,
          onReverseComplete() { 
            this.totalTime(this.rawTime() + this.duration() * 34); // otherwise when the playhead gets back to the beginning, it'd stop. So push the playhead forward 10 iterations (it could be any number)
          }
        }), 
        elements = gsap.utils.toArray(targets),
        clones = elements.map(el => {
          let clone = el.cloneNode(true);
          el.parentNode.appendChild(clone);
          return clone;
        }),
        positionClones = () => elements.forEach((el, i) => gsap.set(clones[i], {position: "absolute", overwrite: false, top: el.offsetTop, left: el.offsetLeft + (reverse ? -el.offsetWidth : el.offsetWidth)}));
  positionClones();
  elements.forEach((el, i) => tl.to([el, clones[i]], {xPercent: reverse ? 100 : -100, ...vars}, 0));
  window.addEventListener("resize", () => {
    let time = tl.totalTime(); // record the current time
    tl.totalTime(0); // rewind and clear out the timeline
    positionClones(); // reposition
    tl.totalTime(time); // jump back to the proper time
  });
  return tl;
}










/* Home Services - GSAP Horizontal Scroll */

if(window.innerWidth > 1023) {



  let titleServicesAnim = document.querySelectorAll('.home-services-section-title-part');

  titleServicesAnim.forEach(function(e) {

    var titleServicesItem = e.querySelectorAll('span');
    
    ScrollTrigger.batch(titleServicesItem, {
      onEnter: batch => gsap.fromTo(batch, { yPercent: 175, skewY: 10 }, { yPercent: 0, skewY:0,  ease: "power4.out", duration: 0.7, stagger: {each: 0.1} } ),
      onLeaveBack: batch => gsap.set(batch, { yPercent: 0 })
    });
  
  
  });




  gsap.to(".home-services-conteiner-content img", {
    scrollTrigger: {
      trigger: ".home-services-conteiner-content",
      start: "top top",
      scrub: 0.5,
      pin: ".home-services-conteiner-content img",
    },
    opacity:0,
    rotation: 360,
    ease: "none",
    duration: 1
  })





  let accordionServicesList = document.querySelectorAll('.home-services-conteiner-content');

  accordionServicesList.forEach(function(e) {

    var accordionServicesItem = e.querySelectorAll('.home-service-accordion');
    
    ScrollTrigger.batch(accordionServicesItem, {
      onEnter: batch => gsap.fromTo(batch, { xPercent: -100 }, { xPercent: 0,  duration: 1, stagger: {each: 0.4} } ),
      onLeaveBack: batch => gsap.set(batch, { xPercent: 0 })
    });
  
  });



}




/* Home Projects with Sticky Cursor with Delay */




if(window.innerWidth > 1023) {


  let titlePortfolioAnim = document.querySelectorAll('.home-portfolio-section-title-part');

  titlePortfolioAnim.forEach(function(e) {

    var titlePortfolioAnimItem = e.querySelectorAll('span');
    
    ScrollTrigger.batch(titlePortfolioAnimItem, {
      onEnter: batch => gsap.fromTo(batch, { yPercent: 175, skewY: 10 }, { yPercent: 0, skewY:0,  ease: "power4.out", duration: 0.7, stagger: {each: 0.1} } ),
      onLeaveBack: batch => gsap.set(batch, { yPercent: 0 })
    });
  
  
  });






  gsap.defaults({
    overwrite: true
  });

  document.querySelectorAll('.js-marquee').forEach(function(e) {
      var letter = e.querySelector('.home-portfolio-item-title');
      var clone = letter.cloneNode(true);
      letter.after(clone);
  })

  document.querySelectorAll('.js-marquee').forEach(function(e) {
    
    var marqueePortfolio = e.querySelectorAll('.home-portfolio-item-title');
    
    var tl = gsap
    .to(marqueePortfolio, { duration: 15, xPercent: -100, ease: "none", repeat: -1 })
    .timeScale(0);
    
      e.addEventListener("mouseenter", () => {
          gsap.to(tl, { timeScale: 1 });
      });
    
      e.addEventListener("mouseleave", () => {
          gsap.to(tl, { timeScale: 0, duration: 1.5, ease: "sine" });
      });
    
  })







  var cursorImage = $("ul.portfolio-list-image"); //follower
  var cursorPrtfolio = $(".portfolio-list-image-cursor"); //cursor

  var posXImage = 0
  var posYImage = 0
  var posXBtn = 0
  var posYBtn = 0

  var mouseX = 0
  var mouseY = 0


  if(document.querySelector("ul.portfolio-list-image, .portfolio-list-image-cursor")) {

    gsap.to({}, 0.0083333333, {

      repeat: -1,
      onRepeat: function() {

        if(document.querySelector("ul.portfolio-list-image")) {
          posXImage += (mouseX - posXImage) / 12;
          posYImage += (mouseY - posYImage) / 12;
          gsap.set(cursorImage, {
            css: {
            left: posXImage,
            top: posYImage
            }
          });
        }

        if(document.querySelector(".portfolio-list-image-cursor")) {
          posXBtn += (mouseX - posXBtn) / 7;
          posYBtn += (mouseY - posYBtn) / 7;
          gsap.set(cursorPrtfolio, {
            css: {
            left: posXBtn,
            top: posYBtn
            }
          });
        }

      }

    });

  }

  $(document).on("mousemove", function(e) {
      mouseX = e.clientX;
      mouseY = e.clientY;
  });


  // Animated Section Assortiment Single Floating Image

  $('.portfolio-cursor').on('mouseenter', function() {
    $('.portfolio-list-image, .portfolio-list-image-cursor').addClass('active');
  });

  $('.portfolio-cursor').on('mouseleave', function() {
    $('.portfolio-list-image, .portfolio-list-image-cursor').removeClass('active');
  });

  


  $('.home-portfolio-list li').on('mouseenter', function() {
    
    var $elements = $(".home-portfolio-list li");
    var index =  $elements.index($(this));
    var count = $(".portfolio-list-image li").length;
    // var index =  $(this).index();
    if($(".portfolio-list-image-wrap")) {
        gsap.to($(".portfolio-list-image-wrap"), {
          y: (index*100)/(count*-1) + "%",
          duration: .6,
          ease: Power2.easeInOut
        });
    }

    $(".portfolio-list-image.active portfolio-list-image-bounce").addClass("active").delay(400).queue(function(next){
        $(this).removeClass("active");
        next();
    });

  });


}













/****************BLOG******************/



if(window.innerWidth > 1023) {

  let titleBlogAnim = document.querySelectorAll('.home-blog-section-title-part');

  titleBlogAnim.forEach(function(e) {

    var titleBlogAnimItem = e.querySelectorAll('span');
    
    ScrollTrigger.batch(titleBlogAnimItem, {
      onEnter: batch => gsap.fromTo(batch, { yPercent: 175, skewY: 10 }, { yPercent: 0, skewY:0,  ease: "power4.out", duration: 0.7, stagger: {each: 0.1} } ),
      onLeaveBack: batch => gsap.set(batch, { yPercent: 0 })
    });
  
  
  });






}




/****************CONTACTS******************/



gsap.defaults({
  overwrite: true
});

let titleFooterWrap = document.querySelectorAll('.footer-marquee');

titleFooterWrap.forEach(function(e) {
    var letter = e.querySelector('.footer-marquee-item');
    var clone = letter.cloneNode(true);
    letter.after(clone);
});

 

titleFooterWrap.forEach(function(e) {

  var titleFooterItem = e.querySelectorAll('.footer-marquee-item');
  
  gsap.to(titleFooterItem, { duration: 15, xPercent: -100, ease: "none", repeat: -1, timeScale: 1});


});










/***************************
*************POPUP**********
****************************/


/********************************************
************POPUP CONTACT FORM***************
********************************************/

var tabletMenu = new TimelineMax();

$(document).on('click', '.popup-reviews-open', function() {
  tabletMenu.to(".popup-reviews", 1.2, {y: 0, ease: Expo.easeInOut, delay: -1.2 });
  tabletMenu.play();
  $('body').css('overflow', 'hidden');
});


$(document).on('click', '.popup-reviews-close', function() {
  tabletMenu.reverse();
  $('body').css('overflow', 'auto');
})
