import axios from 'axios';

const Api = axios.create({
    baseURL: process.env.MIX_APP_URL,
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
        "X-localization": "es"
    }
});

export default Api;
