(() => {
  const modal = document.getElementById("fleetFeatureModal");

  if (!modal) {
    return;
  }

  const title = document.getElementById("fleetFeatureModalTitle");
  const image = document.getElementById("fleetFeatureModalImage");
  const description = document.getElementById("fleetFeatureModalDescription");

  modal.addEventListener("show.bs.modal", (event) => {
    const trigger = event.relatedTarget;

    if (!(trigger instanceof HTMLButtonElement)) {
      console.error("Fleet feature modal was opened without a feature button.");
      return;
    }

    const { featureTitle, featureImage, featureAlt, featureDetails } = trigger.dataset;
    const featureCard = trigger.closest(".fleet-feature-card");
    const cardImage = featureCard?.querySelector(".fleet-feature-image");
    const imageSource = cardImage?.getAttribute("src") || featureImage;
    const imageAlt = cardImage?.getAttribute("alt") || featureAlt;

    if (!featureTitle || !imageSource || !imageAlt || !featureDetails) {
      console.error("Fleet feature button is missing modal content.", trigger);
      return;
    }

    title.textContent = featureTitle;
    image.src = imageSource;
    image.alt = imageAlt;
    description.textContent = featureDetails;
  });
})();
