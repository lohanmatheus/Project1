const Api = {
    host: 'http://localhost:8000/project1/financa1/conecta.php',
    post: (params) => {
        let bodyRequest = JSON.stringify(params)
        let configRequest = {
            method: 'POST',
            cache: 'default',
            body: bodyRequest,
            headers: {
                'Content-Type': 'application/json'
            }
        }
        let myRequest = new Request(Api.host, configRequest);

        return fetch(myRequest).then(function (response) {
            return response.json();
        })
    }
}