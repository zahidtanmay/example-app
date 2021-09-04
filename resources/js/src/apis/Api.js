import axios from "axios";

const headers = {
    'content-type': 'application/json' ,
    'Access-Control-Allow-Origin': '*'
}
const token = localStorage.getItem('authToken')
if (token) {
    headers['Authorization'] = 'Bearer ' + token
}

let Api = axios.create({
    baseURL: "http://localhost/api",
    headers: headers
});

Api.defaults.withCredentials = true;

export default Api;
