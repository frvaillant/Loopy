function ajaxValue() {
    fetch('/check')
        .then(response => response.json())
        .then(data => {
            for (let [key, value] of Object.entries(data)){
                if (document.getElementById(value)) {
                    document.getElementById('label-' + value).classList.add("bck-red")
                }
            }
        })
        .catch(() => console.log('toto'))
}

setInterval(ajaxValue, 6000)
