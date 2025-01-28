function toggleModal(show) {
  const modal = document.getElementById("modal");
  if (show) {
    modal.classList.remove("hidden");
  } else {
    modal.classList.add("hidden");
  }
}
