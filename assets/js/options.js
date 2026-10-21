jQuery(($) => {
  $(".variations_form").each(function () {
    const form = $(this);

    const sync = () => {
      form.find(".options__list").each(function () {
        const select = $(document.getElementById(this.dataset.select));
        const values = select.find("option").map((index, option) => option.value).get();

        $(this).find(".option__input").each(function () {
          this.checked = this.value === select.val();
          this.disabled = !values.includes(this.value);
        });
      });
    };

    form.on("change", ".option__input", function () {
      const list = this.closest(".options__list");
      $(document.getElementById(list.dataset.select)).val(this.value).trigger("change");
    });

    form.on("woocommerce_update_variation_values reset_data", sync);
    sync();
  });
});
