
jQuery(document).ready(function($){
  $("th").click(function(){
    var table = $(this).parents("table").eq(0)
    var rows = table.find("tr:gt(0)").toArray().sort(comparer($(this).index()))
    this.asc = !this.asc
    if (!this.asc){rows = rows.reverse()}
    for (var i = 0; i < rows.length; i++){table.append(rows[i])}
  })
  function comparer(index) {
    return function(a, b) {
      var valA = getCellValue(a, index), valB = getCellValue(b, index)
      return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
    }
  }
  function getCellValue(row, index){ return $(row).children("td").eq(index).text() }

  
})


  const headers = document.querySelectorAll("th");
  console.log(headers);
  headers.forEach(header => {
    header.addEventListener("click", () => {
      headers.forEach(header => {
        header.querySelector(".sort-up").style.display = "none";
        header.querySelector(".sort-down").style.display = "none";
      });
      const upArrow = header.querySelector(".sort-up");
      const downArrow = header.querySelector(".sort-down");
      if (downArrow.display === "inline" ) {
        downArrow.style.display = "none";
        upArrow.style.display = "inline";
      } 
      else {
        upArrow.style.display = "inline";
      }
    });
  });

