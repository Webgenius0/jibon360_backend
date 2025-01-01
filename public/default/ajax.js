fetch("https://api.sms.net.bd/user/balance/?api_key={{env('SMS_API_KEY')}}")
    .then(response => response.json())
    .then(data => {
        if (data.data) {
            document.getElementById('sms').innerHTML = data.data.balance + " tk";
        } else {
            console.log('Balance not found');
        }
    })
    .catch(error => console.log('Error: ' + error));