let list = document.getElementsByClassName('list-patient');
for (let i = 0; i < list.length; i ++) {
    list[i].addEventListener('click', (e) => {
        e.preventDefault();
        let id = list[i].getAttribute('id')
        fetch('/patient/overvalue/delete/' + id)
            .then(response => response.json())
            .then( () => {
                let row = document.getElementById('label-' + id)
                row.classList.remove('bck-red');
                window.location.href = '/doctor/patient/' + id

            }).catch(() => console.log('toto'))
    })
}
