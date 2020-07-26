import axios from 'axios';

const API_URL = process.env.VUE_APP_API_URL;

const requestService = {
    get(url, params = {}, headers = {}) {
        return axios.get(API_URL + url, {
            params,
            headers
        });
    }
};

export default requestService;
