function ajaxValue() {
    fetch('/overvalue/check').then(response => response.json())
        .then(data => {
            console.log(data);
            for (let [key, value] of Object.entries(data)){
                if (document.getElementById(value)) {
                    document.getElementById('label-' + value).classList.add("bck-red")
                }
            }
        })
        .catch(() => console.log('toto'))
}

document.addEventListener('DOMContentLoaded', () => {
    ajaxValue();
})

setInterval(ajaxValue, 6000)
