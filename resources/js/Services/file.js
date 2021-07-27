import axios from 'axios';

const ApiFile = axios.create({
    baseURL: process.env.MIX_APP_URL,
    headers: {
        "Content-Type": "multipart/form-data",
        "X-localization": "es"
        // "Authorization": "Bearer " + localStorage.getItem("token")
    }
});

export default ApiFile;