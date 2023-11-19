document.addEventListener("DOMContentLoaded", () => {
    let countryB = document.getElementById("lookup")
    let citiesB = document.getElementById("cities")
    let result = document.getElementById("result")
    let input = document.getElementById("country")
    let countryTable = document.getElementById("countryTable")
    let cityTable = document.getElementById("cityTable")
    let url = `http://localhost/info2180-lab5/world.php`
    
    countryB.addEventListener("click", () => {
        result.textContent = "";
        fetch(url + `?country=${input.value}`)
        .then(Response => Response.text())
        .then(data => {
            result.innerHTML += `${data}`;
            countryTable.style.display = "table";
            cityTable.style.display = "none";
        })
        .catch(error => {
            console.error("Error:", error);
        })
    })

    citiesB.addEventListener("click", () => {
        result.textContent = "";
        fetch(url + `&lookup=cities`)
        .then(Response => Response.text())
        .then(data => {
            result.innerHTML = `${data}`;
            countryTable.style.display = "none";
            cityTable.style.display = "table";
        })
        .catch(error => {
            console.error("Error:", error);
        })
    })
})
