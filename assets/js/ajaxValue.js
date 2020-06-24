function ajaxValue() {
    fetch('/check')
        .then(response => response.json())
        .then(data => {
            for (var [key, value] of Object.entries(data)){
                if (document.getElementById(value)) {
                    document.getElementById(value).classList.add = 'bg-primary'
                }
            }
        })
        .catch(() => console.log('toto'))
}

setInterval(ajaxValue, 5000)
