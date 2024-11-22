window.onclick = (e: MouseEvent): void => {
  let element = e.target;
  // Determines if clicked element is a tic-tac-toe cell
  if (element instanceof HTMLElement && element.className === "cell") {
    // Extract row and column data from HTML attributes
    let row = element.getAttribute("data-row");
    let col = element.getAttribute("data-col");

    // Send the clicked cell data to the server via AJAX
    let jsonCellPositionData = JSON.stringify([row, col]);
    let encodedData = encodeURIComponent(jsonCellPositionData);

    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        // The response is a twig template of the updated HTML body
        let body = document.querySelector("body");
        if (body) {
          body.innerHTML = this.responseText;
        }
      }
    };

    // Send post request to the backend PHP file containing data about the cell clicked
    xhttp.open("POST", "./index.php?ts=" + Date.now(), true);

    // Data is send as a key-value pair so that PHP can decode the data using $_REQUEST
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhttp.send("pos=" + encodedData);
  }
};
