  document.addEventListener("DOMContentLoaded", function () {
    const spans = document.querySelectorAll(".title_welcome .letter_title_welcome");
    spans.forEach((span, index) => {
      setTimeout(() => {
        span.style.opacity = 1;
      }, index * 200); // Adjust the delay to 200ms for better visibility
    });
  });
