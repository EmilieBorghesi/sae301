const menuToggle = document.querySelector(".header__toggle");

if (menuToggle) {
  const setMenu = (isOpen) => {
    menuToggle.setAttribute("aria-expanded", String(isOpen));
    document.body.classList.toggle("is-menu-open", isOpen);
  };

  menuToggle.addEventListener("click", () => {
    setMenu(menuToggle.getAttribute("aria-expanded") !== "true");
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && menuToggle.getAttribute("aria-expanded") === "true") {
      setMenu(false);
      menuToggle.focus();
    }
  });
}
