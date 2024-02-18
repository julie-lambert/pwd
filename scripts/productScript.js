document.addEventListener("DOMContentLoaded", function () {
  let sections = document.querySelectorAll("section");
  let main = document.querySelector("main");

  sections.forEach((section) => {
    let swiper = new Swiper(section.querySelector(".swiper"), {
      loop: true,
      slidesPerView: 1,
      pagination: {
        el: section.querySelector(".swiper-pagination"),
        clickable: true,
      },
      centeredSlides: true,
      navigation: {
        nextEl: section.querySelector(".button-right"),
        prevEl: section.querySelector(".button-left"),
      },
    });

    if (window.innerWidth >= 1024) {
      let photos = section.querySelectorAll(".photos > div");
      let dots = section.querySelectorAll(".swiper-pagination span");

      const activeThumb = (current) => {
        section.querySelector(".photos > .active").classList.remove("active");
        current.classList.add("active");
      };

      photos.forEach((photo, i) => {
        photo.addEventListener("click", () => {
          activeThumb(photo);
          dots[i].click();
        });
      });

      swiper.on("realIndexChange", (swiper) => {
        activeThumb(photos[swiper.realIndex]);
      });
    }
  });

  const activeSection = () => {
    sections.forEach(section => {
      if (section.getBoundingClientRect().y > -100 && section.getBoundingClientRect().y < 100) {
        section.classList.add("active");
      } else {
        section.classList.remove("active");
      }
    })
  }

  if (window.innerWidth >= 1024) {
    activeSection();
    main.addEventListener("scroll", activeSection);
  }
});


