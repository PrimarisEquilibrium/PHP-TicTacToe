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
        console.log(this.responseText);
      }
    };
    xhttp.open("GET", "?pos=" + encodedData, true);
    xhttp.send();
  }
};
