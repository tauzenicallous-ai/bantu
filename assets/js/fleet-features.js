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

    if (!featureTitle || !featureImage || !featureAlt || !featureDetails) {
      console.error("Fleet feature button is missing modal content.", trigger);
      return;
    }

    title.textContent = featureTitle;
    image.src = featureImage;
    image.alt = featureAlt;
    description.textContent = featureDetails;
  });
})();
