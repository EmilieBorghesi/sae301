jQuery(($) => {
  let timer;

  $(document.body).on("change", ".woocommerce-cart-form .qty", () => {
    clearTimeout(timer);
    timer = setTimeout(() => {
      $(".woocommerce-cart-form [name='update_cart']").prop("disabled", false).trigger("click");
    }, 400);
  });
});
