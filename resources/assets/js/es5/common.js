function ubizapis(version, url, method, data, callback) {

    var protocol = window.location.protocol;
    var hostname = window.location.hostname;
    var base_url = protocol + "//" + hostname + "/api/" + version + "/";

    var options = {
        baseURL: base_url,
        timeout: 1000,
        url: url,
        method: method,
        data: JSON.stringify(data)
    };

    axios(options).then(function (response) {
        console.log(response);
    }).catch(function (error) {
        console.log(error);
    });
}