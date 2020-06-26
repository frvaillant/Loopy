function checkNotification() {
    fetch('/patient/hasNotification')
        .then(response => response.json())
        .then(data => {
            if (data) {
                if (window.confirm('Votre docteur vous à envoyer un email !')) {
                    console.log('toto');
                    fetch('/patient/hasNotification/delete').then(response => response.json())
                        .then(data => {
                            console.log('ok')
                        })
                }
            }
        }).catch(e => {

    })
}
document.addEventListener('DOMContentLoaded', () => {
    checkNotification();
})
