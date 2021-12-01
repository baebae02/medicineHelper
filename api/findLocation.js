function findLocation() {
  const status = document.querySelector("#status");
  const latitudeInput = document.querySelector("#latitude");
  const longitudeInput = document.querySelector("#longitude");

  if (!navigator.geolocation) {
    status.innerText = "Geolocation is not supported by your browser";
  } else {
    status.innerText = "Locating…";
    navigator.geolocation.getCurrentPosition(success, error);
  }

  function error() {
    status.innerText = "Unable to retrieve your location";
  }

  function success(position) {
    const latitude = position.coords.latitude;
    const longitude = position.coords.longitude;

    status.innerText = "";
    latitudeInput.innerText = latitude;
    longitudeInput.innerText = longitude;
  }
}

document
  .querySelector("#find-location")
  .addEventListener("click", findLocation);
